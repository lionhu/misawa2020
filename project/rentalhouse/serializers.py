from rest_framework import serializers
from rest_framework.renderers import JSONRenderer
from .models import RentalHistory,RentalProduct,ProductRank
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
        # fields =("__all__")
        fields = ("start_at","end_at","status","product_slug")
    # def to_representation(self,instance):
    #     result=super().to_representation(instance)
    #     return result

class RentalHistorySerializer(serializers.ModelSerializer):
    class Meta:
        model = RentalHistory
        # fields =("__all__")
        fields = ("start_at","end_at","status","user_id")
        list_serializer_class = FutureRentalHistoryListSerializer
    # def to_representation(self,instance):
    #     result=super().to_representation(instance)
    #     return result

class RentalProductSerializer(serializers.ModelSerializer):
    histories = RentalHistorySerializer(many=True,read_only=True)
    rank = ProductRankSerializer(many=False,read_only=True)
    class Meta:
        model = RentalProduct
        fields = ['slug',"sn","condition","avaliable","rank","histories"]

    # def to_representation(self,instance):
    #     result=super().to_representation(instance)

    #     histories = instance.rentalproducts.filter(end_at__gte=datetime.datetime.now())
    #     result["histories"]= RentalHistorySerializer(histories,many=True)
    #     return result

