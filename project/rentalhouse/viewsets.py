from rest_framework import viewsets, permissions,status,mixins,generics
from rest_framework.response import Response
from rest_framework.decorators import list_route,detail_route,permission_classes,api_view,action
from django.http import Http404
from django.shortcuts import get_object_or_404
from django.conf import settings
from channels.layers import get_channel_layer
from asgiref.sync import async_to_sync
from .models import RentalHistory,RentalProduct,ProductRank
from .serializers import RentalHistorySerializer,UserRentalHistoryListSerializer
from shoppingcart.models import Address
from shoppingcart.serializers import AddressSerializer
import datetime
import logging
logger=logging.getLogger("error_logger")


class RentalHistoryViewSet(viewsets.ModelViewSet):
    queryset = RentalHistory.objects.all()
    serializer_class = RentalHistorySerializer
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,)
    lookup_field="slug"

    def overlapping_items_present(self, start_at,end_at,product_slug):
        if RentalHistory.objects.filter(start_at__gte=start_at, start_at__lte=end_at,product__slug= product_slug).exists():
          return True

        if RentalHistory.objects.filter(end_at__gte=start_at, end_at__lte=end_at,product__slug= product_slug).exists():
          return True

        if RentalHistory.objects.filter(start_at__lte=start_at, end_at__gte=end_at,product__slug= product_slug).exists():
          return True

        return False


    def validate_user_rentals(self, user,in_product):

        renting_num = RentalHistory.objects.filter(user=user,status__in = settings.IN_RENTAL_MODE).count()
        logger.error("current renting count %s, max: %s"%(renting_num,settings.MAX_RENTAL_NUM))
        if renting_num >= settings.MAX_RENTAL_NUM :
          logger.error("over max rental num")
          return False

        same_rent = RentalHistory.objects.filter(user = user ,status__in = ["booked","toCustomer","fromCustomer"],product__product = in_product).exists()

        if same_rent :

          logger.error("same rent exists")
          return False

        return True

    def create(self, request):
        try:
            start_at = request.data["start_at"]
            end_at = request.data["end_at"]
            rentalproduct_id = request.data["rentalproduct_id"]
            address_id = request.data["existedAddressID"]

            product = get_object_or_404(RentalProduct,pk=rentalproduct_id)
            logger.error(request.data)

            validation_userrenting = self.validate_user_rentals(request.user, product.product)

            if not validation_userrenting:
                 return Response({
                    "result":False,
                    "type":"create RentalHistory",
                    "message":"Fail because of validation_userrenting",
                 }, status=status.HTTP_200_OK)


            period_overlapping = self.overlapping_items_present(start_at,end_at,product.slug)
            logger.error(validation_userrenting)

            if not period_overlapping :
                serializer=self.serializer_class(data=request.data)

                if serializer.is_valid():
                   if address_id >0 :
                      address = Address.objects.filter(pk=address_id).first()
                      adr_serializer = AddressSerializer(address,request.data["address"])
                      logger.error("existed address %s"%(address_id))
                   else:
                      adr_serializer = AddressSerializer(data=request.data["address"])
                      if adr_serializer.is_valid():
                        address_id = adr_serializer.save()
                        logger.error("new address %s"%(address_id))

                   serializer.save(user=request.user,address_id = address_id, product=product)
                   now_time=datetime.datetime.now().strftime(settings.DATETIME_FORMAT)
                   room_group_name = 'rentalhouse_%s' % (product.product.slug)
                   channel_layer = get_channel_layer()
                   async_to_sync(channel_layer.group_send)(
                        room_group_name,
                        {
                          'type': 'event_message',
                          'user_email': request.user.email,
                          'product_slug': product.product.slug,
                          'rentalproduct_slug': product.slug,
                          'status': "booked",
                          'start_at': start_at,
                          'end_at': end_at,
                          'now_time': now_time
                        }
                    )
                   return Response({
                      "result":True,
                      "type":"create RentalHistory",
                      "message":"successfully add new RentalHistory",
                      "rentalhistory":serializer.data
                   }, status=status.HTTP_200_OK)
                else:
                   logger.error(serializer.errors)
                   return Response({
                      "result":False,
                      "type":"create RentalHistory",
                      "message":"invalid RentalHistory information",
                      "rentalhistory":serializer.errors
                   }, status=status.HTTP_200_OK)

            return Response({
                  "result":False,
                  "type":"create RentalHistory failed",
                  "message":"overlapping exists",
               }, status=status.HTTP_400_BAD_REQUEST)

        except KeyError:

               return Response({
                      "result":False,
                      "type":"create RentalHistory",
                      "message":"KeyError: invalid RentalHistory information"
               }, status=status.HTTP_400_BAD_REQUEST)

    @action(methods=["post"],detail=False, permission_classes=[permissions.IsAuthenticated])
    def UserRentalList(self,request):
      rentalHistories = RentalHistory.objects.filter(user=request.user)

      if rentalHistories is not None:
        serializer = UserRentalHistoryListSerializer(rentalHistories,many=True)

        return Response({
            "result":True,
            "type":"get user RentalHistory",
            "rentalhistories":serializer.data,
            "count":rentalHistories.count()
         }, status=status.HTTP_200_OK)
      else:
        return Response({
            "result":False,
            "type":"get user RentalHistory",
            "message":"no rental history"
         }, status=status.HTTP_200_OK)


