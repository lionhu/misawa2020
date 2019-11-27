from .models import Order,Offer,Transaction
from .serializers import OrderSerializer,OfferSerializer,PureOrderSerializer, \
          TransactionsSerializer,OrderSerializer_withOffers_byUser,OrderSerializer_byUser, \
          OfferSerializer_withOrder,PublicOrders_Serializer,OrderSerializer_withOffers,\
          SimpleOrderSerializer,UserOfferSerializer
from rest_framework import viewsets, permissions,status
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


class OrderViewSet(viewsets.ModelViewSet):
    """ViewSet for the Bill class"""

    queryset = Order.objects.all()
    serializer_class = OrderSerializer
    permission_classes = [permissions.IsAuthenticated,IsOwnerOrReadOnly]

    def list(self, request):

      cache_orders=cache.get("mail_exchange_public_orders")
      # cache_ordersummary=cache.get("mail_exchange_public_ordersummary")
      order_summary=Order.objects.filter(status__in=["new","Matching"],due_at__gte=datetime.date.today()).values("from_currency").annotate(count=Count("amount"),
        sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

      if cache_orders:
          return Response({
              "error":0,
              "type": "cached mail_exchange_public_orders",
              "summary":order_summary,
              "orders":cache_orders
          },status=status.HTTP_200_OK)


      orders = Order.objects.filter(status__in=["new","Matching"],due_at__gte=datetime.date.today()).order_by("-due_at","created")
      # order_summary=Order.objects.filter(status__in=["new","Matching"],due_at__gte=datetime.date.today()).values("from_currency").annotate(count=Count("amount"),
        # sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

      serializer=PublicOrders_Serializer(orders,many=True)
      # serializer=PublicOrders_Serializer(orders,many=True,extra={"user_id":request.user.id})


      cache_orders=serializer.data
      # cache_ordersummary=serializers.serialize("json",order_summary)

      cache.set("mail_exchange_public_orders",cache_orders,timeout=300)

      # cache.set("mail_exchange_public_ordersummary",cache_ordersummary,timeout=300)

      logger.error(orders)
      return Response({
          "error":0,
          "type": "fetch from db mail_exchange_public_orders",
          "summary":order_summary,
          "orders":serializer.data
      },status=status.HTTP_200_OK)


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

    @list_route(methods=['post'])
    def get_order_by_slug(self,request,format=None):

        search_slug=request.data["slug"]
        isOrderOwner=False
        hasOrderOffer=False
        serializer_transaction=None

        content={
            "error":True,
            "slug":search_slug,
            "order":{},
            "offers":{},
            "Transaction":serializer_transaction,
            "alpha":0,
            "isOrderOwner":isOrderOwner,
            "hasOrderOffer":hasOrderOffer
        }

        if search_slug:
           order=Order.objects.filter(slug=search_slug).first()

           if order:
              isOrderOwner = True if order.user_id==request.user.id else False
              offers=Offer.objects.filter(order_id=order.id)

              alpha_rate=order.rate*(order.rate-decimal.Decimal(settings.ORDER_MARGINRATE_RMB))*10
              alpha = settings.ORDER_MARGINRATE_JPY*order.amount*100 if order.from_currency=="jpy" else int(order.amount*settings.OFFER_MARGIN_JPY/alpha_rate)
                  
              if isOrderOwner:
                for offer in offers:
                  offer.price -= alpha
              else:
                if order.from_currency == "jpy":
                  order.rate +=decimal.Decimal(settings.ORDER_MARGINRATE_JPY)
                else:
                  order.rate -=decimal.Decimal(settings.ORDER_MARGINRATE_RMB)

              serializer_order=OrderSerializer(order,many=False)
              serializer_offers=OfferSerializer(offers,many=True)

              if order.transactions.count():
                serializer_transaction=TransactionsSerializer(order.transactions.first(),many=False)

              content={
                  "error":False,
                  "slug":search_slug,
                  "order":serializer_order.data,
                  "offers":serializer_offers.data,
                  "transaction":serializer_transaction.data if serializer_transaction else {},
                  "alpha":alpha,
                  "isOrderOwner":isOrderOwner,
                  "hasOrderOffer":hasOrderOffer
              }

        return Response(content)

    @list_route(methods=["post"])
    def list_user_orders(self,request,format=None):
      orders=Order.objects.filter(user=request.user)
      order_summary=Order.objects.filter(user=request.user).values("from_currency").annotate(count=Count("amount"),
        sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))


      content={
        "success":0,
        "message":"message",
        "summary":order_summary,
        "orders":{}
      }

      if orders:
        serializer=OrderSerializer(orders,many=True)

        content={
          "success":1,
          "message":"orders of {}".format(request.user.username),
          "summary":order_summary,
          "orders":serializer.data
        }
        return Response(content,status=status.HTTP_200_OK)

      return Response(content,status=status.HTTP_404_NOT_FOUND)


    @list_route(methods=["post"])
    def Dashboard_summary(self,request,format=None):
      order_summary=Order.objects.filter(status="new",due_at__gte=datetime.date.today()).values("from_currency").annotate(count=Count("amount"),
        sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

      if order_summary:

        content={
          "result":1,
            "data":{
              "summary":order_summary,
            }
        }
        return Response(content,status=status.HTTP_200_OK)

      else:
          content={
            "result":0,
            "data":{
              "summary":{},
            }
          }
          
          return Response(content,status=status.HTTP_200_OK)


    @list_route(methods=["post"])
    def UserOrdersList(self,request,format=None):

      OrderType=request.data["OrderType"]

      if OrderType=="withOffers":
        serializer=OrderSerializer_withOffers_byUser(request.user,many=False)
      else:
        serializer=OrderSerializer_byUser(request.user,many=False)

      order_summary=Order.objects.filter(user=request.user).values("from_currency").annotate(count=Count("amount"),
        sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

      content={
        "success":0,
        "message":"message",
        "data":serializer.data,
        "order_summary":order_summary
      }
      return Response(content,status=status.HTTP_200_OK)


    @list_route(methods=["post"])
    def PublicOrdersList(self,request,format=None):
      orders = Order.objects.filter(due_at__gte=datetime.date.today()).order_by("-due_at","from_currency","amount")
      order_summary=Order.objects.filter(due_at__gte=datetime.date.today()).values("from_currency").annotate(count=Count("amount"),
        sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

      for order in orders:
        if order.user_id == request.user.id:
          pass
        else:
          if order.from_currency == "jpy":
            order.rate +=decimal.Decimal(settings.ORDER_MARGINRATE_JPY)
          else:
            order.rate -=decimal.Decimal(settings.ORDER_MARGINRATE_RMB)

      try:
        OrderType=request.data["OrderType"]
        serializer=OrderSerializer_withOffers(orders,many=True)
      except KeyError:
        serializer=PureOrderSerializer(orders,many=True)

      return Response({
          "error":0,
          "type": "list",
          "summary":order_summary,
          "orders":serializer.data
      },status=status.HTTP_200_OK)


    @list_route(methods=["post"],permission_classes=[IsAdmin,])
    def AdminOrdersList(self,request,format=None):
      orders = Order.objects.all().order_by("-created","-due_at","from_currency","amount")
      order_summary=Order.objects.all().values("from_currency").annotate(count=Count("amount"),
        sum=Sum("amount"),max_rate=Max("rate"),min_rate=Min("rate"))

      try:
        OrderType=request.data["OrderType"]
        serializer=OrderSerializer_withOffers(orders,many=True)
      except KeyError:
        serializer=PureOrderSerializer(orders,many=True)

      return Response({
          "error":0,
          "type": "list",
          "summary":order_summary,
          "orders":serializer.data
      },status=status.HTTP_200_OK)


class OfferViewSet(viewsets.ModelViewSet):
    """ViewSet for the Bill class"""

    queryset = Offer.objects.all()
    serializer_class = OfferSerializer
    permission_classes = [permissions.IsAuthenticated]

    def create(self, request):

      offer_id=request.data.get('offer_id')
      follower_id=request.data.get('follower_id')
      currency=request.data.get('currency')

      content={
        "result":0,
        "data":{},
        "offer":{},
        "request":request.data
      }

      try:
        offer=Offer.objects.get(pk=offer_id)
        serializer=OfferSerializer_withOrder(offer,data=request.data)
      except Offer.DoesNotExist:
        serializer=OfferSerializer_withOrder(data=request.data)

      logger.error("offer input is valid: %s"%serializer.is_valid())
      if serializer.is_valid():
          # serializer.save()
          if follower_id is None:
              serializer.save(follower_id=request.user.id)
          else:
              serializer.save()
          
          content={
            "result":1,
            "offer":serializer.data
          }

          return Response(content,status=status.HTTP_200_OK)


      return Response(content,status=status.HTTP_404_NOT_FOUND)

    @detail_route(methods=["post"])
    def update_orderoffer(self, request, pk=None):

      follower_id=request.data.get('follower_id', 1)
      offer_id=request.data.get('offer_id', 1)
      price=request.data.get('price', 1)



      try:

        offer=Offer.objects.get(pk=pk)

        if offer:
          offer.price=price
          offer.save()
          serializer=OfferSerializer(offer,many=False)

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

      if offers:
        serializer=UserOfferSerializer(offers,many=True)

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

            # update order's status
            order=Order.objects.get(pk=order_id)
            offer=Offer.objects.get(pk=offer_id)

            if order and offer:
              order.status="Matching"
              order.save()

              offer.status="Matching"
              offer.save()

              content={
                "type":"createTransaction",
                "result":1,
                "data":data
              }

              serializer.save()

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

