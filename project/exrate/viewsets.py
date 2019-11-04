from . import models
from . import serializers
from django.shortcuts import get_object_or_404
from django.contrib.auth.models import User
from rest_framework import viewsets,status,permissions,mixins
from rest_framework.permissions import IsAuthenticated,BasePermission,SAFE_METHODS,IsAdminUser,AllowAny
from rest_framework.decorators import list_route,detail_route,permission_classes,api_view
from rest_framework.response import Response
from django.db.models import Sum
import logging
import datetime
from django.core.cache import cache
from musics.tasks import fetch_bankrate
from exrate.views import BOC_Rate_history

logger=logging.getLogger("error_logger")

class IsAdmin(BasePermission):
    def has_permission(self, request, view):
        return request.user and request.user.email == 'huhaiguang@me.com'



class IsAdminOrReadOnly(BasePermission):
    def has_permission(self, request, view):
        return request.method in SAFE_METHODS or IsAdmin().has_permission(request, view)



class BankRateViewSet(mixins.ListModelMixin,viewsets.GenericViewSet):
    """ViewSet for the BankRate class"""

    queryset = models.BankRate.objects.all()
    serializer_class = serializers.BankRateSerializer
    # permission_classes = [permissions.IsAuthenticated]

    @list_route(methods=['get'])
    def todayrate(self,request,format=None):

        today = datetime.datetime.now()
        start_today = datetime.datetime(today.year, today.month, today.day, 0, 0, 0)

        cache_todayrate=cache.get("todayrate")
        if cache_todayrate:
            # serializer=serializers.BankRateSerializer(cache_todayrate,many=False)

            content={
                "error":False,
                "message":"get todayrate from cache",
                "start_today":start_today,
                "todayrate":cache_todayrate
            }
            logger.error("get rate from cache")
            logger.error(cache_todayrate)

            return Response(content,status=status.HTTP_200_OK)

        try:
            ret=fetch_bankrate()
            cache_todayrate=cache.get("todayrate")

            content={
                "error":False,
                "message":"get rate after fetch_bankrate",
                "start_today":start_today,
                "todayrate":cache_todayrate
            }
            logger.error("get rate after fetch_bankrate")
            logger.error(cache_todayrate)

            return Response(content,status=status.HTTP_200_OK)

        except:
            logger.error("can't fetch bankrate from ShowapiRequest")
            raise Http404
                


        # message=""
        # error = False
        # todayrate={}

        # rate=models.BankRate.objects.filter(created__gt=start_today).order_by('-created').first()

        # if rate is None:
        #     try:
        #         ret=fetch_bankrate()
        #         cache_todayrate=cache.get("todayrate")

        #         content={
        #             "error":False,
        #             "message":"get rate after fetch_bankrate",
        #             "start_today":start_today,
        #             "todayrate":cache_todayrate
        #         }
        #         logger.error("get rate after fetch_bankrate")
        #         logger.error(cache_todayrate)

        #         return Response(content,status=status.HTTP_200_OK)

        #     except:
        #         logger.error("can't fetch bankrate from ShowapiRequest")
        #         raise Http404

        # else:
        #     error=False
        #     message = "fetch db existed"


        #     serializer=serializers.BankRateSerializer(todayrate,many=False)

        #     content={
        #         "error":error,
        #         "message":message,
        #         "start_today":start_today,
        #         "todayrate":serializer.data
        #     }

        #     return Response(content)


    @list_route(methods=['post'])
    def historyratelist(self,request,format=None):

        dt_start=request.data["dt_start"]
        dt_end=request.data["dt_end"]

        ratelist=BOC_Rate_history(dt_start,dt_end)

        content={
            "error":True,
            "list":ratelist,
            "dt_start":dt_start,
            "dt_end":dt_end
        }

        return Response(content)

class BonusViewSet(viewsets.ModelViewSet):
    """ViewSet for the Bonus class"""

    queryset = models.Bonus.objects.all()
    serializer_class = serializers.BonusSerializer
    # permission_classes = (IsAdminOrReadOnly,)
    permission_classes_by_action = {
            'update_Bonus_amount': [IsAdminOrReadOnly],
            'getMineBonus':[AllowAny]}

    def get_permissions(self):
        try:
            # return permission_classes depending on `action` 
            return [permission() for permission in self.permission_classes_by_action[self.action]]
        except KeyError: 
            # action is not set return default permission_classes
            return [permission() for permission in self.permission_classes]


    @list_route(methods=['post'])
    def update_Bonus_amount(self,request):

        user_bonus=models.Bonus.objects.filter(user__username=request.user).first()
        if not user_bonus:
            logger.error("create new bonus object")
            user_bonus=models.Bonus.objects.create(
                user= request.user,
                amount = 0,
                currency ="rmb"
                )
            amount__sum=0

        else:
            logger.error("recaculate_amount for exists")
            details=user_bonus.details.aggregate(Sum('amount'))
            amount__sum = details.get("amount__sum") 
            user_bonus.amount = amount__sum if amount__sum else 0
            user_bonus.save()

        return Response({
                "error":0,
                "total_bonus": amount__sum if  amount__sum else 0
            })

    @list_route(methods=["post"])
    def update_userbonus_amount(self,request,pk=None):

        new_amount=request.data["amount"]
        user_id=request.data["user_id"]
        user = User.objects.get(pk=user_id)
        logger.error(new_amount)
        logger.error(user)
        if user:
            user_bonus=models.Bonus.objects.filter(user=user).first()
            logger.error(user_bonus)
            if not user_bonus:
                logger.error("create new bonus object")
                user_bonus=models.Bonus.objects.create(
                    user= user,
                    amount = new_amount,
                    currency ="rmb"
                    )

            else:
                logger.error("reset amount for exists")
                user_bonus.amount = new_amount
                user_bonus.save()

            serializer = serializers.BonusSerializer(user_bonus,many=False)

            return Response({
                    "error":0,
                    "data": serializer.data
                },status=status.HTTP_200_OK)

        return Response({
            "error":1,
            "message": "not such user",
        },status=status.HTTP_404_NOT_FOUND)




    @list_route(methods=["get"])
    def getMineBonus(self,request):
        user_bonus=models.Bonus.objects.filter(user__username=request.user).first()
        
        if user_bonus:
            serializer = serializers.BonusSerializer(user_bonus,many=False)
            return Response({
                    "type":"user bonus",
                    "data":serializer.data
                },status=status.HTTP_200_OK)

        return Response({
                    "type":"user bonus",
                    "data": null
                },status=status.HTTP_404_NOT_FOUND)

    def create(self,request):

        logger.info(request.data.get('user_id', 1))

        # logger.info(request.user)
        logger.info(request.data)
        # file=request.FILES['avatar']
        # path= os.path.join("/media/avatarts/",file.name)
        # destination = open(path, "wb")

        # for chunk in file.chunks():
        #     destination.write(chunk)
        # destination.close()

        # if not os.path.exists(path):
        #     print('File not found:', path)
        #     return create_render(request)

        # userprofile, created = UserProfile.objects.get_or_create(avatar=path)
        # if created:
        #     userprofile.organization = request.POST['organization']
        #     userprofile.telephone = request.POST['telephone']
        #     image.save()

        return Response({'message': 'OK',
            "request":request.data
            })



class BonusDetailViewSet(mixins.ListModelMixin,viewsets.GenericViewSet):
    """ViewSet for the BankRate class"""

    queryset = models.BankRate.objects.all()
    serializer_class = serializers.BankRateSerializer
    # permission_classes = [permissions.IsAuthenticated]

    @list_route(methods=['get'])
    def todayrate(self,request,format=None):

        today = datetime.datetime.now()
        start_today = datetime.datetime(today.year, today.month, today.day, 0, 0, 0)

        cache_todayrate=cache.get("todayrate")
        if cache_todayrate:
            # serializer=serializers.BankRateSerializer(cache_todayrate,many=False)

            content={
                "error":False,
                "message":"get todayrate from cache",
                "start_today":start_today,
                "todayrate":cache_todayrate
            }
            logger.error("get rate from cache")
            logger.error(cache_todayrate)

            return Response(content,status=status.HTTP_200_OK)

        try:
            ret=fetch_bankrate()
            cache_todayrate=cache.get("todayrate")

            content={
                "error":False,
                "message":"get rate after fetch_bankrate",
                "start_today":start_today,
                "todayrate":cache_todayrate
            }
            logger.error("get rate after fetch_bankrate")
            logger.error(cache_todayrate)

            return Response(content,status=status.HTTP_200_OK)

        except:
            logger.error("can't fetch bankrate from ShowapiRequest")
            raise Http404
                


        # message=""
        # error = False
        # todayrate={}

        # rate=models.BankRate.objects.filter(created__gt=start_today).order_by('-created').first()

        # if rate is None:
        #     try:
        #         ret=fetch_bankrate()
        #         cache_todayrate=cache.get("todayrate")

        #         content={
        #             "error":False,
        #             "message":"get rate after fetch_bankrate",
        #             "start_today":start_today,
        #             "todayrate":cache_todayrate
        #         }
        #         logger.error("get rate after fetch_bankrate")
        #         logger.error(cache_todayrate)

        #         return Response(content,status=status.HTTP_200_OK)

        #     except:
        #         logger.error("can't fetch bankrate from ShowapiRequest")
        #         raise Http404

        # else:
        #     error=False
        #     message = "fetch db existed"


        #     serializer=serializers.BankRateSerializer(todayrate,many=False)

        #     content={
        #         "error":error,
        #         "message":message,
        #         "start_today":start_today,
        #         "todayrate":serializer.data
        #     }

        #     return Response(content)


    @list_route(methods=['post'])
    def historyratelist(self,request,format=None):

        dt_start=request.data["dt_start"]
        dt_end=request.data["dt_end"]

        ratelist=BOC_Rate_history(dt_start,dt_end)

        content={
            "error":True,
            "list":ratelist,
            "dt_start":dt_start,
            "dt_end":dt_end
        }

        return Response(content)


class SystemEnvViewSet(viewsets.ModelViewSet):
    queryset = models.SystemEnv.objects.all()
    serializer_class = serializers.SystemEnvSerializer
    permission_classes = [IsAdminOrReadOnly]

    def list(self, request):
        return Response({
            "error":1,
            "type": "list",
            "data": {}
        },status=status.HTTP_404_NOT_FOUND)

    def create(self, request):
        serializer=self.serializer_class(data=request.data)
        if serializer.is_valid():
            serializer.save()

            return Response({
                "result":True,
                "data": serializer.data
            },status=status.HTTP_200_OK)
        else:
            raise Http404

    def retrieve(self, request,pk=None):

        logger.error("get user systemEnvs")
        envs=request.user.profile.membership+"Envs"
        logger.error(envs)

        cached_systemsEnvs=cache.get(envs)
        from_message="from cache"
        if cached_systemsEnvs is None:
            systemEnvs=get_object_or_404(models.SystemEnv,name=envs)
            serializer=serializers.SystemEnvSerializer(systemEnvs,many=False)


            from_message="from db"
            cached_systemsEnvs=serializer.data
            cache.set(envs,cached_systemsEnvs,600)

        return Response({
            "result":True,
            "message":from_message,
            "systemEnvs": cached_systemsEnvs
        },status=status.HTTP_200_OK)


        # if request.user.profile.membership=="ADMIN":
        #     cached_systemsEnvs=cache.get(envs)
        #     from_message="from cache"
        #     if cached_systemsEnvs is None:
        #         systemEnvs=get_object_or_404(models.SystemEnv,name=envs)
        #         serializer=serializers.SystemEnvSerializer(systemEnvs,many=False)


        #         from_message="from db"
        #         cached_systemsEnvs=serializer.data
        #         cache.set(envs,cached_systemsEnvs)

        # else:
        #     cached_systemsEnvs=cache.get(envs)
        #     from_message="from cache"
        #     if cached_systemsEnvs is None:
        #         systemEnvs=get_object_or_404(models.SystemEnv,name=envs)
        #         serializer=serializers.SystemEnvSerializer(systemEnvs,many=False)


        #         from_message="from db"
        #         cached_systemsEnvs=serializer.data
        #         cache.set(envs,cached_systemsEnvs)

        # return Response({
        #     "result":True,
        #     "message":from_message,
        #     "systemEnvs": cached_systemsEnvs
        # },status=status.HTTP_200_OK)

    def update(self, request, pk=None):
        return Response({
            "error":0,
            "data": "update"
        },status=status.HTTP_200_OK)

    def partial_update(self, request, pk=None):
        return Response({
            "error":0,
            "data": "partial_update"
        },status=status.HTTP_200_OK)

    def destroy(self, request, pk=None):
        return Response({
            "error":0,
            "data": "destroy"
        },status=status.HTTP_200_OK)

