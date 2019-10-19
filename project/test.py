# coding: UTF-8
from useraccount.models import UserProfile
from django.contrib.auth.models import User



UserProfile.objects.create(user_id=1,organization="admin",telephone="08043608496")