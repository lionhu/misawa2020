from rest_framework import serializers
from rest_framework.renderers import JSONRenderer
from .models import RentalHistory,RentalProduct,ProductRank
import logging
import json

logger=logging.getLogger("error_logger")


class RentalHistorySerializer(serializers.ModelSerializer):
    class Meta:
        model = RentalHistory
        fields = "__all__"

    # def to_representation(self,instance):
    #     result=super().to_representation(instance)
    #     result["name"]=instance.product.name
    #     result["avatar"]=instance.product.thumbimage()
    #     result["slug"]=instance.product.slug
    #     return result




