from rest_framework import serializers
from .models import UserProfile
from rentalhouse.serializers import UserRentalHistorySerializer

from django.utils.timezone import now
from django.contrib.auth.models import User

class ToUpperCaseCharField(serializers.CharField):
    def to_representation(self, value):
        return value.upper()

class UserProfileSerializer(serializers.ModelSerializer):

   class Meta:
       model = UserProfile
       fields = "__all__"

class UserSerializer(serializers.ModelSerializer):
    profile = UserProfileSerializer(read_only=True)
    profile_id = serializers.PrimaryKeyRelatedField(queryset=UserProfile.objects.all(), write_only=True)
    myrentalhistories = UserRentalHistorySerializer(many=True,read_only=True)
    class Meta:
        model = User
        fields = ( "id", "username","email","profile","profile_id","myrentalhistories")


class UserProfileSerializer_Full(serializers.ModelSerializer):
   days_since_created = serializers.SerializerMethodField()
   organization = ToUpperCaseCharField()
   user = UserSerializer(read_only=True)
   user_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)
   father = UserSerializer(read_only=True)
   father_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)
   grandfather = UserSerializer(read_only=True)
   grandfather_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)
   partner = UserSerializer(read_only=True)
   partner_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)

   class Meta:
       model = UserProfile
       fields = ('id','slug','language','organization', 'telephone',"avatar",'days_since_created',
        'user','user_id','father','father_id','grandfather','grandfather_id',
        'partner','partner_id',"id_image","wechat","line","approved","canTakeBonus","membership")
       depth=1

   def get_days_since_created(self, obj):
       return (now() - obj.mod_date).days


class UserSerializer_WithFullProfile(serializers.ModelSerializer):
    profile = UserProfileSerializer_Full(read_only=True)
    profile_id = serializers.PrimaryKeyRelatedField(queryset=UserProfile.objects.all(), write_only=True)
    class Meta:
        model = User
        fields = ( "id", "username","email","profile","profile_id")


class UserProfileMainImageSerializer(serializers.ModelSerializer):

  class Meta:
       model = UserProfile
       fields = ("line", "wechat","avatar", "id_image")


class UserProfileSocialSerializer(serializers.ModelSerializer):
  """docstring for UserProfileAvatarSerializer"""
  class Meta:
       model = UserProfile
       fields = ("line", "wechat",)


# TODO: to delete
class UserProfileSerializerV1(serializers.ModelSerializer):
   days_since_created = serializers.SerializerMethodField()
   organization = ToUpperCaseCharField()
   user = UserSerializer(read_only=True)
   user_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)
   father = UserSerializer(read_only=True)
   father_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)
   grandfather = UserSerializer(read_only=True)
   grandfather_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)
   partner = UserSerializer(read_only=True)
   partner_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)

   class Meta:
       model = UserProfile
       fields = ('id','slug','organization','language', 'telephone',"avatar",'days_since_created',
        'user','user_id','father','father_id','grandfather','grandfather_id',
        'partner','partner_id',"id_image","wechat","line","approved","canTakeBonus","membership")

   def get_days_since_created(self, obj):
       return (now() - obj.mod_date).days



