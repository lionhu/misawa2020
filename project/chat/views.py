import json

from django.shortcuts import render
from django.utils.safestring import mark_safe
from channels.layers import get_channel_layer
from asgiref.sync import async_to_sync
from .models import Message
from useraccount.models import UserProfile
from env_system.ColoPayApiRequest import ColoPayApiRequest
import logging
logger=logging.getLogger("error_logger")
# Create your views here.

def index(request):

	channel_layer = get_channel_layer()


	if request.user.is_authenticated:
		# profile = UserProfile.objects.filter(user=request.user).first()
		async_to_sync(channel_layer.group_send)(
	    	'chat_lionhu',
	    	{
		    	'type': 'chat_message',
		    	'message': "message",
		    	'user': request.user.username,
		    	# 'avatar':profile.avatar.url,
	            'now_time': ""
	    	}
	    )

	rs=ColoPayApiRequest("2254808929160144",999,"テナントA商品")
	rs.generateSignature()
	rest=rs.post()
	logger.error(rest.text)


	return render(request, 'chat/index.html', {})


def room(request, room_name):
	group_name = 'chat_{}'.format(room_name)

	chat_messages = Message.objects.filter(group_name=group_name).order_by("created")[:100]
	print(chat_messages)
	return render(request, 'chat/room.html', {
        'chat_messages': chat_messages,
        'room_name': room_name,
        'group_name':group_name
    })
    
    # return render(request, 'chat/room.html', {
    #     'room_name_json': mark_safe(json.dumps(room_name))
    # })