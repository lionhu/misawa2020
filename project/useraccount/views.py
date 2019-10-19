import json
import datetime,time

from django.http import HttpResponse
from django.http import HttpResponseRedirect,HttpResponse
from django.contrib.auth.models import Group
from django.urls import reverse
from django.contrib.auth.decorators import login_required
from django.contrib.auth import authenticate, login as auth_login, get_user_model
from django.contrib import messages
from django.contrib.auth.models import User
from django.db.models.signals import post_save
from django.shortcuts import render, get_object_or_404,redirect
from django.contrib.sites.shortcuts import get_current_site
from django.core.mail import EmailMessage
from django.template.loader import render_to_string
from django.utils.encoding import force_bytes, force_text
from .token_generator import account_activation_token
from django.utils.http import urlsafe_base64_encode, urlsafe_base64_decode
from django.contrib.auth.signals import user_logged_in,user_logged_out
from django.dispatch import receiver
from .models import UserProfile,EmailVerifyRecord
from .forms import SignupForm,ProfileForm
from django.conf import settings
import logging
import uuid

from rest_framework.permissions import IsAuthenticated
from rest_framework_jwt.authentication import JSONWebTokenAuthentication
from rest_framework.decorators import api_view, permission_classes, authentication_classes
from django.core import serializers


from django.contrib.auth.backends import ModelBackend
from django.db.models import Q

logger=logging.getLogger("error_logger")


def user_active(request,active_code):
    print("可以1")
    all_records = EmailVerifyRecord.objects.filter(code=active_code)
    if all_records:
        for record in all_records:
            email = record.email
            # 通过邮箱查找到对应的用户
            user = User.objects.get(email=email)
            # 激活用户
            user.is_active = True
            user.save()
        print("可以")
    print("不行")

    return HttpResponse(active_code)


@api_view(['GET'])
@permission_classes((IsAuthenticated, ))
@authentication_classes((JSONWebTokenAuthentication,))
def users(request):
    users = User.objects.all()
    users_list = serializers.serialize('json', users)
    return HttpResponse(users_list, content_type="text/json-comment-filtered")


@login_required
def profile(request):
	user = request.user
	return render(request, 'account/profile.html', {
		'user': user
	})

def show_signup(request):
    introcode = request.GET.get("introcode") if request.GET.get("introcode") is not None else "lionhu"

    return render(request, 'vue_single.html', {
        'introcode': introcode
    })


@login_required
def profile_update(request):
	user = request.user
	user_profile = UserProfile.objects.filter(user=user).first()

	if user_profile is None:
		user_profile=UserProfile(
				user = user,
				organization = "KOUN",
				telephone = "**********009",
				avatar = "/new.jpg",
				mod_date = datetime.datetime.now()
			)

	if request.method == "POST":
		form = ProfileForm(request.POST,request.FILES)
		if form.is_valid():
			user.first_name = form.cleaned_data['first_name']
			user.last_name = form.cleaned_data['last_name']
			user.save()


			print("form data comming")
			print(form)

			user_profile.organization = form.cleaned_data['org']
			user_profile.telephone = form.cleaned_data['telephone']
			user_profile.avatar = form.cleaned_data['avatar'] if form.cleaned_data['avatar']  else "new.jpg"
			user_profile.id_image = form.cleaned_data['id_image'] if form.cleaned_data['id_image']  else "id.png"
			user_profile.save()

			return HttpResponseRedirect(reverse('useraccount:profile'))
	else:
			# user_profile = get_object_or_404(UserProfile, user=user)

			default_data = {'first_name': user.first_name, 'last_name': user.last_name,
			'org': user_profile.organization, 'telephone': user_profile.telephone, 
			'avatar': user_profile.avatar,"id_image":user_profile.id_image}
			form = ProfileForm(default_data)
			print("form data to display")
	return render(request, 'account/profile_update.html', {
		'form': form, 
		'avatar': user_profile.avatar, 
		'user': user
		})


def get_default_ancestor(_slug):
    profile = UserProfile.objects.filter(slug=_slug).first()

    if profile is None:
        profile = UserProfile.objects.get(user_id=settings.ADMIN_ROOT_ID)
        return profile.user

    return profile.user

def sign_up(request):
    logger.error(request.GET.get("introcode"))
    if request.method == 'POST':
        introducer=request.POST.get("introcode")
        logger.error(request.POST)

        signup_form = SignupForm(request.POST)
        logger.error(not signup_form.is_valid())
        logger.error(signup_form.errors)

        if not signup_form.is_valid():
            logger.info("error in form data")
            context = {
               'form': signup_form,
               "introcode": request.POST.get("introcode"),
               "errors":signup_form.errors
             }
            logger.info(context)

            return render(request, 'account/signup.html', context)
        
        if signup_form.is_valid():
            logger.error("signup_form.is_valid")
            username = signup_form.cleaned_data.get('username')
            email = signup_form.cleaned_data.get('email')
            password = signup_form.cleaned_data.get('password1')

            user = User.objects.create_user(username, email, password)

            logger.error(user)
            user = authenticate(request, username=username, password=password)
            auth_login(request, user, backend='django.contrib.auth.backends.ModelBackend')

            ancestor=get_default_ancestor(introducer)
            logger.error(introducer)
            user_profile = UserProfile.objects.create(
                telephone = "+81 13913288888",
                slug = uuid.uuid4(),
                organization = signup_form.cleaned_data['nickname'],
                avatar = "new.jpg",
                user = user,
                father_id = ancestor.id,
                grandfather_id = ancestor.profile.father.id,
                partner_id = ancestor.profile.father.id
            )
            current_site = get_current_site(request)
            email_subject = 'Activate Your Account'
            message = render_to_string('account/verification_sent.html', {
                'user': user,
                'domain': current_site.domain,
                'uid': urlsafe_base64_encode(force_bytes(user.pk)),
                'token': account_activation_token.make_token(user),
            })
            to_email = signup_form.cleaned_data.get('email')
            email = EmailMessage(email_subject, message, to=[to_email])
            email.send()

            messages.add_message(request, messages.SUCCESS, 'ユーザー登録が完了しました！')
            return redirect('/')
 
    else:
        signup_form = SignupForm()
        introcode = request.GET.get("introcode", default="hogehoge")
        context = {
            'form': signup_form,
            "introcode": introcode
        }
        logger.error("sign_up not POST")
        logger.error(context)
    
    return render(request, 'account/signup.html', context)
