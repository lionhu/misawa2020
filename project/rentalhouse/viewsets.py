from rest_framework import viewsets, permissions,status,mixins,generics
from rest_framework.response import Response
from django.http import Http404
from django.shortcuts import get_object_or_404
from django.conf import settings
from .models import RentalHistory,RentalProduct,ProductRank
from .serializers import RentalHistorySerializer

import logging
logger=logging.getLogger("error_logger")


class RentalHistoryViewSet(viewsets.ModelViewSet):
    queryset = RentalHistory.objects.all()
    serializer_class = RentalHistorySerializer
    permission_classes = (permissions.IsAuthenticatedOrReadOnly,)
    lookup_field="slug"

    def overlapping_items_present(self, start_at,end_at):
        if RentalHistory.objects.filter(start_at__gte=start_at, start_at__lte=end_at).exists():
          return True

        if RentalHistory.objects.filter(end_at__gte=start_at, end_at__lte=end_at).exists():
          return True

        if RentalHistory.objects.filter(start_at__lte=start_at, end_at__gte=end_at).exists():
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
            product_slug = request.data["product_slug"]

            product = get_object_or_404(RentalProduct,slug=product_slug)
            request.data["product"] = product.id
            request.data["user"] = request.user.id


            validation_userrenting = self.validate_user_rentals(request.user, product.product)

            if not validation_userrenting:
                 return Response({
                    "result":False,
                    "type":"create RentalHistory",
                    "message":"Fail because of validation_userrenting",
                 }, status=status.HTTP_200_OK)


            period_overlapping = self.overlapping_items_present(start_at,end_at)
            logger.error(validation_userrenting)

            if not period_overlapping :
                serializer=self.serializer_class(data=request.data)

                if serializer.is_valid():
                   serializer.save()

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
