from __future__ import absolute_import, unicode_literals
from celery import shared_task,task, chain, uuid
from django.core.mail import send_mail
from env_system.ShowapiRequest import ShowapiRequest
from django.core.cache import cache
import json
import decimal
import random
from useraccount.models import EmailPasswordReset
from rest_framework.authtoken.models import Token
import logging
from django.core.mail import EmailMessage
from django.template.loader import render_to_string
from django.conf import settings


logger=logging.getLogger("error_logger")

def random_str(randomlength=8):
    str = ''
    chars = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789'
    length = len(chars) - 1

    for i in range(randomlength):
        str += chars[random.randint(0, length)]
    return str

@task
def sendEmail(email):
    email_record = EmailVerifyRecord()
    # 将给用户发的信息保存在数据库中
    # code, created = Token.objects.get_or_create(user=user)
    code = random_str(16)
    email_record.code = code
    email_record.email = email
    email_record.save()
    logger.error(email_record)
    # 初始化为空
    email_title = "注册激活链接"
    email_body = " 同学你好，欢迎参加本次计算机基础知识大赛，"+"请点击下面的链接激活你的账号:http://localhost:2080/users/active/{0}".format(code)
    # 发送邮件
    # send_status = send_mail(email_title, email_body, DEFAULT_FROM_EMAIL, [email])

    html_content = render_to_string('email.html',{'authcode':code,'title':"标题标题",'operation':"operation_str"})
    msg = EmailMessage("您的验证码",html_content,settings.DEFAULT_FROM_EMAIL,[email])
    msg.content_subtype = "html" # Main content is now text/html
    msg.send()

    # msg = EmailMessage(email_title,email_body,DEFAULT_FROM_EMAIL,[email])
    # msg.send()


@task
def sendPasswordResetEmail(email="test@me.com"):
    email_record = EmailPasswordReset.objects.filter(email=email).first()
    token = random_str(16)

    if email_record is None:
        email_record = EmailPasswordReset()

    email_record.token = token
    email_record.email = email
    email_record.save()
    logger.error(email_record)
    # 初始化为空
    # email_title = "Password Reset"
    # email_body = "Click following link to reset your password, "+"http://"+hostname+"/password/reset/{0}".format(token)
    # 发送邮件
    # send_status = send_mail(email_title, email_body, DEFAULT_FROM_EMAIL, [email])

    url_link="https://www.exrate.world/member/#/resetpassword?token={}".format(token)

    logger.error(url_link)
    html_content = render_to_string('email/password_reset_notification.htm',{'url_link':url_link,"title":"Reset Password"})
    msg = EmailMessage("Password Reset",html_content,settings.DEFAULT_FROM_EMAIL,[email])
    msg.content_subtype = "html" # Main content is now text/html
    msg.send()

    # msg = EmailMessage(email_title,email_body,DEFAULT_FROM_EMAIL,[email])
    # msg.send()


@task
def register_notification(email):
    subject = 'register_notification from Celery '
    message = 'User {} has been registered.'.format(email)
    mail_sent = send_mail(subject,
                          message,
                          'huhaiguang@me.com',
                          ['lionhu2009@gmail.com'])
    return mail_sent

