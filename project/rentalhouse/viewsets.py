from rest_framework import viewsets, permissions,status,mixins,generics
from rest_framework.response import Response
from django.http import Http404
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
        overlapping_start = RentalHistory.objects.filter(start_at__gte=start_at, start_at__lte=end_at).exists()

        overlapping_end = RentalHistory.objects.filter(end_at__gte=start_at, end_at__lte=end_at).exists()

        enveloping = RentalHistory.objects.filter(start_at__lte=start_at, end_at__gte=end_at).exists()


        overlapping_items_present = overlapping_start or overlapping_end or enveloping

        logger.error(start_at)
        logger.error(end_at)
        logger.error(overlapping_start)
        logger.error(overlapping_end)
        logger.error(enveloping)
        logger.error(overlapping_items_present)
        if overlapping_items_present:
            return True
        else:
            return False

    def create(self, request):
        try:
            start_at = request.data["start_at"]
            end_at = request.data["end_at"]

            valid_period = self.overlapping_items_present(start_at,end_at)

            logger.error(valid_period)

            if not valid_period:
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
                      "message":"invalid RentalHistory information"
               }, status=status.HTTP_400_BAD_REQUEST)
