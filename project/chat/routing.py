# chat/routing.py
from django.urls import path

from . import consumers

websocket_urlpatterns = [
    path('ws/chat/<str:room_name>/', consumers.ChatConsumer),
    path('ws/vuechat/<str:room_name>/', consumers.VueChatConsumer),
    path('ws/systemchannel/<str:room_name>/', consumers.PublicConsumer),
    
    path('wss/vuechat/<str:room_name>/', consumers.VueChatConsumer),
    path('wss/systemchannel/<str:room_name>/', consumers.PublicConsumer),

    # Shop Related ShopPrivateConsumer
    path('wss/shop/public/', consumers.ShopPublicConsumer),
    path('wss/shop/product/', consumers.ShopProductConsumer),
    path('wss/shop/private/', consumers.ShopPrivateConsumer),
]