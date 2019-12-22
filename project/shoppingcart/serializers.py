
import logging
import json
from rest_framework import serializers
from rest_framework.renderers import JSONRenderer
from .models import Address,Cart,CartItem,Order,Coupon,Favorite
from lottery_shop.serializers import ProductSerializer,CartItemProductSerializer


logger=logging.getLogger("error_logger")


class AddressSerializer(serializers.ModelSerializer):

    class Meta:
        model = Address
        fields = "__all__"

class CartItemSerializer(serializers.ModelSerializer):
    product= CartItemProductSerializer(read_only=True,many=False)
    class Meta:
        model = CartItem
        fields = "__all__"

    def to_representation(self,instance):
        result=super().to_representation(instance)
        result["sub_total"]=instance.quantity*instance.product.price
        return result


class CartSerializer(serializers.ModelSerializer):
    cartitems=CartItemSerializer(read_only=True,many=True)

    class Meta:
        model = Cart
        fields = ("id","slug","created","cartitems")

class OrderSerializer(serializers.ModelSerializer):
    address=AddressSerializer(read_only=True,many=False)
    cart=CartSerializer(read_only=True,many=False)

    class Meta:
        model = Order
        fields = "__all__"

class OrderListSerializer(serializers.ModelSerializer):
    last_name=serializers.ReadOnlyField(source = "address.last_name")
    first_name=serializers.ReadOnlyField(source = "address.first_name")
    class Meta:
        model = Order
        fields = ["slug","total","discount","tax","logistics","tracking_no","delivered_at",\
            "note","first_name","last_name","created_at","paystatus","paymethod","paid_at"]


class CouponSerializer(serializers.ModelSerializer):
    class Meta:
        model = Coupon
        fields = "__all__"
        # exclude = ['id']

class FavoriteSerializer(serializers.ModelSerializer):
    class Meta:
        model = Favorite
        fields = "__all__"

    def to_representation(self,instance):
        result=super().to_representation(instance)
        result["name"]=instance.product.name
        result["avatar"]=instance.product.thumbimage()
        result["slug"]=instance.product.slug
        return result




