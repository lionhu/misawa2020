from __future__ import absolute_import, unicode_literals
from celery import shared_task,task, chain, uuid
from django.core.mail import send_mail
from env_system.ShowapiRequest import ShowapiRequest
from django.core.cache import cache
import json
import decimal
import random
from exrate.models import BankRate
from useraccount.models import EmailVerifyRecord
from rest_framework.authtoken.models import Token
import logging
from django.core.mail import EmailMessage
from django.template.loader import render_to_string
from django.conf import settings
from mail_exchange.models import Order


logger=logging.getLogger("error_logger")

def random_str(randomlength=8):
    str = ''
    chars = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789'
    length = len(chars) - 1

    for i in range(randomlength):
        str += chars[random.randint(0, length)]
    return str


@shared_task
def task_mail(message):
    subject = 'message from chat'
    message = 'message: {}'.format(message)
    mail_sent = send_mail(subject,
                          message,
                          'huhaiguang@me.com',
                          ['lionhu2009@gmail.com'])
    return mail_sent

@task
def sendEmail(email="huhaiguang@me.com"):
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


@shared_task
def fetch_bankrate(toUser):
    subject = 'message from chat'
    r = ShowapiRequest("http://route.showapi.com/105-32","76812","ff6b110b4d884acf9d1ddc030a16c5a0" )
    r.addBodyPara("bankCode", "icbc")
    res = r.post()

    data=json.loads(res.text)

    fetch_error = data["showapi_res_error"]

    logger.error(data)
    if not fetch_error:
      rates=data["showapi_res_body"]["codeList"]
      data_time=data["showapi_res_body"]["time"]
      data_day=data["showapi_res_body"]["day"]
      l_names = [d.get("name") for d in rates]

      jpy_index = l_names.index("日元")

      if jpy_index >-1:
        jpy_rate=rates[jpy_index]
        jpy_rate_db = {
            "name":"jpy",
            "code":jpy_rate["code"],
            "hui_in":decimal.Decimal(jpy_rate["hui_in"]),
            "hui_out":decimal.Decimal(jpy_rate["hui_out"]),
            "chao_in":decimal.Decimal(jpy_rate["chao_in"]),
            "chao_out":decimal.Decimal(jpy_rate["chao_out"])
          }
        jpy_rate = {
            "name":"jpy",
            "time":data_time,
            "day":data_day,
            "code":jpy_rate["code"],
            "hui_in":decimal.Decimal(jpy_rate["hui_in"]),
            "hui_out":decimal.Decimal(jpy_rate["hui_out"]),
            "chao_in":decimal.Decimal(jpy_rate["chao_in"]),
            "chao_out":decimal.Decimal(jpy_rate["chao_out"])
          }
        BankRate.objects.create(**jpy_rate_db)

        cache.set("todayrate",jpy_rate,3600)
        logger.error(cache.get("todayrate"))

    html_content = render_to_string('emails/todayrate.html',{'todayrate':jpy_rate})
    msg = EmailMessage("[Exrate Notification]Today's rate",html_content,settings.DEFAULT_FROM_EMAIL,[toUser])
    msg.content_subtype = "html" # Main content is now text/html
    msg.send()

@shared_task
def task_mail_chatmessage(message):
    subject = 'message from chat'
    message = 'message: {}'.format(message)
    mail_sent = send_mail(subject,
                          message,
                          'huhaiguang@me.com',
                          ['lionhu2009@gmail.com'])
    return mail_sent


@shared_task
def register_notification(email):
    subject = 'register_notification from Celery '
    message = 'User {} has been registered.'.format(email)
    mail_sent = send_mail(subject,
                          message,
                          'huhaiguang@me.com',
                          ['huhaiguang@me.com'])
    return mail_sent

@task
def sendEmail_OrderOwner_OfferChange(order_slug):


    logger.error("in sendEmail_OrderOwner_OfferChange function: {%s}"%(order_slug))


    order=Order.objects.filter(slug=order_slug).first()
    logger.error(order)
    logger.error(order.user.email)
    url="%s/exrate/#/singleorder/%s"%(settings.HOSTNAME,order.slug)
    if order is not None:
        html_content = render_to_string('emails/OrderOwner_OfferChanged_notification.htm',{'order':order,'url':url})
        msg = EmailMessage("[Exrate Notification]Your Order status changed",html_content,settings.DEFAULT_FROM_EMAIL,[order.user.email])
        msg.content_subtype = "html" # Main content is now text/html
        msg.send()


@task
def sendEmail_newuser_registered(username,email):


    logger.error("in sendEmail_newuser_registered function: {%s}"%(username))

    url="%s/admin/user/%s"%(settings.HOSTNAME,username)
    html_content = render_to_string('emails/register_notifications.htm',{'title':"New User Registered",'url':url,"username":username,"email":email})
    msg = EmailMessage("[Exrate Notification]New User Registered",html_content,settings.DEFAULT_FROM_EMAIL,["huhaiguang@me.com"])
    msg.content_subtype = "html" # Main content is now text/html
    msg.send()



