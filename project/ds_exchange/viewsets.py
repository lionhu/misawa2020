
from rest_framework.views import APIView
from rest_framework import viewsets,permissions,status,mixins
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
from .models import DSOrder
from .serializers import DSOrderSerializer
from .permissions import IsAdminOrOwner,IsOwnerOrReadOnly

logger=logging.getLogger("error_logger")

# @receiver(post_save, sender=Offer)
# def create_enrolled_record(sender, instance=None, created=False, **kwargs):
#     logger.error("in create_enrolled_record function: %s"%(instance.order.slug))
    
#     sendEmail_OrderOwner_OfferChange.delay(instance.order.slug)



class DSOrderViewSet(mixins.CreateModelMixin,mixins.RetrieveModelMixin,
    mixins.UpdateModelMixin,
    mixins.DestroyModelMixin,viewsets.GenericViewSet):
    """ViewSet for the Bill class"""
    lookup_field="slug"
    queryset = DSOrder.objects.all()
    serializer_class = DSOrderSerializer
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,)

    def get_object(self, slug):
        try:
            return DSOrder.objects.get(slug=slug)
        except DSOrder.DoesNotExist:
            raise Http404

    def retrieve(self, request,slug=None):

        order=self.get_object(slug)
        serializer=self.serializer_class(order,many=False)

        content={
          "type":"list",
          "order":serializer.data,
          "slug":slug
        }

        return Response(content,status=status.HTTP_200_OK)

    def destroy(self, request,slug=None):
        content={
              "type":"destory order by slug",
              "order":{},
              "slug":slug
            }

        order=self.get_object(slug)
        serializer=self.serializer_class(order,many=False)

        if order is not None:
            order.delete()
        
            content={
              "type":"list",
              "order":serializer.data,
              "slug":slug
            }

        return Response(content,status=status.HTTP_200_OK)

    def create(self,request,format=None):
        logger.error(request.data)
        serializer=self.serializer_class(data=request.data)

        bonus=int(settings.DS_ORDER_BONUS_JPY)*request.data["amount"]
        if serializer.is_valid():
            serializer.save(user=request.user,bonuspoint=bonus)

            content={
              "success":True,
              "type":"create DirestSell Order",
              "order":serializer.data
            }

            return Response(content,status=status.HTTP_200_OK)

        content={
          "success":False,
          "type":"create DirestSell Order",
          "order":"nothing",
          "errors":logger.error(serializer.errors)
        }

        return Response(content,status=status.HTTP_200_OK)

    def partial_update(self, request, slug=None):
        order=self.get_object(slug)

        if order is not None:
            serializer=DSOrderSerializer(order,data=request.data,partial=True)

            if serializer.is_valid():
                serializer.save()

            content={
              "type":"create DirestSell Order",
              "order":serializer.data
            }

            return Response(content,status=status.HTTP_200_OK)

        raise Http404


    @list_route(methods=['get'])
    def listmine(self,request,format=None):
        orders=DSOrder.objects.filter(user=request.user)

        serializer=DSOrderSerializer(orders,many=True)

        content={
          "type":"list user direct sell orders",
          "order":serializer.data,
        }

        return Response(content,status=status.HTTP_200_OK)

    @detail_route(methods=['post'])
    def update_order(self, request, pk, format=None):
        pass
