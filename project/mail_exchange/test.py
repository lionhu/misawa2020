import datetime

from django.test import TestCase
from django.utils import timezone

from useraccount.models import User
from .models import Order


class OrderModelTests(TestCase):

    def test_create_order(self):
        """
        was_published_recently() returns False for questions whose pub_date
        is in the future.
        """
        user = User.objects.filter(username="root").first()
        time = timezone.now() + datetime.timedelta(days=30)
        order=Order.objects.create(amount = 10,from_currency = "jpy",to_currency = "rmb",rate = 6.4136,user=user)