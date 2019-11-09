from rest_framework import serializers
from django.contrib.auth.models import User
from .models import Message
from useraccount.serializers import UserSerializer

class ChatMessageSerializer(serializers.ModelSerializer):
    user=UserSerializer(read_only=True)

    class Meta:
        model = Message
        fields = "__all__"

