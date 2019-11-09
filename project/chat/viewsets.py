from rest_framework import viewsets, permissions,status
from rest_framework.views import APIView
from rest_framework import viewsets,mixins,generics
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
from .models import Message
from .serializers import ChatMessageSerializer


logger=logging.getLogger("error_logger")

class IsOwnerOrReadOnly(permissions.BasePermission):
    def has_object_permission(self, request, view, obj):
        if request.method in permissions.SAFE_METHODS:
            return True
        return obj.user == request.user

class ChatMessageViewSet(mixins.ListModelMixin,mixins.CreateModelMixin,mixins.DestroyModelMixin,viewsets.GenericViewSet):
    queryset = Message.objects.all()
    serializer_class = ChatMessageSerializer
    permission_classes = [permissions.IsAuthenticated]


    def get_object(self, pk):
        try:
            return Message.objects.get(pk=pk)
        except Message.DoesNotExist:
            raise Http404

    
    # def retrieve(self, request, pk=None):
    #     transaction = self.get_object(pk)
    #     serializer = TransactionsSerializer(transaction)
    #     return Response(serializer.data)

    # def create(self,request,format=None):
    #     data=request.data

    #     # if order and offer Exist
    #     order_id=data["order_id"]
    #     offer_id=data["offer_id"]

    #     content={
    #         "type":"create",
    #         "result":0,
    #         "data":{}
    #         }

    #     transaction=Transaction.objects.filter(Q(order_id=order_id) & Q(offer_id=offer_id)).first()


    #     if transaction:
    #       serializer=TransactionsSerializer(transaction,data=data)
    #     else:
    #       serializer=TransactionsSerializer(data=data)

    #     if serializer.is_valid():

    #         # update order's status
    #         order=Order.objects.get(pk=order_id)
    #         offer=Offer.objects.get(pk=offer_id)

    #         if order and offer:
    #           order.status="Matching"
    #           order.save()

    #           offer.status="Matching"
    #           offer.save()

    #           content={
    #             "type":"createTransaction",
    #             "result":1,
    #             "data":data
    #           }

    #           serializer.save()

    #     return Response(content)

    # def list(self, request, format=None):
    #     content={
    #       "type":"get"
    #     }
    #     return Response(content)

    # def put(self, request, pk, format=None):
    #     transaction = self.get_object(pk)
    #     serializer = TransactionsSerializer(transaction, data=request.data)
    #     if serializer.is_valid():
    #         serializer.save()
    #         return Response(serializer.data)
    #     return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

    # def delete(self, request, pk, format=None):
    #     transaction = self.get_object(pk)
    #     transaction.delete()
    #     return Response(status=status.HTTP_204_NO_CONTENT)

