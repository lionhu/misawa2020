
from channels.generic.websocket import AsyncWebsocketConsumer
from django.core import serializers
from django.conf import settings
import logging
import datetime
import json
# from .models import Message
# from .serializers import ChatMessageSerializer
# from useraccount.models import UserProfile
# from musics.tasks import task_mail_chatmessage
# from useraccount.models import UserProfile



logger=logging.getLogger("error_logger")


class RentalHouseEventConsumer(AsyncWebsocketConsumer):
    async def connect(self):
        self.room_name = self.scope['url_route']['kwargs']['product_slug']
        self.room_group_name = 'rentalhouse_%s' % self.room_name
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
        product_slug = text_data_json['product_slug']
        rentalproduct_slug = text_data_json['rentalproduct_slug']
        start_at = text_data_json['start_at']
        end_at = text_data_json['end_at']
        user = str(self.scope['user'])
        now_time=datetime.datetime.now().strftime(settings.DATETIME_FORMAT)

        if not self.scope['user'].is_authenticated:
            return

        await self.channel_layer.group_send(
            self.room_group_name,
            {
                'type': 'event_message',
                'user': user,
                'product_slug': product_slug,
                'rentalproduct_slug': rentalproduct_slug,
                'start_at': start_at,
                'end_at': end_at,
                'now_time': now_time
            }
        )

    # Receive message from room group
    async def event_message(self, event):
        user = event['user']
        product_slug = event['product_slug']
        rentalproduct_slug = event['rentalproduct_slug']
        start_at = event['start_at']
        end_at = event['end_at']
        now_time = event['now_time']
        # Send message to WebSocket
        await self.send(text_data=json.dumps({
            'message': ": "+message,
            'user': user,
            'product_slug': product_slug,
            'rentalproduct_slug': rentalproduct_slug,
            'start_at': start_at,
            'end_at': end_at,
            'now_time': now_time
        }))


