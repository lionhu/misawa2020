from rest_framework import serializers
from rest_framework.renderers import JSONRenderer
from .models import RentalHistory,RentalProduct,ProductRank
from lottery_shop.serializers import ProductSerializer_list
from shoppingcart.serializers import AddressSerializer
import logging
import json
import datetime
from django.conf import settings

logger=logging.getLogger("error_logger")

class FilteredListSerializer(serializers.ListSerializer):

    filter_kwargs = {}

    def to_representation(self, data):
        if not self.filter_kwargs or not isinstance(self.filter_kwargs, dict):
            raise TypeError(_('Invalid Attribute Type: `filter_kwargs` must be a of type `dict`.'))
        data = data.filter(**self.filter_kwargs)
        return super().to_representation(data)

class FutureRentalHistoryListSerializer(FilteredListSerializer):
     filter_kwargs = {'end_at__gte': datetime.datetime.now(),"status__in":settings.IN_RENTAL_MODE}

class ProductRankSerializer(serializers.ModelSerializer):
    class Meta:
        model = ProductRank
        fields = ("__all__")

class UserRentalHistorySerializer(serializers.ModelSerializer):
    product_slug = serializers.ReadOnlyField(source="product.product.slug")
    class Meta:
        model = RentalHistory
        fields = ("start_at","end_at","status","product_slug")


class RentalHistorySerializer(serializers.ModelSerializer):
    user_email = serializers.ReadOnlyField(source="user.email")
    class Meta:
        model = RentalHistory
        fields = ("start_at","end_at","status","days","user_email")
        list_serializer_class = FutureRentalHistoryListSerializer


class RentalProductSerializer(serializers.ModelSerializer):
    histories = RentalHistorySerializer(many=True,read_only=True)
    rank = ProductRankSerializer(many=False,read_only=True)
    class Meta:
        model = RentalProduct
        fields = ['id','slug',"sn","condition","avaliable","rank","histories"]


class UserRentalProductSerializer(serializers.ModelSerializer):
    product = ProductSerializer_list(many=False,read_only=True)
    rank = ProductRankSerializer(many=False,read_only=True)
    class Meta:
        model = RentalProduct
        fields = ['id','slug',"sn","condition","avaliable","rank","product"]



class UserRentalHistoryListSerializer(serializers.ModelSerializer):
    address=AddressSerializer(many=False,read_only=False)
    product = UserRentalProductSerializer(many=False,read_only=False)
    class Meta:
        model = RentalHistory
        fields = ("__all__")
