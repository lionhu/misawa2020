
import logging
import json
from rest_framework import serializers
from rest_framework.renderers import JSONRenderer
from .models import Address,Cart,CartItem,Order,Coupon
from lottery_shop.serializers import ProductSerializer


logger=logging.getLogger("error_logger")

        
class AddressSerializer(serializers.ModelSerializer):

    class Meta:
        model = Address
        fields = "__all__"
        
class CartItemSerializer(serializers.ModelSerializer):
    product= ProductSerializer(read_only=True,many=False)
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
        # exclude = ['cartjson']

class CouponSerializer(serializers.ModelSerializer):
    class Meta:
        model = Coupon
        fields = "__all__"
        # exclude = ['id']

