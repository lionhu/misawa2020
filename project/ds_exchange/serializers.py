from .models import DSOrder

from rest_framework import serializers
from useraccount.serializers import UserSerializer,UserProfileSerializer,UserProfileSerializer_Full
from useraccount.models import UserProfile
from django.contrib.auth.models import User
import uuid
import datetime
from django.conf import settings


class DSOrderSerializer(serializers.ModelSerializer):

    class Meta:
        model = DSOrder
        # fields = "__all__"
        exclude = ['active','privacy','id']

