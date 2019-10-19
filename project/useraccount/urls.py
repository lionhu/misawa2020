

from django.urls import path,include,re_path
from . import views

app_name="useraccount"
urlpatterns = [
    re_path(r'^profile/$', views.profile, name='profile'),
    re_path(r'^profile/update/$', views.profile_update, name='profile_update'),
    path('signup/', views.sign_up, name='new_signup'),
]