from .models import Catalogue,Subcatalogue,Product,Groupon,Applicant
from .serializers import CatalogueSerializer,SubcatalogueSerializer,ProductSerializer,ProductSerializer_list,GrouponSerializer,ApplicantSerializer

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
from datetime import datetime
import json
from .permissions import IsOwnerOrReadOnly,IsAdminOrOwner,IsAdmin,IsAdminOrReadOnly
import uuid
from env_system.ColoPayApiRequest import ColoPayApiRequest
from channels.layers import get_channel_layer
from asgiref.sync import async_to_sync
# from pyzbar.pyzbar import decode
# from PIL import Image


logger=logging.getLogger("error_logger")




class CatalogueViewSet(viewsets.ModelViewSet):
    queryset = Catalogue.objects.all()
    serializer_class = CatalogueSerializer
    permission_classes = (IsAdminOrReadOnly,)

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
          serializer.save()
          content={
            "type":"create catalogue",
            "result":serializer.data
          }
          return Response(content)

        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

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

class GrouponViewSet(mixins.ListModelMixin,mixins.CreateModelMixin,mixins.RetrieveModelMixin,mixins.UpdateModelMixin,mixins.DestroyModelMixin,viewsets.GenericViewSet):
    queryset=Groupon.objects.all()
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,)
    lookup_field="slug"

    def get_serializer_class(self):
        # if self.action == "AdminProduct":
        #     return ProductSerializer
        return GrouponSerializer

    def create(self, request):
        groupon_slug = request.data.get("groupon_slug")
        num =  request.data.get("num")

        groupon = get_object_or_404(Groupon,slug=groupon_slug)
        request.data["groupon"]=groupon
        request.data["user"]=request.user
        request.data["deposite_paycode"] = "#"+groupon.id+"."+request.user.id+"."+"99"
        
        if groupon.applicants_count+num > groupon.target:
          request.data["price"] = groupon.price_overflow
          request.data["feedbackprice_overflow"] = groupon.feedbackprice_overflow
        else :
          request.data["price"] = groupon.price
          request.data["feedbackprice_overflow"] = groupon.feedbackprice

        serializer = self.serializer(data=request.data)

        if serializer.is_valid():
          serializer.save()

          return Response({
              "result":True,
              "type":"couponn create",
              "applicant_slug":serializer.data.slug,
              "message":"couponn created",
              "paycode":paycode
          }, status=status.HTTP_200_OK)

        return Response({
              "result":True,
              "type":"couponn create",
              "applicant_slug":"",
              "message":"invalid data",
              "paycode":""
        }, status=status.HTTP_200_OK)

    @action(detail=False,methods=["post"], permission_classes=[IsAuthenticated,])
    def getUserGrouponApplicant(self,request):
        groupon_slug=request.data.get("groupon_slug",None)

        groupon = get_object_or_404(Groupon,slug=groupon_slug)
        serializer_groupon=GrouponSerializer(groupon,many=False)

        try:
            applicant = Applicant.objects.get(user=request.user,groupon=groupon)
            logger.error(applicant)
            serializer_applicant = ApplicantSerializer(applicant,many=False)
            logger.error(serializer_applicant.data)

            return Response({
                    "result":True,
                    "AppliedGroupon":True,
                    "groupon":serializer_groupon.data,
                    "applicant":serializer_applicant.data
                },status=status.HTTP_200_OK)

        except Applicant.DoesNotExist:
            return Response({
                    "result":True,
                    "AppliedGroupon":False,
                    "groupon":serializer_groupon.data,
                    "applicant":{}
                },status=status.HTTP_200_OK)

    # def retrieve(self, request,slug=None):
    #     groupon = get_object_or_404(Groupon,slug=slug)

    #     if groupon is not None:
    #         serializer=self.serializer(groupon)
    #         return Response({
    #             "result":True,
    #             "type":"get groupon",
    #             "message":"get groupon successfully",
    #             "groupon":serializer.data
    #         }, status=status.HTTP_200_OK)
    #     else :
    #         return Response({
    #               "result":False,
    #               "type":"get groupon",
    #               "message":"not a groupon of current user",
    #               "groupon":{}
    #           }, status=status.HTTP_200_OK)

    # def partial_update(self, request,slug=None):
    #     applicant = get_object_or_404(Applicant,slug=slug)

    #     serializer = ApplicantSerializer(application,data=request.data,many=False)

    #     if serializer.is_valid():
    #       serializer.save()
          
    #       return Response({
    #           "result":True,
    #           "type":"partial_update",
    #           "applicant_slug":serializer.data.slug,
    #           "message":"partial_update successfully",
    #           "data":request.data
    #       }, status=status.HTTP_200_OK)

    #     return Response({
    #           "result":False,
    #           "type":"partial_update",
    #           "applicant_slug":"",
    #           "message":"partial_update invalid data",
    #           "data":""
    #     }, status=status.HTTP_200_OK)

    # @action(detail=False,methods=["post"], permission_classes=[IsAuthenticated,])
    # def UserApplicantlist(self,request):
    #     applicants = Applicant.objects.get(user=request.user)

    #     if applicants is not None:
    #         serializer=ApplicantSerializer(applicants,many=True)

    #         return Response({
    #             "result":True,
    #             "type":"User applicant list",
    #             "data":serializer.data
    #         }, status=status.HTTP_200_OK)

    #     return Response({
    #       "result":False,
    #       "type":"User applicant list",
    #       "data":""
    #       }, status=status.HTTP_200_OK)


    # @action(detail=False,methods=["post"], permission_classes=[IsAdmin])
    # def AdminApplicantlist(self,request):
    #     applicants = Applicant.objects.all()

    #     if applicants is not None:
    #         serializer=ApplicantSerializer(applicants,many=True)

    #         return Response({
    #             "result":True,
    #             "type":"admin applicant list",
    #             "data":serializer.data
    #         }, status=status.HTTP_200_OK)

    #     return Response({
    #       "result":False,
    #       "type":"admin applicant list",
    #       "data":""
    #       }, status=status.HTTP_200_OK)

class ApplicantViewSet(mixins.ListModelMixin,mixins.CreateModelMixin,mixins.RetrieveModelMixin,mixins.UpdateModelMixin,mixins.DestroyModelMixin,viewsets.GenericViewSet):
    queryset=Applicant.objects.all()
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,)
    lookup_field="slug"


    @action(detail=False,methods=["post"])
    def getPayQR(self,request):
        applicant_slug=request.data.get("applicant_slug",None)
        _brandType=request.data.get("brandType",None)
        brandType = "01" if _brandType=="AliPay" else "02"

        applicant=get_object_or_404(Applicant,slug=applicant_slug)

        now = datetime.now()
        dt_str = now.strftime('%H:%M:%S')

        clientOrderNo="GPN_"+str(request.user.id)+"-"+str(applicant.id)+"-"+dt_str

        re=ColoPayApiRequest()
        signature=re.generateSignature(brandType,clientOrderNo,applicant.price,applicant.id)

        logger.error(signature)
        res=re.post()
        jss=json.loads(res.text)

        if jss["resultType"]=="SUCCESS":
            return Response({
                "result":True,
                "clientOrderNo":clientOrderNo,
                "QRurl":jss["result"]["codeUrl"],
                "brandType":jss["result"]["brandType"],
                "message":"successfully fetch QR from ColoPay GW"
            }, status=status.HTTP_200_OK)

        return Response({
            "result":False,
            "clientOrderNo":clientOrderNo,
            "QRurl":"",
            "brandType":brandType,
            "message":"ERROR when fetching QR from ColoPay GW",
            "error":res.text
        }, status=status.HTTP_200_OK)


    def create(self, request):
        groupon_slug = request.data.get("groupon_slug")
        num =  request.data.get("num")

        groupon = get_object_or_404(Groupon,slug=groupon_slug)
        # request.data["groupon_id"]=groupon.id
        # request.data["user_id"]=request.user.id
        # request.data["deposite_paycode"] = uuid.uuid4()
        logger.error(num)
        logger.error(type(num))
        logger.error(groupon.applicants_count())
        logger.error(type(groupon.applicants_count()))

        if groupon.applicants_count()+int(num) > groupon.target:
          request.data["price"] = groupon.price_overflow
          request.data["feedbackprice"] = groupon.price_overflow*int(num) 
          request.data["feedbackprice_overflow"] = groupon.feedbackprice_overflow
        else :
          request.data["price"] = groupon.price
          request.data["feedbackprice"] = groupon.price*int(num) 
          request.data["feedbackprice_overflow"] = groupon.feedbackprice

        try:
            applicant = Applicant.objects.get(groupon=groupon,user=request.user)
            serializer = ApplicantSerializer(applicant,data=request.data)
        except Applicant.DoesNotExist:
            serializer = ApplicantSerializer(data=request.data)

        if serializer.is_valid():
              serializer.save(groupon=groupon,user=request.user)

              return Response({
                  "result":True,
                  "type":"couponn create",
                  "applicant":serializer.data,
                  "message":"couponn created",
                  # "paycode":paycode
              }, status=status.HTTP_200_OK)

        return Response({
              "result":True,
              "type":"couponn create",
              "applicant_slug":"",
              "message":"invalid data",
              "paycode":"",
              "data_error":serializer.errors
        }, status=status.HTTP_200_OK)


    def retrieve(self, request,slug=None):
        applicant = get_object_or_404(Applicant,slug=slug)

        if applicant.user == request.user:
            serializer=self.serializer(applicant)
            return Response({
                "result":True,
                "type":"get applicant",
                "message":"get applicant successfully",
                "applicant":serializer.data
            }, status=status.HTTP_200_OK)
        else :
            return Response({
                  "result":False,
                  "type":"get applicant",
                  "message":"not a applicant of current user",
                  "applicant":{}
              }, status=status.HTTP_200_OK)

    def partial_update(self, request,slug=None):
        applicant = get_object_or_404(Applicant,slug=slug)

        serializer = ApplicantSerializer(application,data=request.data,many=False)

        if serializer.is_valid():
          serializer.save()
          
          return Response({
              "result":True,
              "type":"partial_update",
              "applicant_slug":serializer.data.slug,
              "message":"partial_update successfully",
              "data":request.data
          }, status=status.HTTP_200_OK)

        return Response({
              "result":False,
              "type":"partial_update",
              "applicant_slug":"",
              "message":"partial_update invalid data",
              "data":""
        }, status=status.HTTP_200_OK)

    @action(detail=False,methods=["post"], permission_classes=[IsAuthenticated,])
    def UserApplicantlist(self,request):
        applicants = Applicant.objects.get(user=request.user)

        if applicants is not None:
            serializer=ApplicantSerializer(applicants,many=True)

            return Response({
                "result":True,
                "type":"User applicant list",
                "data":serializer.data
            }, status=status.HTTP_200_OK)

        return Response({
          "result":False,
          "type":"User applicant list",
          "data":""
          }, status=status.HTTP_200_OK)


    @action(detail=False,methods=["post"], permission_classes=[IsAdmin])
    def AdminApplicantlist(self,request):
        applicants = Applicant.objects.all()

        if applicants is not None:
            serializer=ApplicantSerializer(applicants,many=True)

            return Response({
                "result":True,
                "type":"admin applicant list",
                "data":serializer.data
            }, status=status.HTTP_200_OK)

        return Response({
          "result":False,
          "type":"admin applicant list",
          "data":""
          }, status=status.HTTP_200_OK)
