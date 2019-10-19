from .models import Catalogue,Subcatalogue,Product
from .serializers import CatalogueSerializer,SubcatalogueSerializer,ProductSerializer,ProductSerializer_list

from rest_framework import viewsets, permissions,status
from django.views.decorators.csrf import csrf_exempt
from rest_framework import viewsets,mixins,generics
from django.shortcuts import get_object_or_404
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
import datetime
import json
from .permissions import IsOwnerOrReadOnly,IsAdminOrOwner,IsAdmin


logger=logging.getLogger("error_logger")




class CatalogueViewSet(viewsets.ModelViewSet):
    queryset = Catalogue.objects.all()
    serializer_class = CatalogueSerializer
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,)

    def get_object(self, pk):
        try:
            return Catalogue.objects.get(pk=pk)
        except Catalogue.DoesNotExist:
            raise Http404

    def list(self, request):
        catalogues = Catalogue.objects.all()
        serializer = CatalogueSerializer(catalogues,many=True)

        content={
          "type":"list",
          "catalogues":serializer.data,
        }

        return Response(content)

    def retrieve(self, request, pk=None):
        catalogue = self.get_object(pk)
        serializer = CatalogueSerializer(catalogue,many=False)

        content={
          "type":"retrieve",
          "catalogues":serializer.data,
        }

        return Response(content)

    def create(self,request,format=None):
        data=request.data

        # if order and offer Exist
        catalogue_name=data["name"]

        content={
            "type":"create",
            "result":0
            }

        catalogue=Catalogue.objects.filter(name=catalogue_name).first()


        if catalogue:
          serializer=CatalogueSerializer(catalogue,data=data)
        else:
          serializer=CatalogueSerializer(data=data)

        if serializer.is_valid():

          content={
            "type":"create catalogue",
            "result":1
          }

          serializer.save()

          return Response(content)

        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

    # PUT method
    def update(self, request, pk, format=None):
        catalogue = self.get_object(pk)
        serializer = CatalogueSerializer(catalogue, data=request.data)
        if serializer.is_valid():
            serializer.save()
            content={
              "type":"update",
              "catalogues":serializer.data,
            }

            return Response(content)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

    def delete(self, request, pk, format=None):
        transaction = self.get_object(pk)
        transaction.delete()
        return Response(status=status.HTTP_204_NO_CONTENT)


class SubcatalogueViewSet(mixins.ListModelMixin,mixins.CreateModelMixin,mixins.RetrieveModelMixin,mixins.UpdateModelMixin,mixins.DestroyModelMixin,viewsets.GenericViewSet):
    queryset=Subcatalogue.objects.all()
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,)


    def create(self, request):
        catalogue_id=request.data.get("catalogue_id")

        catalogue=get_object_or_404(Catalogue,pk=catalogue_id)

        if catalogue is not None:
            serializer=SubcatalogueSerializer(data=request.data)

            if serializer.is_valid():
                serializer.save(catalogue_id=catalogue_id)

                return Response({
                    "result":True,
                    "type":"create",
                    "data":serializer.data
                }, status=status.HTTP_200_OK)

        return Response({
            "result":False,
            "type":"create",
            "data":{}
        }, status=status.HTTP_204_NO_CONTENT)



    def get_serializer_class(self):
        # if self.action == "AdminProduct":
        #     return ProductSerializer_Short
        return SubcatalogueSerializer


class ProductViewSet(mixins.ListModelMixin,mixins.CreateModelMixin,mixins.RetrieveModelMixin,mixins.UpdateModelMixin,mixins.DestroyModelMixin,viewsets.GenericViewSet):
    queryset=Product.objects.all()
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,)
    lookup_field="slug"

    def get_serializer_class(self):
        if self.action == "AdminProduct":
            return ProductSerializer
        return ProductSerializer

    def perform_create(self, serializer):
        serializer.save(owner=self.request.user)


    def create(self, request):
        return Response({
            "result":False,
            "type":"create",
            "price":request.data["price"]
        }, status=status.HTTP_200_OK)


    def retrieve(self, request,slug=None):
        product=get_object_or_404(Product,slug=slug)

        serializer=ProductSerializer(product)
        return Response({
            "result":True,
            "type":"retrieve sinale product",
            "product":serializer.data
        }, status=status.HTTP_200_OK)



    def partial_update(self, request,slug=None):
        return Response({
            "result":False,
            "type":"partial_update",
            "slug":slug,
            "price":request.data["price"]
        }, status=status.HTTP_200_OK)

    def update(self, request,slug=None):
        return Response({
            "result":False,
            "type":"update",
            "slug":slug,
            "price":request.data["price"]
        }, status=status.HTTP_200_OK)

    def destroy(self, request,slug=None):
        return Response({
            "result":False,
            "type":"destroy",
            "slug":slug
        }, status=status.HTTP_200_OK)

    def list(self, request):
        products=Product.objects.filter(active=True,main_product_id=0)

        if products is not None:
            serializer=ProductSerializer_list(products,many=True)

            return Response({
                "result":True,
                "type":"list active main product",
                "products":serializer.data
            }, status=status.HTTP_200_OK)

        return Response({
            "result":False,
            "products":[]
        }, status=status.HTTP_200_OK)



    @action(detail=False,methods=["post"], permission_classes=[IsAdmin,])
    def AdminProductList(self,request):
        products=Product.objects.all()

        serializer=ProductSerializer(products,many=True)
        return Response({
            "result":False,
            "data":serializer.data
        }, status=status.HTTP_200_OK)


    @action(detail=True,methods=["post"], permission_classes=[IsAdmin])
    def AdminProduct(self,request, slug=None):
        product=get_object_or_404(self.queryset,slug=slug)
        self.check_object_permissions(self.request, product)
        logger.error(self.serializer_class)
        serializer=ProductSerializer_Short(product)
        return Response({
            "result":False,
            "data":serializer.data
        }, status=status.HTTP_200_OK)
