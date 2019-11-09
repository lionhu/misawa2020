import datetime
import json
from channels.generic.websocket import AsyncWebsocketConsumer
from django.core import serializers

from django.conf import settings

from .models import Message
from .serializers import ChatMessageSerializer
from useraccount.models import UserProfile
from musics.tasks import task_mail_chatmessage

import logging


logger=logging.getLogger("error_logger")


class ChatConsumer(AsyncWebsocketConsumer):
    async def connect(self):
        self.room_name = self.scope['url_route']['kwargs']['room_name']
        self.room_group_name = 'chat_%s' % self.room_name
        # Join room group
        await self.channel_layer.group_add(
            self.room_group_name,
            self.channel_name
        )

        if self.scope["user"].is_anonymous:
            await self.close()
        else:
            await self.accept()

    async def disconnect(self, close_code):
        # Leave room group
        await self.channel_layer.group_discard(
            self.room_group_name,
            self.channel_name
        )

    # Receive message from WebSocket
    async def receive(self, text_data):
        text_data_json = json.loads(text_data)
        message = text_data_json['message']
        user = str(self.scope['user'])
        now_time=datetime.datetime.now().strftime(settings.DATETIME_FORMAT)


        if not message:
            return
        if not self.scope['user'].is_authenticated:
            return

        message=Message.objects.create(user=self.scope['user'],message=message,group_name=self.room_group_name)

        # task_mail_chatmessage.delay(message)
        # profile=UserProfile.objects.filter(user=self.scope['user']).first()
        # Send message to room group
        await self.channel_layer.group_send(
            self.room_group_name,
            {
                'type': 'chat_message',
                'message': message,
                'user': user,
                'avatar':self.scope['user'].profile.avatar.url,
                'now_time': now_time
            }
        )

    # Receive message from room group
    async def chat_message(self, event):
        message = event['message']
        user = event['user']
        avatar = event['avatar']
        now_time = event['now_time']
        # Send message to WebSocket
        await self.send(text_data=json.dumps({
            'message': ": "+message,
            'user': user,
            'avatar': avatar,
            'now_time': now_time
        }))


class VueChatConsumer(AsyncWebsocketConsumer):
    async def connect(self):
        self.room_name = self.scope['url_route']['kwargs']['room_name']
        self.room_group_name = 'chat_%s' % self.room_name
        # Join room group
        await self.channel_layer.group_add(
            self.room_group_name,
            self.channel_name
        )

        if self.room_name is None:
            await self.close()
        else:
            await self.accept()

    async def disconnect(self, close_code):
        # Leave room group
        await self.channel_layer.group_discard(
            self.room_group_name,
            self.channel_name
        )

    # Receive message from WebSocket
    async def receive(self, text_data):
        text_data_json = json.loads(text_data)
        message = text_data_json['message']
        user = str(self.scope['user'])
        now_time=datetime.datetime.now().strftime(settings.DATETIME_FORMAT)


        if not message:
            return
        if not self.scope['user'].is_authenticated:
            return

        message=Message.objects.create(user=self.scope['user'],message=message,group_name=self.room_group_name)

        serializer=ChatMessageSerializer(message,many=False)
        # profile=UserProfile.objects.filter(user=self.scope['user']).first()
        # Send message to room group
        await self.channel_layer.group_send(
            self.room_group_name,
            {
                'type': 'chat_message',
                'message': serializer.data
            }
        )

    # Receive message from room group
    async def chat_message(self, event):
        message = event['message']
        # Send message to WebSocket
        await self.send(text_data=json.dumps({
            'message': message
        }))


'''
asynchronous version
'''

# import json
# from channels.generic.websocket import AsyncWebsocketConsumer
#
#
# class ChatConsumer(AsyncWebsocketConsumer):
#     async def connect(self):
#         self.room_name = self.scope['url_route']['kwargs']['room_name']
#         self.room_group_name = 'chat_%s' % self.room_name
#
#         # Join room group
#         await self.channel_layer.group_add(
#             self.room_group_name,
#             self.channel_name
#         )
#
#         await self.accept()
#
#     async def disconnect(self, close_code):
#         # Leave room group
#         await self.channel_layer.group_discard(
#             self.room_group_name,
#             self.channel_name
#         )
#
#     # Receive message from WebSocket
#     async def receive(self, text_data):
#         text_data_json = json.loads(text_data)
#         message = text_data_json['message']
#
#         # Send message to room group
#         await self.channel_layer.group_send(
#             self.room_group_name,
#             {
#                 'type': 'chat_message',
#                 'message': message
#             }
#         )
#
#     # Receive message from room group
#     async def chat_message(self, event):
#         message = event['message']
#
#         # Send message to WebSocket
#         await self.send(text_data=json.dumps({
#             'message': message
#         }))
#