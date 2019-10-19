from django.contrib.auth.models import User
from useraccount.models import UserProfile
from useraccount.serializers import UserWithFullProfileSerializer
user=User.objects.get(pk=1)

serializer=UserWithFullProfileSerializer(user,many=False)