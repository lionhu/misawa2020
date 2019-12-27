# chat/routing.py
from django.urls import path

from .consumers import RentalHouseEventConsumer

websocket_urlpatterns = [
    path('wss/rentalhouse/<str:product_slug>/', RentalHouseEventConsumer),
]