from .models import Order,Offer,Transaction
from .serializers import AdminOrderSerializer,AdminOfferSerializer, \
  PublicOrderSerializer,OfferSerializer,TransactionsSerializer,\
  OrderSerializer_byUser


from rest_framework import viewsets, permissions,status,mixins,generics
from rest_framework.views import APIView
from rest_framework.decorators import list_route,detail_route,permission_classes,api_view
from rest_framework.response import Response
from django.dispatch import receiver
from django.db.models.signals import post_save
from django.http import Http404
from django.conf import settings
from django.core import serializers
from django.db.models import Count,Sum,Min,Max,Q
import decimal
import logging
import datetime
import json
from django.core.cache import cache
from musics.tasks import sendEmail_OrderOwner_OfferChange
from .models import Offer,Order
from env_system.permissions import IsOwnerOrReadOnly,IsAdminOrOwner,IsAdmin,IsAdminOrReadOnly



logger=logging.getLogger("error_logger")

@receiver(post_save, sender=Offer)
def create_enrolled_record(sender, instance=None, created=False, **kwargs):
    # url='http://{%s}/exrate/#/singleorder/{%s}'%(settings.HOSTNAME,instance.order.slug)
    logger.error("in create_enrolled_record function: %s"%(instance.order.slug))
    
    sendEmail_OrderOwner_OfferChange.delay(instance.order.slug)




class IsOwnerOrReadOnly(permissions.BasePermission):
    def has_object_permission(self, request, view, obj):
        if request.method in permissions.SAFE_METHODS:
            return True
        return obj.user == request.user

# mixins.ListModelMixin,mixins.CreateModelMixin,
#   mixins.RetrieveModelMixin,mixins.DestroyModelMixin,viewsets.GenericViewSet

class OrderViewSet(mixins.ListModelMixin,mixins.CreateModelMixin,viewsets.GenericViewSet):
    """ViewSet for the Bill class"""

    queryset = Order.objects.all()
    serializer_class = PublicOrderSerializer
    permission_classes = [permissions.IsAuthenticated,IsOwnerOrReadOnly]


    # Public related Order API
    def list(self, request):


      auction_publicOrders=cache.get("auction_publicOrders_%s"%(request.user.id))

      order_summary=Order.objects.filter(privacy="public",status__in=["new","Matching"],due_at__gte=datetime.date.today()).values("from_currency").annotate(count=Count("amount"),
        sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

      if auction_publicOrders:
          return Response({
              "error":0,
              "type": "cached mail_exchange_public_orders",
              "summary":order_summary,
              "orders":auction_publicOrders
          },status=status.HTTP_200_OK)


      orders = Order.objects.filter(privacy="public",status__in=["new","Matching"],due_at__gte=datetime.date.today()).order_by("-due_at","created")


      serializer=self.serializer_class(orders, context={'user_id': request.user.id},many=True)

      cache.set("auction_publicOrders_%s"%(request.user.id),serializer.data,timeout=300)

      logger.error(orders)
      return Response({
          "error":0,
          "type": "fetch from db mail_exchange_public_orders",
          "summary":order_summary,
          "orders":serializer.data
      },status=status.HTTP_200_OK)

    def create(self,request):

      logger.error("create order request.data")
      logger.error(request.data)

      try:
        from_currency=request.data["from_currency"]

        serializer = self.serializer_class(data=request.data, context={'user_id': request.user.id})

        if serializer.is_valid():
          rate_alpha = settings.ORDER_MARGINRATE_JPY if from_currency=="jpy" else settings.ORDER_MARGINRATE_RMB
          serializer.save(user=request.user,rate_alpha=rate_alpha)
          
          cache.delete("auction_publicOrders")

          return Response({
                "result":True,
                "order":serializer.data
            })
        else:
          return Response({
                "result":False,
                "message":serializer.error
            })
      except KeyError:
          return Response({
                "result":False,
                "message":"KeyError"
            })

    @list_route(methods=['post'])
    def getOrderBySlug(self,request,format=None):        
      content={
          "result":False,
          "slug":"",
          "order":{},
          "offers":{},
          "message":""
      }
      try:

        search_slug=request.data.get("slug",None)
        content["slug"]=search_slug

        if search_slug:

           try:
             order=Order.objects.get(slug=search_slug)
             serializer_order=self.serializer_class(order, context={'user_id': request.user.id},many=False)

             offers=Offer.objects.filter(order_id=order.id)
             offer_context={
                "IsOrderUser": True if request.user==order.user else False,
                "offer_alpha": order.price_alpha - order.price
              }
             logger.error(offer_context)
             serializer_offers=OfferSerializer(offers, context=offer_context,many=True)
           except Order.DoesNotExist:
             return Response({
                  "result":False,
                  "slug":"",
                  "order":{},
                  "offers":{},
                  "message":"order doesn't exist"
              })
        return Response({
            "result":True,
            "slug":search_slug,
            "order":serializer_order.data,
            "offers":serializer_offers.data,
            "message":"fetch order successfully"
        })
      except KeyError:
       return Response({
            "result":False,
            "slug":"",
            "order":{},
            "offers":{},
            "message":"need order slug"
        })
      else:
        raise Http404



    # Admin related Order API
    @list_route(methods=["post"],permission_classes=[IsAdmin,])
    def AdminOrdersList(self,request,format=None):
      orders = Order.objects.all().order_by("-created","-due_at","from_currency","amount")
      order_summary=Order.objects.all().values("from_currency").annotate(count=Count("amount"),
        sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

      serializer=AdminOrderSerializer(orders,many=True)

      return Response({
          "error":0,
          "type": "list",
          "summary":order_summary,
          "orders":serializer.data
      },status=status.HTTP_200_OK)


    @list_route(methods=['post'],permission_classes=[IsAdmin,])
    def AdminSingleOrder(self,request,format=None):

        isOrderOwner=False
        serializer_transaction=None

        try:
          search_slug=request.data["slug"]
          content={
              "error":True,
              "slug":search_slug,
              "order":{},
              "offers":{},
              "Transaction":serializer_transaction,
              "alpha":0,
              "isOrderOwner":isOrderOwner,
          }

          order=Order.objects.filter(slug=search_slug).first()
          if order:
              isOrderOwner = True if order.user==request.user else False
              offers=Offer.objects.filter(order_id=order.id)
              serializer_order=AdminOrderSerializer(order,many=False)
              serializer_offers=AdminOfferSerializer(offers,many=True)

              content={
                  "error":False,
                  "slug":search_slug,
                  "admin_order":serializer_order.data,
                  "admin_offers":serializer_offers.data,
                  "isOrderOwner":isOrderOwner
              }

              return Response(content)

        except KeyError:
          raise Http404

    @list_route(methods=['post'],permission_classes=[IsAdmin,])
    def AdminSingleOrderUpdate(self,request,format=None):

        try:
          search_slug=request.data["slug"]
          update_type=request.data["update_type"]
          content={
              "result":False,
              "slug":search_slug,
              "order":{},
          }
        except KeyError:
          return Response({
                "result":False,
                "message":"KeyError, need slug",
            },status=status.HTTP_404_NOT_FOUND)

        try:
          order=Order.objects.get(slug=search_slug)

          serializer=AdminOrderSerializer(order,data=request.data,many=False,partial=True)

          if serializer.is_valid():
              serializer.save()

              content={
                  "result":True,
                  "slug":search_slug,
                  "update_type":update_type,
                  "order":serializer.data,
              }

              return Response(content,status=status.HTTP_200_OK)
          else:
              return Response({
                  "result":False,
                  "message":serializer.errors
              },status=status.HTTP_200_OK)
        except Order.DoesNotExist:
            return Response({
                "result":False,
                "message":"No Order with slug exist!",
            },status=status.HTTP_404_NOT_FOUND)



    @list_route(methods=['post'],permission_classes=[IsAdmin,])
    def deleteOrderBySlug(self,request):
      try:
        order_slug=request.data.get("slug",None)
        order=Order.objects.get(slug=order_slug)

        order.delete()

        return Response({
            "result":True,
            "order_slug":order_slug,
            "message":"order deleted"
          })
      except KeyError:
          return Response({
              "result":False,
              "message":"KeyError order_slug"
            })
      except Order.DoesNotExist:
          return Response({
              "result":False,
              "order_slug":order_slug,
              "message":"order doesn't exist"
            })

    @detail_route(methods=['post'])
    def update_order(self, request, pk, format=None):
        logger.error("order put")
        order = Order.objects.get(pk=pk)
        serializer = SimpleOrderSerializer(order, data=request.data)
        if serializer.is_valid():
            serializer.save()
            context={
                "result":True,
                "data":serializer.data,
                "errors":serializer.errors,
                "type":"order put"
              }

            logger.error(context)
            return Response(context)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)


    # @list_route(methods=["post"])
    # def list_user_orders(self,request,format=None):
    #   orders=Order.objects.filter(user=request.user)
    #   order_summary=Order.objects.filter(user=request.user).values("from_currency").annotate(count=Count("amount"),
    #     sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))


    #   content={
    #     "success":0,
    #     "message":"message",
    #     "summary":order_summary,
    #     "orders":{}
    #   }

    #   if orders:
    #     serializer=OrderSerializer(orders,many=True)

    #     content={
    #       "success":1,
    #       "message":"orders of {}".format(request.user.username),
    #       "summary":order_summary,
    #       "orders":serializer.data
    #     }
    #     return Response(content,status=status.HTTP_200_OK)

    #   return Response(content,status=status.HTTP_404_NOT_FOUND)


    # @list_route(methods=["post"])
    # def Dashboard_summary(self,request,format=None):
    #   order_summary=Order.objects.filter(status="new",due_at__gte=datetime.date.today()).values("from_currency").annotate(count=Count("amount"),
    #     sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

    #   if order_summary:

    #     content={
    #       "result":1,
    #         "data":{
    #           "summary":order_summary,
    #         }
    #     }
    #     return Response(content,status=status.HTTP_200_OK)

    #   else:
    #       content={
    #         "result":0,
    #         "data":{
    #           "summary":{},
    #         }
    #       }
          
    #       return Response(content,status=status.HTTP_200_OK)


    @list_route(methods=["post"])
    def UserOrdersList(self,request,format=None):
      orders = Order.objects.filter(user=request.user).order_by("-due_at","created")
      logger.error(orders)
      serializer=PublicOrderSerializer(orders, context={'user_id': request.user.id},many=True)

      order_summary=Order.objects.filter(user=request.user).values("from_currency").annotate(count=Count("amount"),
        sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

      content={
        "result":True,
        "message":"message",
        "orders":serializer.data,
        "order_summary":order_summary
      }
      return Response(content,status=status.HTTP_200_OK)


    # @list_route(methods=["post"])
    # def PublicOrdersList(self,request,format=None):
    #   orders = Order.objects.filter(due_at__gte=datetime.date.today()).order_by("-due_at","from_currency","amount")
    #   order_summary=Order.objects.filter(due_at__gte=datetime.date.today()).values("from_currency").annotate(count=Count("amount"),
    #     sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

    #   for order in orders:
    #     if order.user_id == request.user.id:
    #       pass
    #     else:
    #       if order.from_currency == "jpy":
    #         order.rate +=decimal.Decimal(settings.ORDER_MARGINRATE_JPY)
    #       else:
    #         order.rate -=decimal.Decimal(settings.ORDER_MARGINRATE_RMB)

    #   try:
    #     OrderType=request.data["OrderType"]
    #     serializer=OrderSerializer_withOffers(orders,many=True)
    #   except KeyError:
    #     serializer=PureOrderSerializer(orders,many=True)

    #   return Response({
    #       "error":0,
    #       "type": "list",
    #       "summary":order_summary,
    #       "orders":serializer.data
    #   },status=status.HTTP_200_OK)




class OfferViewSet(mixins.ListModelMixin,mixins.CreateModelMixin,viewsets.GenericViewSet):
    """ViewSet for the Bill class"""

    queryset = Offer.objects.all()
    serializer_class = OfferSerializer
    permission_classes = [permissions.IsAuthenticated]

    def create(self, request):

      try:

        order_id=request.data.get('order_id')
        follower_id=request.data.get('follower_id')
        currency=request.data.get('currency')
      except KeyError:
        return Response({
              "result":False,
              "request":request.data
          })

      content={
        "result":0,
        "data":{},
        "offer":{},
        "request":request.data
      }

      offer_context={
            "IsOrderUser": False,
            "offer_alpha": 0
          }

      serializer=OfferSerializer(data=request.data,context=offer_context)

      if serializer.is_valid():
          serializer.save(follower_id=request.user.id,order_id=order_id)
          
          content={
            "result":True,
            "offer":serializer.data
          }

          return Response(content,status=status.HTTP_200_OK)


      return Response(content,status=status.HTTP_404_NOT_FOUND)

    @detail_route(methods=["post"])
    def update_orderoffer(self, request, pk=None):

      try:
        follower_id=request.data.get('follower_id', 1)
        offer_id=request.data.get('offer_id', 1)
        price=request.data.get('price', 1)
      except KeyError:
        return Response({
              "result":False,
              "request":request.data
          })


      try:

        offer=Offer.objects.get(pk=pk)

        if offer:
          offer.price=price
          offer.save()
          
          offer_context={
                "IsOrderUser": False,
                "offer_alpha": 0
              }

          serializer=OfferSerializer(offer,context=offer_context,many=False)

          content={
            "result":True,
            "order_id":pk,
            "offer":serializer.data
          }

          return Response(content,status=status.HTTP_200_OK)
      except Offer.DoesNotExist:
          content={
            "result":False,
            "order_id":pk,
            "message":"No Offer with id: %d found."%int(pk)
          }
          return Response(content,status=status.HTTP_404_NOT_FOUND)


    @list_route(methods=["post"],permission_classes=[IsAdmin,])
    def AdminDeleteOrder(self, request, pk=None):

      logger.error("AdminDeleteOrder")
      try:
        offer_params=request.data["offer"]

        offer=Offer.objects.get(pk=offer_params["id"])
        order = Order.objects.get(pk=offer_params["order"])

        if offer_params["status"] == "Matching":
          transaction= Transaction.objects.get(order__id=offer_params["order"],offer__id=offer_params["id"])
          transaction.delete()

          offer.delete()

          order.status = "new"
          order.save()
          return Response({
              "result":True,
              "status":"Matching",
              "message":"delete successfully"
            },status=status.HTTP_200_OK)
        else:
          offer.delete()
          return Response({
              "result":True,
              "status":"Matching",
              "message":"delete successfully"
            },status=status.HTTP_200_OK)

      except KeyError:
          return Response({
              "result":False,
              "message":"KeyError"
            },status=status.HTTP_200_OK)
      # follower_id=request.data.get('follower_id', 1)
      # offer_id=request.data.get('offer_id', 1)
      # price=request.data.get('price', 1)



      # try:

      #   offer=Offer.objects.get(pk=pk)

      #   if offer:
      #     offer.price=price
      #     offer.save()
          
      #     offer_context={
      #           "IsOrderUser": False,
      #           "offer_alpha": 0
      #         }

      #     serializer=OfferSerializer(offer,context=offer_context,many=False)

      #     content={
      #       "result":True,
      #       "order_id":pk,
      #       "offer":serializer.data
      #     }

      #     return Response(content,status=status.HTTP_200_OK)
      # except Offer.DoesNotExist:
      #     content={
      #       "result":False,
      #       "order_id":pk,
      #       "message":"No Offer with id: %d found."%int(pk)
      #     }
      #     return Response(content,status=status.HTTP_404_NOT_FOUND)



    @list_route(methods=["post"])
    def list_user_offers(self,request,format=None):
      offers=Offer.objects.filter(follower=request.user)
      offer_summary=Offer.objects.filter(follower=request.user).values("currency").annotate(sum=Sum("price"),count=Count("price"),max=Max("price"),min=Min("price"))
      # offer_summary=Offer.objects.filter(follower=request.user).values("currency").annotate(sum=Sum("price"))
      content={
        "success":0,
        "message":"message",
        "offers":{},
        "offer_summary":offer_summary
      }
      offer_context={
        "IsOrderUser": True ,
        "offer_alpha": 0
      }
      if offers:
        serializer=OfferSerializer(offers,context=offer_context,many=True)

        content={
          "success":1,
          "message":"offers of {}".format(request.user.username),
          "offers":serializer.data,
          "offer_summary":offer_summary
        }
        return Response(content,status=status.HTTP_200_OK)

      return Response(content,status=status.HTTP_200_OK)


class TransactionViewSet(viewsets.ModelViewSet):
    queryset = Transaction.objects.all()
    serializer_class = TransactionsSerializer
    permission_classes = [permissions.IsAuthenticated]


    def get_object(self, pk):
        try:
            return Transaction.objects.get(pk=pk)
        except Transaction.DoesNotExist:
            raise Http404

    
    def retrieve(self, request, pk=None):
        transaction = self.get_object(pk)
        serializer = TransactionsSerializer(transaction)
        return Response(serializer.data)

    def create(self,request,format=None):
        data=request.data

        # if order and offer Exist
        order_id=data["order_id"]
        offer_id=data["offer_id"]

        content={
            "type":"create",
            "result":0,
            "data":{}
            }

        transaction=Transaction.objects.filter(Q(order_id=order_id) & Q(offer_id=offer_id)).first()


        if transaction:
          serializer=TransactionsSerializer(transaction,data=data)
        else:
          serializer=TransactionsSerializer(data=data)

        if serializer.is_valid():
            order=Order.objects.get(pk=order_id)
            offer=Offer.objects.get(pk=offer_id)

            if order and offer:
              order.status="Matching"
              order.save()

              offer.status="Matching"
              offer.save()
              serializer.save(order=order,offer=offer)

              content={
                "type":"createTransaction",
                "result":True,
                "transaction":serializer.data
              }



        return Response(content)

    def get(self, request, pk, format=None):
        content={
          "type":"get"
        }
        return Response(content)
        transaction = self.get_object(pk)
        serializer = TransactionsSerializer(transaction)
        return Response(serializer.data)

    def put(self, request, pk, format=None):
        transaction = self.get_object(pk)
        serializer = TransactionsSerializer(transaction, data=request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

    def delete(self, request, pk, format=None):
        transaction = self.get_object(pk)
        transaction.delete()
        return Response(status=status.HTTP_204_NO_CONTENT)

    @list_route(methods=["post"])
    def list_user_transactions_byOrder(self,request,format=None):
      transactions=Transaction.objects.filter(order__user_id=request.user.id)

      content={
        "success":0,
        "message":"message",
        "transactions":{}
      }

      if transactions:
        serializer=TransactionsSerializer(transactions,many=True)
        content={
          "success":1,
          "message":"transactions of {}".format(request.user.username),
          "transactions":serializer.data
        }
        return Response(content,status=status.HTTP_200_OK)

      return Response(content,status=status.HTTP_404_NOT_FOUND)

    @list_route(methods=["post"])
    def list_user_transactions_byOffer(self,request,format=None):
      transactions=Transaction.objects.filter(offer__follower_id=request.user.id)

      content={
        "success":0,
        "message":"message",
        "transactions":{}
      }

      if transactions:
        serializer=TransactionsSerializer(transactions,many=True)

        content={
          "success":1,
          "message":"transactions of {}".format(request.user.username),
          "transactions":serializer.data
        }
        return Response(content,status=status.HTTP_200_OK)

      return Response(content,status=status.HTTP_404_NOT_FOUND)

