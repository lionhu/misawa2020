import uuid
import os
from django.utils import timezone
from django.db import models,connection
from django.contrib.auth.signals import user_logged_in,user_logged_out
from django.dispatch import receiver
from collections import namedtuple
from django.contrib.auth.models import User
from allauth.account.models import EmailAddress
from imagekit.models import ImageSpecField, ProcessedImageField
from imagekit.processors import ResizeToFill
import uuid
import logging
import datetime

logger=logging.getLogger("error_logger")

# Create your models here.

MEMBERSHIP_CHOICES=(
        ("B","Bronze"),
        ("S","Silver"),
        ("D","Diamond"),
        ("P","Partner"),
    )

def namedtuplefetchall(cursor):
    # Return all rows from a cursor as a namedtuple
    desc = cursor.description
    nt_result = namedtuple('Result', [col[0] for col in desc])
    return [nt_result(*row) for row in cursor.fetchall()]


def fun_sql_cursor_update(**kwargs):
    organization = kwargs.get('organization')
    telephone = kwargs.get('telephone')
    pk = kwargs.get('pk')

    '''
    Note that if you want to include literal percent signs in the query, 
    you have to double them in the case you are passing parameters:
    '''
    with connection.cursor() as cursor:
        cursor.execute("UPDATE useraccount_userprofile SET organization = %s,  telephone = %s WHERE id = %s", [organization, telephone, pk])
        cursor.execute("SELECT profile.*, auth_user.username FROM useraccount_userprofile as profile LEFT JOIN auth_user  ON profile.user_id = auth_user.id WHERE profile.id = %s", [pk])
        # result = cursor.fetchone()
        result = namedtuplefetchall(cursor)

    result = [
        {
            'id': r.id,
            'user': r.username,
            'organization': r.organization,
            'telephone': r.telephone
        }
        for r in result
    ]

    return result

def get_image_path(instance, filename):
    # prefix = 'avatars/'
    prefix = "{}/avatars/".format(instance.user.id)
    name = str(uuid.uuid4()).replace('-', '')
    extension = os.path.splitext(filename)[-1]
    return prefix + name + extension

def get_ID_image_path(instance,filename):
    prefix = "{}/IDimages/".format(instance.user.id)
    name = str(uuid.uuid4()).replace("-","")
    extension = os.path.splitext(filename)[-1]
    return prefix + name + extension

def get_wechat_image_path(instance,filename):
    prefix = "{}/Wechat/".format(instance.user.id)
    name = str(uuid.uuid4()).replace("-","")
    extension = os.path.splitext(filename)[-1]
    return prefix + name + extension

def get_line_image_path(instance,filename):
    prefix = "{}/Line/".format(instance.user.id)
    name = str(uuid.uuid4()).replace("-","")
    extension = os.path.splitext(filename)[-1]
    return prefix + name + extension


def get_thumbnail_path(self, filename):
    prefix = 'avatars/thumbnail'
    name = str(uuid.uuid4()).replace('-', '')
    extension = os.path.splitext(filename)[-1]
    return prefix + name + extension

def get_default_ancestor():
    root = User.objects.get(username="root")
    return root if root else null

class UserToken(models.Model):
    user=models.OneToOneField(User,on_delete=models.CASCADE, related_name="usertoken")
    token = models.CharField(default="", max_length=64)


        
class UserProfile(models.Model):
    slug = models.SlugField(null=True,blank=True,default=uuid.uuid4())
    user = models.OneToOneField(User,on_delete=models.CASCADE, related_name="profile")
    father = models.ForeignKey(User,on_delete=models.SET(get_default_ancestor), blank=True, null=True, related_name="sons")
    grandfather = models.ForeignKey(User,on_delete=models.SET(get_default_ancestor), blank=True, null=True, related_name="grandsons")
    partner = models.ForeignKey(User,on_delete=models.SET(get_default_ancestor), blank=True, null=True, related_name="decendants")
    organization = models.CharField('Organization',max_length=128,blank=True)
    language = models.CharField(default='jp',max_length=10,blank=True)
    membership = models.CharField(choices=MEMBERSHIP_CHOICES, max_length=5,default="B")
    tradesum_sons = models.IntegerField(default=0)
    tradesum_grandsons = models.IntegerField(default=0)
    telephone = models.CharField("Telephone",max_length=50,blank=True)
    avatar = models.ImageField(upload_to=get_image_path,default="new.jpg", blank=True, null=True)
    thumbnail = ImageSpecField(source='avatar',
                            processors=[ResizeToFill(250,250)],
                            format="PNG",
                            options={'quality': 60}
                            )
    id_image= models.ImageField(upload_to=get_ID_image_path,default="id.png",blank =True,null=True)
    wechat= models.ImageField(upload_to=get_wechat_image_path,default="id.png",blank =True,null=True)
    line= models.ImageField(upload_to=get_line_image_path,default="id.png",blank =True,null=True)
    approved = models.BooleanField(default=False)
    canTakeBonus = models.BooleanField(default=False)
    online = models.BooleanField(default=False)
    mod_date = models.DateTimeField('Last modified',auto_now=True)

    class Meta:
        verbose_name:"User Profile"

    def __str__(self):
        return "{}'s profile".format(self.user.__str__)
    # def __str__(self):
    #     return "label:{}".format(self.user.username)

    def account_verified(self):
        if self.user.is_authenticated:
            result = EmailAddress.objects.filter(email = self.user.email)
            if len(result):
                return result[0].verfied
        return False

    def isDistributor(self):
        return True if self.user.id == self.partner.id else False
    
    def hasChildren(self):
        return True if self.user.id == self.father.id or self.user.id == self.grandfather.id else False
        
    def sons_sum(self):
        return User.objects.filter(father = self.id).count()

    def grandsons_sum(self):
        return User.objects.filter(grandfather = self.id).count()

    def thumbimage(self):
        return self.thumbnail.url
        

class VisitHistory(models.Model):
    user = models.ForeignKey(User,verbose_name="user",on_delete=models.CASCADE)
    login_time = models.DateTimeField("login_time",blank=True,null=True)
    logout_time = models.DateTimeField("logout_time",blank=True,null=True)

    def __str__(self):
        return '{0} - {1}'.format(
            self.user.username, self.get_diff_time()
        )

    def get_diff_time(self):
        if not self.logout_time:
            return 'still logining'
        else:
            td = self.logout_time - self.login_time
            return '{0}時間{1}分'.format(
                td.seconds // 3600, (td.seconds // 60) % 60)

@receiver(user_logged_in)
def user_logged_in_callback(sender, request, user, **kwargs):
    VisitHistory.objects.create(user=user, login_time=timezone.now())


@receiver(user_logged_out)
def user_logged_out_callback(sender, request, user, **kwargs):
    records = VisitHistory.objects.filter(user=user, logout_time__isnull=True)
    if records:
        record = records.latest('pk')
        record.logout_time = timezone.now()
        record.save()


class EmailVerifyRecord(models.Model):
    # 验证码
    code = models.CharField(max_length=20, verbose_name=u"verifycode")
    email = models.EmailField(max_length=50, verbose_name=u"email")
    # 包含注册验证和找回验证
    send_time = models.DateTimeField(verbose_name=u"send_time", auto_now=True)
    class Meta:
        verbose_name = u"verify_email"
        verbose_name_plural = verbose_name

    def __str__(self):
        return self.email


class EmailPasswordReset(models.Model):
    # 验证码
    token = models.CharField(max_length=20, verbose_name=u"password_token")
    email = models.EmailField(max_length=50, verbose_name=u"email")
    # 包含注册验证和找回验证
    send_time = models.DateTimeField(verbose_name=u"send_time", auto_now=True)
    class Meta:
        verbose_name = u"password_token"
        verbose_name_plural = verbose_name

    def __str__(self):
        return self.email

