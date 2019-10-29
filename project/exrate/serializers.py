from . import models

from rest_framework import serializers
from useraccount.serializers import UserSerializer
from django.contrib.auth.models import User


class BankRateSerializer(serializers.ModelSerializer):

    class Meta:
        model = models.BankRate
        fields = (
            'pk', 
            'hui_in', 
            'hui_out', 
            'chao_in', 
            'chao_out', 
            'name', 
            'code', 
            'created', 
        )


class BonusSerializer(serializers.ModelSerializer):
    user = UserSerializer(read_only=True)
    user_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(),write_only=True)
    
    class Meta:
        model = models.Bonus
        fields = (
            'user',
            'user_id',
            'slug', 
            'created', 
            'last_updated', 
            'currency', 
            'amount', 
        )


class BonusDetailSerializer(serializers.ModelSerializer):
    # bonus = BonusSerializer(read_only=True)
    # bonus_id = serializers.PrimaryKeyRelatedField(queryset=models.Bonus.objects.all(),write_only=True)
    class Meta:
        model = models.BonusDetail
        fields = (
            # 'bonus',
            # 'bonus_id',
            'slug', 
            'created', 
            'last_updated', 
            'currency', 
            'amount', 
            'fromType', 
            'fromObjectID', 
            'description', 
        )


class SystemEnvSerializer(serializers.ModelSerializer):

    class Meta:
        model = models.SystemEnv
        fields = "__all__"
