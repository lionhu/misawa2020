
from rest_framework import viewsets, permissions,status
from django.views.decorators.csrf import csrf_exempt
from rest_framework import viewsets,mixins,generics
from django.shortcuts import get_object_or_404
from rest_framework import parsers
from rest_framework.permissions import IsAuthenticated,BasePermission,SAFE_METHODS,AllowAny
from rest_framework.decorators import list_route,detail_route,permission_classes,api_view,action
from rest_framework.response import Response
from django.dispatch import receiver
from django.db.models.signals import post_save
from django.http import Http404
from django.conf import settings
from django.db.models import Count,Sum,Min,Max,Q
import decimal
import logging
from datetime import datetime
import json
from .permissions import IsOwnerOrReadOnly,IsAdminOrOwner,IsAdmin
from .serializers import AddressSerializer,CartSerializer,CartItemSerializer,OrderSerializer,ProductSerializer,CouponSerializer
from .models import Address,Cart,CartItem,Order,Coupon
from lottery_shop.models import Product
from env_system.ColoPayApiRequest import ColoPayApiRequest
from channels.layers import get_channel_layer
from asgiref.sync import async_to_sync
from pyzbar.pyzbar import decode
from PIL import Image


logger=logging.getLogger("error_logger")


class AddressViewSet(viewsets.ModelViewSet):
    queryset = Address.objects.all()
    serializer_class = AddressSerializer
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,IsAdminOrOwner)
    lookup_field="slug"


    # def perform_create(self,serializer):
    #     serializer.save(owner=self.request.user)

    def create(self, request):
        serializer=AddressSerializer(data=request.data)

        if serializer.is_valid():
            serializer.save(user=self.request.user)

            return Response({
                "result":True,
                "type":"create address",
                "message":"successfully add new address",
                "address":serializer.data
            }, status=status.HTTP_200_OK)

        return Response({
            "result":False,
            "type":"create address",
            "message":"invalid address information",
            "address":{}
        }, status=status.HTTP_400_BAD_REQUEST)

    def destroy(self, request,slug=None):
        address=Address.objects.filter(slug=slug).first()

        if address is not None:
            address.delete()
            return Response({
                "result":True,
                "type":"destroy address",
                "message":"address deleted",
                "slug":slug
            }, status=status.HTTP_200_OK)

        return Response({
            "result":False,
            "type":"destroy address",
            "message":"address is not deleted",
            "slug":slug
        }, status=status.HTTP_400_BAD_REQUEST)

    def partial_update(self, request,slug=None):
        address=Address.objects.filter(slug=slug).first()
        serializer=AddressSerializer(address,data=request.data,partial=True)

        logger.error(address)
        logger.error(serializer)
        if serializer.is_valid():
            serializer.save()

            return Response({
                "result":True,
                "type":"partial_update",
                "message":"address is partial_updated",
                "address":serializer.data
            }, status=status.HTTP_200_OK)
        else:
            logger.error(serializer.errors)


        return Response({
            "result":False,
            "type":"partial_update",
            "message":"address is not partial_updated",
            "address":{}
        }, status=status.HTTP_400_BAD_REQUEST)

    @action(detail=False,methods=["post"])
    def retrieveByPhone(self,request):
        
        try:
            phone=request.data["phone"]

            address=Address.objects.filter(phone=phone).first()

            if address is not None:
                serializer=AddressSerializer(address,many=False)

                return Response({
                    "result":True,
                    "type":"create address",
                    "message":"invalid address information",
                    "address":serializer.data
                }, status=status.HTTP_200_OK)
            else:
                raise Http404
        except KeyError:
            raise Http404


class CartViewSet(mixins.ListModelMixin,mixins.CreateModelMixin,mixins.RetrieveModelMixin,mixins.DestroyModelMixin,viewsets.GenericViewSet):
    queryset = Cart.objects.all()
    serializer_class = CartSerializer
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,IsAdminOrOwner)
    lookup_field="slug"


    def perform_create(self,serializer):
        serializer.save(user=self.request.user)

    def get_active_cart(self,request):

        cart=Cart.objects.filter(user=request.user,status="new").first()

        if cart is None:
            cart=Cart.objects.create(user=request.user)

        return cart

    def list(self,request):

        cart=self.get_active_cart(request)

        serializer=CartSerializer(cart)

        return Response({
            "result":True,
            "type":"get mine cart",
            "message":"get mine cart",
            "cart":serializer.data
        }, status=status.HTTP_200_OK)

    def destroy(self, request,slug=None):

        cart=Cart.objects.filter(user=request.user).first()

        if cart is not None:

            cart.delete()

        return Response({
            "result":True,
            "type":"destroy mine cart",
            "message":"destroy mine cart",
            "cart":{}
        }, status=status.HTTP_200_OK)


class CartItemViewSet(mixins.ListModelMixin,viewsets.GenericViewSet):
    queryset = CartItem.objects.all()
    serializer_class = CartItemSerializer
    permission_classes = (permissions.IsAuthenticated,IsAdminOrOwner)
    lookup_field="slug"

    def get_active_cart(self,request):

        cart=Cart.objects.filter(user=request.user,status="new").first()

        if cart is None:
            cart=Cart.objects.create(user=request.user)

        return cart

    def check_product_stock(self,product_slug,quantity):
        product=Product.objects.filter(slug=product_slug).first()
        return True if product.stock-quantity >=0 else False


    @action(detail=False,methods=["post"], permission_classes=[permissions.IsAuthenticated])
    def add(self,request):
        cart=self.get_active_cart(request)
        try:
            product = Product.objects.filter(slug=request.data["product_slug"]).first()
            quantity=request.data["quantity"]
        except KeyError:
            return Response({
                "result":False,
                "type":"create cartitem",
                "message":"KeyError product_slug"
            }, status=status.HTTP_200_OK)
        except Product.DoesNotExist:
            return Response({
                "result":False,
                "type":"create cartitem",
                "message":"Product DoesNotExist"
            }, status=status.HTTP_200_OK)

        logger.error(self.check_product_stock(product.slug,quantity))

        if self.check_product_stock(product.slug,quantity):

            cartitem=CartItem.objects.filter(cart=cart,product=product,active=True).first()

            if cartitem is None:
                cartitem=CartItem.objects.create(cart=cart,product=product,quantity=quantity)
            else:
                cartitem.quantity=request.data["quantity"]+cartitem.quantity
                cartitem.save()

            product.stock -=quantity
            product.save()

            serializer=CartSerializer(cart)
            serializer_product=ProductSerializer(product)

            return Response({
                "result":True,
                "type":"create cartitem successfully",
                "message":"create cartitem successfully",
                "cart":serializer.data,
                "product":serializer_product.data
            }, status=status.HTTP_200_OK)

        else:
            serializer=CartSerializer(cart)
            serializer_product=ProductSerializer(product)

            return Response({
                "result":False,
                "type":"create cartitem successfully",
                "message":"Out of stock",
                "cart":serializer.data,
                "product":serializer_product.data
            }, status=status.HTTP_200_OK)

    @action(detail=False,methods=["post"], permission_classes=[permissions.IsAuthenticated])
    def remove(self,request):
        cart=self.get_active_cart(request)

        try:
            product_slug=request.data["product_slug"]
            quantity=request.data["quantity"]
            product = Product.objects.filter(slug=product_slug).first()
        except KeyError:
            return Response({
                "result":False,
                "type":"add cartitem",
                "message":"KeyError"
            }, status=status.HTTP_200_OK)
        except Product.DoesNotExist:
            return Response({
                "result":False,
                "type":"add cartitem",
                "message":"Product DoesNotExist"
            }, status=status.HTTP_200_OK)

        cartitem=CartItem.objects.filter(product=product,cart=cart).first()
        if cartitem is not None:
            new_quantity=cartitem.quantity - int(quantity)
            logger.error(new_quantity)
            if new_quantity > 0 :
                request.data["quantity"] = new_quantity
                cartitem.quantity=new_quantity
                cartitem.save()

            else:
                cartitem.delete()

            serializer=CartSerializer(cart)

            # restore stock of the product
            product.stock += quantity
            product.save()

            serializer_product=ProductSerializer(product)

            return Response({
                "result":True,
                "type":"remove cartitem from cart ",
                "message":"successfully removed cartitem from cart",
                "cart":serializer.data,
                "product":serializer_product.data
            }, status=status.HTTP_200_OK)
        else:
            raise Http404


    @action(detail=False,methods=["post"], permission_classes=[permissions.IsAuthenticated])
    def remove_fullitem(self,request):
        cart=self.get_active_cart(request)

        try:
            product =get_object_or_404(Product,slug=request.data["product_slug"])
        except KeyError:
            return Response({
                "result":False,
                "type":"remove_fullitem",
                "message":"KeyError"
            }, status=status.HTTP_200_OK)


        cartitem=get_object_or_404(CartItem,product=product,cart=cart)
        if cartitem is not None:

            product.stock +=cartitem.quantity
            product.save()

            cartitem.delete()
            serializer=CartSerializer(cart)

            return Response({
                "result":True,
                "type":"remove_fullitem ",
                "message":"successfully removed cartitem from cart",
                "cart":serializer.data
            }, status=status.HTTP_200_OK)
        else:
            raise Http404

    @action(detail=False,methods=["post"], permission_classes=[permissions.IsAuthenticated])
    def update_item_quantity(self,request):
        cart=self.get_active_cart(request)

        try:
            product =get_object_or_404(Product,slug=request.data["product_slug"])
            quantity =request.data["quantity"]
        except KeyError:
            return Response({
                "result":False,
                "type":"remove_fullitem",
                "message":"KeyError"
            }, status=status.HTTP_200_OK)

        cartitem=CartItem.objects.filter(product=product,cart=cart).first()

        if cartitem is not None:

            if int(quantity)>0:
                diff= quantity-cartitem.quantity

                if diff:
                    logger.error(self.check_product_stock(product.slug,quantity-cartitem.quantity))

                cartitem.quantity=quantity
                cartitem.save()
            else:
                cartitem.delete()

        else:
            if int(quantity)>0:
                CartItem.objects.create(cart=cart,product=product,quantity=quantity)


        serializer=CartSerializer(cart)

        return Response({
            "result":True,
            "type":"remove_fullitem ",
            "message":"successfully removed cartitem from cart",
            "cart":serializer.data
        }, status=status.HTTP_200_OK)


    @action(detail=False,methods=["post"], permission_classes=[permissions.IsAuthenticated])
    def clear(self,request):
        cart=self.get_active_cart(request)

        cartitems=CartItem.objects.filter(cart=cart)
        if cartitems is not None:
            cartitems.delete()

        cart.delete()

        return Response({
            "result":True,
            "type":"clear cart ",
            "message":"successfully clear cart"
        }, status=status.HTTP_200_OK)



class OrderViewSet(mixins.CreateModelMixin,mixins.RetrieveModelMixin,mixins.DestroyModelMixin,viewsets.GenericViewSet):
    queryset = Order.objects.all()
    serializer_class = OrderSerializer
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,IsAdminOrOwner)
    lookup_field="slug"

    def create(self,request):
        try:
            address_param=request.data["address"]
            coupon_id=request.data["coupon"]
            note_param=request.data["note"]
            discount=request.data["discount"]
            existed_customer_param=request.data["existed_customer"]
            existed_customer_slug_param=request.data["existed_customer_slug"]
            cartTax=request.data["cartTax"]
            CartFinalTotal=request.data["CartFinalTotal"]
        except KeyError:
            raise Http404
        
        params={
            "address":address_param,
            "note":note_param,
            "discount":discount,
            "existed_customer":existed_customer_param,
            "existed_customer_slug":existed_customer_slug_param
        }
        logger.error(params)

        address= Address.objects.filter(slug=existed_customer_slug_param).first()

        if address is None:
            address_serializer=AddressSerializer(data=address_param)
        else:
            address_serializer=AddressSerializer(address,data=address_param)

        if address_serializer.is_valid():
            address_serializer.save()

            address=Address.objects.filter(phone=address_param["phone"],postcode=address_param["postcode"]).first()
            logger.error("new address registered")
            logger.error(address)

        cart=get_object_or_404(Cart,user=request.user,status="new")

        serializer=CartSerializer(cart,many=False)
        order=Order.objects.create(user=request.user,total=CartFinalTotal,tax=cartTax,address=address,cart=cart,cartjson=serializer.data,coupon_id=coupon_id,note=note_param,discount=discount)

        cart.status="Placed"
        cart.save()

        cart.cartitems.update(status="Placed")

        return Response({
                "result":True,
                "type":"list shop orders",
                "message":"Shop Orders",
                "order_slug":order.slug,
                "created_at":order.created_at,
                "cart":{}
            }, status=status.HTTP_200_OK)

    @action(detail=True,methods=["post"], permission_classes=[IsAdminOrOwner])
    def bySlug(self,request,slug):
        logger.error(slug)
        order=get_object_or_404(Order,slug=slug)
        self.check_object_permissions(request,order)
        serializer=OrderSerializer(order)
        cart_serializer=CartSerializer(order.cart)

        return Response({
            "result":True,
            "type":"get order by Slug",
            "message":"successfully get order by slug",
            "order":serializer.data,
            "cart":cart_serializer.data
        }, status=status.HTTP_200_OK)

    @action(detail=False,methods=["post"])
    def UserOrderList(self,request):
        orders=Order.objects.filter(user=request.user)

        if orders is not None:
            serializer=OrderSerializer(orders,many=True)

            return Response({
                "result":True,
                "type":"list shop orders",
                "message":"Shop Orders",
                "orders":serializer.data
            }, status=status.HTTP_200_OK)

        else:
            raise Http404


    @action(detail=False,methods=["post"])
    def getPayQR(self,request):

        try:
            order_slug=request.data.get("order_slug",None)
            brandType=request.data.get("brandType",None)
        except KeyError:
            return Response({
                "result":False,
                "QRurl":"",
                "brandType":brandType,
                "message":"ERROR KeyError"
            }, status=status.HTTP_200_OK)


        now = datetime.now()

        try:
            order=Order.objects.get(slug=order_slug)
            paymemocode = now.strftime('%Y%m%d-')+str(order.id)

            if brandType == "CARD":
                return Response({
                    "result":True,
                    "brandType":brandType,
                    "message":"You will receive invoice later. <br>Check your email <br> %s"%(order.user.email)
                }, status=status.HTTP_200_OK)
            elif brandType == "WechatPay":
                payQR = "/static/img/exrate_wechat.jpg"
            elif brandType == "AliPay":
                payQR = "/static/img/AliPay.png"
            elif brandType == "LINE":
                payQR = "/static/img/LINE.png"


            return Response({
                "result":True,
                "QRurl":payQR,
                "paymemocode":paymemocode,
                "brandType":brandType,
                "message":"Successfully fetch PayQR"
            }, status=status.HTTP_200_OK)

        except Order.DoesNotExist:
            logger.error("ERROR DoesNotExist")
            return Response({
                "result":False,
                "brandType":brandType,
                "message":"Order does not exist"
            }, status=status.HTTP_200_OK)



    # @action(detail=False,methods=["post"])
    # def getPayQR(self,request):
    #     order_slug=request.data.get("order_slug",None)
    #     _brandType=request.data.get("brandType",None)
    #     brandType = "01" if _brandType=="AliPay" else "02"

    #     order=get_object_or_404(Order,slug=order_slug)

    #     now = datetime.now()
    #     dt_str = now.strftime('%H:%M:%S')

    #     clientOrderNo=str(request.user.id)+"-"+str(order.id)+"-"+dt_str

    #     re=ColoPayApiRequest()
    #     signature=re.generateSignature(brandType,clientOrderNo,order.total,order.id)

    #     logger.error(signature)
    #     res=re.post()
    #     jss=json.loads(res.text)

    #     if jss["resultType"]=="SUCCESS":
    #         return Response({
    #             "result":True,
    #             "clientOrderNo":clientOrderNo,
    #             "QRurl":jss["result"]["codeUrl"],
    #             "brandType":jss["result"]["brandType"],
    #             "message":"successfully fetch QR from ColoPay GW"
    #         }, status=status.HTTP_200_OK)

    #     return Response({
    #         "result":False,
    #         "clientOrderNo":clientOrderNo,
    #         "QRurl":"",
    #         "brandType":brandType,
    #         "message":"ERROR when fetching QR from ColoPay GW",
    #         "error":res.text
    #     }, status=status.HTTP_200_OK)



    @action(detail=False,methods=["post"],
        parser_classes=[parsers.MultiPartParser,parsers.FormParser],)
    def scanQR(self,request):
        QRType = request.POST.get("QRType")
        order_slug = request.POST.get("order_slug")
        data = decode(Image.open(request.FILES.get("cpm_code")))

        if QRType=="coupon":
            coupon_slug=data[0][0].decode('utf-8', 'ignore')
            coupon = get_object_or_404(Coupon,slug=coupon_slug)

            serializer=CouponSerializer(coupon,many=False)
            
            return Response({
                "result":True,
                "coupon":serializer.data,
                "scanQR":coupon_slug,
            }, status=status.HTTP_200_OK)



        return Response({
            "result":True,
            "order_slug":order_slug,
            "QRCODE":data[0][0].decode('utf-8', 'ignore'),
            "QRType":QRType,
            "message":"ERROR when fetching QR from ColoPay GW",
        }, status=status.HTTP_200_OK)


    @action(detail=False,methods=["post"])
    def callbackPayQR(self,request):
        channel_layer = get_channel_layer()
        async_to_sync(channel_layer.group_send)(
            'shop_publicroom',
            {
                'type': 'chat_message',
                'message': "message",
                'message_type': "message_type",
                'display_mode': "modal"
            }
        )
        return Response({
            "result":False,
            "request":request.data,
            "message":"Callback from ColoPay GW",
        }, status=status.HTTP_200_OK)



class CouponViewSet(mixins.ListModelMixin,mixins.RetrieveModelMixin,viewsets.GenericViewSet):
    queryset = Coupon.objects.all()
    serializer_class = CouponSerializer
    lookup_field="slug"

    @action(detail=False,methods=["post"], permission_classes=[permissions.IsAuthenticated])
    def couponValidate(self,request,slug=None):
        try:
            slug=request.data["slug"]
            coupon=get_object_or_404(Coupon,slug=slug)
            serializer=CouponSerializer(coupon,many=False)
            return Response({
                "result":True,
                "coupon":serializer.data,
                }, status=status.HTTP_200_OK)
        except KeyError:
            raise Http404


