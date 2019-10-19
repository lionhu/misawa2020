from django import forms
from .models import UserProfile
from allauth.account.forms import SignupForm
from django.contrib.auth.models import User

# from imagekit.forms import ProcessedImageField
# from imagekit.processors import ResizeToFill

from musics.tasks import send_mail,register_notification

class ProfileForm(forms.Form):
	first_name = forms.CharField(label='First Name', max_length=50, required=False)
	last_name = forms.CharField(label='Last Name', max_length=50, required=False)
	org = forms.CharField(label='Organization', max_length=50, required=False)
	avatar = forms.ImageField(required = False)
	id_image = forms.ImageField(required = False)
	telephone = forms.CharField(label='Telephone', max_length=50, required=False)


def get_default_ancestor():
	root = User.objects.filter(username="root").first()
	return root.id if root else 1

		

class SignupForm(SignupForm):
	nickname = forms.CharField(max_length=30,label="NickName")

	def save(self,request):
		user=super(SignupForm,self).save(request)


		ancestor_id=get_default_ancestor()
		user_profile = UserProfile.objects.create(
			telephone = "+81 13913288888",
			organization = self.cleaned_data['nickname'],
			avatar = "new.jpg",
			user = user,
			father_id = ancestor_id,
			grandfather_id = ancestor_id,
			partner_id = ancestor_id)

		user.save()

		return user