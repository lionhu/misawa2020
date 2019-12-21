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


class DSOrderAdminSerializer(serializers.ModelSerializer):    
    user = serializers.ReadOnlyField(source = "user.username")
    class Meta:
        model = DSOrder
        fields = (
            'id',
            'slug',
            'created',
            'last_updated',
            'amount',
            "bonuspoint",
            'from_currency',
            'to_currency',
            'due_at',
            'rate',
            'active',
            "status",
            'privacy',
            'send_notification',
            'memo',
            'user',
        )

