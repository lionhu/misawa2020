from django.shortcuts import render

from django.contrib.auth.backends import ModelBackend
# Create your views here.
from django.contrib.auth.models import User
from django.contrib import auth
from django.conf import settings
from django.http import Http404
from .models import UserProfile,fun_sql_cursor_update
from .serializers import UserProfileSerializerV1, UserProfileSerializer_Full, \
    UserProfileSerializer,UserSerializer,UserProfileMainImageSerializer, \
    UserProfileSocialSerializer,UserSerializer_WithFullProfile
from .exceptions import InvalidUserSignupParams
from rest_framework import viewsets,status
from rest_framework import parsers
from rest_framework.permissions import IsAuthenticated,BasePermission,SAFE_METHODS,AllowAny
from rest_framework.decorators import list_route,detail_route,permission_classes,api_view,action
from rest_framework.response import Response
from django.contrib.sites.shortcuts import get_current_site
# from rest_framework.views import APIView
from django.http.request import HttpRequest
from django.template import loader
from django.core.mail import EmailMessage
import logging
from django.db.models import Q
from django.utils.http import urlsafe_base64_encode, urlsafe_base64_decode
from django.utils.encoding import force_bytes
import uuid
from django.template.loader import render_to_string
from .token_generator import account_activation_token
from rest_framework.authtoken.models import Token
from django.views.decorators.csrf import csrf_exempt
from musics.tasks import EmailVerifyRecord
from .tasks import sendPasswordResetEmail
from .models import EmailPasswordReset
from musics.tasks import sendEmail_newuser_registered
from env_system.permissions import IsAdmin

logger=logging.getLogger("error_logger")


def get_default_ancestor(_slug):
    profile = UserProfile.objects.filter(slug=_slug).first()

    if profile is None:
        profile = UserProfile.objects.get(user_id=settings.ADMIN_ROOT_ID)
        return profile.user

    return profile.user


class inBlacklist(BasePermission):
    def has_permission(self, request, view):
        return request.method in SAFE_METHODS

    # def has_object_permission(self, request, view, obj):
        # if request.method in permissions.SAFE_METHODS:
        #     return True

        # return obj.user is not request.user


# Create your views here.
class UserProfileViewSet(viewsets.ModelViewSet):
    queryset = UserProfile.objects.all()
    serializer_class = UserProfileSerializerV1
    permission_classes = [IsAuthenticated]

    def create(self,request):
        file=request.FILES['avatar']
        path= os.path.join("/media/avatars/",file.name)
        destination = open(path, "wb")

        for chunk in file.chunks():
            destination.write(chunk)
        destination.close()

        if not os.path.exists(path):
            print('File not found:', path)
            return create_render(request)

        userprofile, created = UserProfile.objects.get_or_create(avatar=path)
        if created:
            # image.sender = request.POST['sender']
            userprofile.organization = request.POST['organization']
            userprofile.telephone = request.POST['telephone']
            image.save()

        return Response({'message': 'OK'})



    @list_route(methods=['get'], permission_classes=[IsAdmin])
    def Admin_UserList(self,request,format=None):
        users=User.objects.all()

        if users is not None:

            serializer=UserSerializer(users,many=True)
            content={
                "success":True,
                "users":serializer.data
            }

            return Response(content,status=status.HTTP_200_OK)
        else:
            raise Http404

    @detail_route(methods=['put'])
    def sql_cursor_update(self, request, pk=None):
        organization = request.data.get('organization', None)
        telephone = request.data.get('telephone', None)
        if organization:
            userprofile = fun_sql_cursor_update(organization=organization,telephone = telephone, pk=pk)
            return Response(userprofile, status=status.HTTP_200_OK)

    @list_route(methods=['get'])
    def ver_api(self, request):
        profiles=UserProfile.objects.all()
        if self.request.version == '1.0':
            serializer = UserProfileSerializerV1(profiles, many=True)
        else:
            serializer = UserProfileSerializer(profiles, many=True)
        return Response(serializer.data, status=status.HTTP_200_OK)

    @detail_route(methods=['get'])
    def childrens(self,request, pk=None):

        user = User.objects.get(pk=pk)

        if user and  user.profile.isDistributor():
            childrens = User.objects.filter(Q(profile__partner_id = user.id),~Q(id=user.id))
            serializer = UserProfileSerializer_Full(childrens,many=True)
            return Response(serializer.data,status=status.HTTP_200_OK)

        childrens = User.objects.filter(Q(profile__father_id=pk)|Q(profile__grandfather_id=pk))

        if len(childrens):
            serializer = UserProfileSerializer_Full(childrens,many=True)
            return Response(serializer.data,status=status.HTTP_200_OK)
        else:
            content = {'message': 'no child'}
            return Response(content,status=status.HTTP_404_NOT_FOUND)

    @detail_route(methods=['get'])
    def decendants(self,request, pk=None):

        userprofile=UserProfile.objects.filter(user__id=pk).first()

        if userprofile:
            serializer=UserProfileSerializer

    @action(detail=False,methods=["post"])
    def inviate_child(self,request):
        logger.error(request.data)
        email_subject = 'Invite Child'
        current_site = get_current_site(request)
        message = loader.render_to_string('account/invite_child.html', {
            'user': request.user,
            'domain': current_site.domain,
        })
        to_email = request.data.get('email')
        email = EmailMessage(email_subject, message, to=[to_email])
        email.send()


        return Response({'message': 'OK'})
        


    @action(detail=False,methods=["get"], permission_classes=[inBlacklist])
    def get_myprofile(self,request):
        profile=UserProfile.objects.filter(user = request.user).first()

        if profile:
            serializer=UserProfileSerializerV1(profile,many=False)
            return Response({
                    "result":True,
                    "data":serializer.data
                }, status=status.HTTP_200_OK)

        return Response({
            "result":False,
            "data":{}
        }, status=status.HTTP_404_NOT_FOUND)


    @action(detail=False,methods=["post"],permission_classes=[AllowAny])
    def LoginMeSync(self,request):
        username=request.data.get("username",None)
        pwd=request.data.get("password",None)

        success=auth.authenticate(request,username=username,password=pwd)
        user = User.objects.get(username=username)
        if success :
            auth.login(request, user)

            return Response({
                    "result":True,
                    "message":"sync login success"
                }, status=status.HTTP_200_OK)

        raise Http404




    @action(detail=False,methods=["post"], permission_classes=[AllowAny])
    @csrf_exempt
    def singup(self,request):
        try:
            introducer=request.data["introcode"] if request.data["introcode"] else "nothing"
            username = request.data['username']
            email = request.data['email']
            password = request.data['password']

        except KeyError as e:
            logger.error(e)
            return Response({
                        "result":False,
                        "message":"input params errors"
                    }, status=status.HTTP_404_NOT_FOUND)


        if len(username)==0 or len(email)==0 or len(password)==0 :
            raise InvalidUserSignupParams(503,"invalid user signup parameters","invalid_signup_info")

        try:
            user=User.objects.filter(email=email).first()

            if user :
                return Response({
                    "result":False,
                    "message":"User already existed!",
                    "username":username,
                    "email":email,
                }, status=status.HTTP_200_OK)
            else:

                user = User.objects.create_user(username=username, email=email, password=password)

                ancestor=get_default_ancestor(introducer)
                logger.error(introducer)
                user_profile = UserProfile.objects.create(
                    telephone = "+81 13913288888",
                    slug = uuid.uuid4(),
                    avatar = "new.jpg",
                    user = user,
                    father_id = ancestor.id,
                    grandfather_id = ancestor.profile.father.id,
                    partner_id = ancestor.profile.father.id
                )
                token, created = Token.objects.get_or_create(user=user)

                sendEmail_newuser_registered.delay(username,email)

                

                return Response({
                            "result":True,
                            "message":"signup successfully",
                            "token":token.key,
                            "username":username,
                            "email":email,
                            "introducer":introducer,
                            "password":password
                        }, status=status.HTTP_200_OK)

        except User.DoesNotExist:
            raise exceptions.AuthenticationFailed('No such user')

            return Response({
                        "result":False,
                        "message":"signup failed",
                        "username":username,
                        "email":email,
                        "introducer":introducer,
                        "password":password
                    }, status=status.HTTP_404_NOT_FOUND)

    @action(detail=False,methods=["post"], permission_classes=[AllowAny])
    @csrf_exempt
    def resetpassword_verify(self,request):
        email,token,password="","",""
        try:
            email = request.data['email']
            token = request.data['token']
            password = request.data['password']
        except KeyError as e:
            logger.error(e)
            return Response({
                        "result":False,
                        "message":"information in not provided"
                    }, status=status.HTTP_404_NOT_FOUND)

        try:

            resetobj=EmailPasswordReset.objects.filter(email=email,token=token).first()
            user=User.objects.filter(email=email).first()

            if resetobj and user:
                user.set_password(password)
                user.save()

                resetobj.delete()
                return Response({
                            "result":True,
                            "message":"resetpassword successfully",
                            "token":token,
                            "email":email,
                            "password":password
                        }, status=status.HTTP_200_OK)
            else:
                return Response({
                            "result":False,
                            "message":"resetpassword failed, token and email not valid",
                            "token":token,
                            "email":email,
                            "password":password
                        }, status=status.HTTP_200_OK)

        except EmailPasswordReset.DoesNotExist:
            return Response({
                        "result":False,
                        "message":"no such email need reset password",
                        "token":token,
                        "email":email,
                        "password":password
                    }, status=status.HTTP_404_NOT_FOUND)

    @action(detail=False,methods=["post"], permission_classes=[AllowAny])
    @csrf_exempt
    def resetpassword(self,request):
        email=""
        try:
            email = request.data['email']
            user=User.objects.filter(email=email).first()

            if user:

                sendPasswordResetEmail.delay(email)
                # sendPasswordResetEmail.delay(email,"http://localhost:2080")
                return Response({
                            "result":True,
                            "message":"resetpassword email sent successfully",
                            "email":email
                        }, status=status.HTTP_200_OK)

            else:
                return Response({
                        "result":False,
                        "message":"invalid user email."
                    }, status=status.HTTP_200_OK)

        except KeyError as e:
            logger.error(e)
            return Response({
                        "result":False,
                        "message":"email in not provided"
                    }, status=status.HTTP_200_OK)


    @action(detail=False,methods=["post"])
    def update_myprofile(self,request):
        logger.error(request.data)
        profile = UserProfile.objects.filter(user = request.user).first()

        if profile:

            # profile.telephone = request.data["telephone"]
            profile.avatar = request.FILES["avatar"]
            profile.save()
            logger.error(profile)

            return Response({
                "result":True,
                "data":profile.thumbnail.url
            }, status=status.HTTP_200_OK)

        else:
            return Response({
                "result":False,
                "data":{}
            }, status=status.HTTP_404_NOT_FOUND)


    @action(detail=False,methods=["post"])
    def update_myprofile_info(self,request):
        logger.error(request.data)
        profile = UserProfile.objects.filter(user = request.user).first()

        if profile:
            serializer=UserProfileSerializer_Full(profile,data=request.data,partial=True)
            
            if serializer.is_valid():
                serializer.save()

                return Response({
                    "result":True,
                    "data":serializer.data,
                    "message":"profile has been successfully updated"
                }, status=status.HTTP_200_OK)

        else:
            return Response({
                "result":False,
                "data":{},
                "message":"error in updateing profile"
            }, status=status.HTTP_200_OK)


    @action(detail=True,methods=["post"],
        serializer_class=UserProfileMainImageSerializer,
        parser_classes=[parsers.MultiPartParser],)
    def upload_mainImage(self, request,pk):
        profile=UserProfile.objects.filter(user_id=pk).first()
        serializer = UserProfileSerializer(profile, data=request.data,
                                           partial=True)
        # serializer = self.serializer_class(obj, data=request.data,
        #                                    partial=True)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data)
        return Response(serializer.errors,tatus.HTTP_400_BAD_REQUEST)

    @action(detail=True,methods=["post"],
        serializer_class=UserProfileSocialSerializer,
        parser_classes=[parsers.MultiPartParser],)
    def upload_social(self, request,pk):
        obj = self.get_object()
        serializer = self.serializer_class(obj, data=request.data,
                                           partial=True)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data)
        return Response(serializer.errors,tatus.HTTP_400_BAD_REQUEST)


class CustomBackend(ModelBackend):
    def authenticate(self, request, username=None, password=None, **kwargs):
        try:
            user = User.objects.get(Q(username=username) | Q(email=username))
            if user.check_password(password):
                return user
        except Exception as e:
            return None

