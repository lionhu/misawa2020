import datetime
import json
from channels.generic.websocket import AsyncWebsocketConsumer
from django.core import serializers

from django.conf import settings

from .models import Message
from .serializers import ChatMessageSerializer
from useraccount.models import UserProfile
from musics.tasks import task_mail_chatmessage
from useraccount.models import UserProfile
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


class PublicConsumer(AsyncWebsocketConsumer):
    async def connect(self):
        self.room_name = self.scope['url_route']['kwargs']['room_name']
        self.room_group_name = 'chat_%s' % self.room_name
        # Join room group
        await self.channel_layer.group_add(
            self.room_group_name,
            self.channel_name
        )
        logger.error("PublicConsumer channel_name: %s"%(self.channel_name))



        if self.room_name is None:
            await self.close()
        else:
            logger.error("%s connected to server"%(self.scope["user"]))
            logger.error(self.scope["user"].id)

            if self.scope["user"].id is not None:
                userprofile = UserProfile.objects.get(user_id=self.scope["user"].id)
                if userprofile is not None:
                    userprofile.online=True
                    userprofile.save()

                await self.channel_layer.group_send(
                    self.room_group_name,
                    {
                        'type': 'online_status',
                        'message_type': "userstatus",
                        'status': True,
                        'user_id': self.scope["user"].id
                    }
                )

                await self.accept()

    async def disconnect(self, close_code):
        if self.scope["user"].id is not None:
            userprofile = UserProfile.objects.get(user_id=self.scope["user"].id)
            if userprofile is not None:
                userprofile.online=False
                userprofile.save()

            await self.channel_layer.group_send(
                self.room_group_name,
                {
                    'type': 'online_status',
                    'message_type': "userstatus",
                    'status': False,
                    'user_id': self.scope["user"].id
                }
            )

        # Leave room group
        await self.channel_layer.group_discard(
            self.room_group_name,
            self.channel_name
        )


    # Receive message from WebSocket
    async def receive(self, text_data):
        text_data_json = json.loads(text_data)
        message = text_data_json['message']
        message_type = text_data_json['message_type']
        display_mode = text_data_json['display_mode']


        await self.channel_layer.group_send(
            self.room_group_name,
            {
                'type': 'chat_message',
                'message': message,
                'message_type': message_type,
                'display_mode': display_mode
            }
        )

    # Receive message from room group
    async def chat_message(self, event):
        message = event['message']
        message_type = event['message_type']
        display_mode = event['display_mode']
        # Send message to WebSocket
        await self.send(text_data=json.dumps({
            'message': message,
            'message_type': message_type,
            'display_mode': display_mode
        }))

    # Receive message from room group
    async def online_status(self, event):
        status = event['status']
        message_type = event['message_type']
        user_id = event['user_id']
        # Send message to WebSocket
        await self.send(text_data=json.dumps({
            'message_type': message_type,
            'user_id': user_id,
            'status': status
        }))


class ShopPublicConsumer(AsyncWebsocketConsumer):
    async def connect(self):
        self.room_name = "room_"+str(self.scope["user"].id)
        self.room_group_name = 'shop_publicroom'
        # Join room group
        await self.channel_layer.group_add(
            self.room_group_name,
            self.channel_name
        )

        if self.room_name is None:
            await self.close()
        else:
            logger.error("%s connected to server"%(self.scope["user"]))
            logger.error(self.scope["user"].id)

            if self.scope["user"].id is not None:
                userprofile = UserProfile.objects.get(user_id=self.scope["user"].id)
                if userprofile is not None:
                    userprofile.online=True
                    userprofile.save()

                await self.channel_layer.group_send(
                    self.room_group_name,
                    {
                        'type': 'online_status',
                        'message_type': "userstatus",
                        'status': True,
                        'user_id': self.scope["user"].id
                    }
                )

                await self.accept()

    async def disconnect(self, close_code):
        if self.scope["user"].id is not None:
            userprofile = UserProfile.objects.get(user_id=self.scope["user"].id)
            if userprofile is not None:
                userprofile.online=False
                userprofile.save()

            await self.channel_layer.group_send(
                self.room_group_name,
                {
                    'type': 'online_status',
                    'message_type': "userstatus",
                    'status': False,
                    'user_id': self.scope["user"].id
                }
            )

        # Leave room group
        await self.channel_layer.group_discard(
            self.room_group_name,
            self.channel_name
        )


    # Receive message from WebSocket
    async def receive(self, text_data):
        text_data_json = json.loads(text_data)
        message = text_data_json['message']
        message_type = text_data_json['message_type']
        display_mode = text_data_json['display_mode']


        await self.channel_layer.group_send(
            self.room_group_name,
            {
                'type': 'chat_message',
                'message': message,
                'message_type': message_type,
                'display_mode': display_mode
            }
        )

    # Receive message from room group
    async def chat_message(self, event):
        message = event['message']
        message_type = event['message_type']
        display_mode = event['display_mode']
        # Send message to WebSocket
        await self.send(text_data=json.dumps({
            'message': message,
            'message_type': message_type,
            'display_mode': display_mode
        }))

    # Receive message from room group
    async def online_status(self, event):
        status = event['status']
        message_type = event['message_type']
        user_id = event['user_id']
        # Send message to WebSocket
        await self.send(text_data=json.dumps({
            'message_type': message_type,
            'user_id': user_id,
            'status': status
        }))



class ShopPrivateConsumer(AsyncWebsocketConsumer):
    async def connect(self):
        self.room_name = "room_"+str(self.scope["user"].id)
        self.room_group_name = 'shop_privateroom_%s'%(self.room_name)
        
        logger.error("PrivateRoome: %s"%(self.room_name))
        await self.channel_layer.group_add(
            self.room_group_name,
            self.channel_name
        )

        if self.room_name is None:
            await self.close()
        else:
            await self.accept()

    async def disconnect(self, close_code):

        await self.channel_layer.group_discard(
            self.room_group_name,
            self.channel_name
        )


    # Receive message from WebSocket
    async def receive(self, text_data):
        text_data_json = json.loads(text_data)
        message = text_data_json['message']
        message_type = text_data_json['message_type']
        display_mode = text_data_json['display_mode']


        await self.channel_layer.group_send(
            self.room_group_name,
            {
                'type': 'chat_message',
                'message': message,
                'message_type': message_type,
                'display_mode': display_mode
            }
        )

    # Receive message from room group
    async def chat_message(self, event):
        message = event['message']
        message_type = event['message_type']
        display_mode = event['display_mode']
        # Send message to WebSocket
        await self.send(text_data=json.dumps({
            'message': message,
            'message_type': message_type,
            'display_mode': display_mode
        }))

