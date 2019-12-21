from __future__ import absolute_import, unicode_literals
from celery import shared_task,task, chain, uuid
from django.core.mail import send_mail,EmailMessage
from env_system.ShowapiRequest import ShowapiRequest
from django.core.cache import cache
import json
from rest_framework.authtoken.models import Token
import logging
from django.template.loader import render_to_string
from django.conf import settings
from .models import DSOrder as Order


logger=logging.getLogger("error_logger")

@task
def notifyNewDSOrder(order_slug):
    logger.error("notify %s about new Direct Order placed"%(order_slug))

    logger.error(order_slug)

    order=Order.objects.filter(slug=order_slug).first()

    url="%s/superadmin/#/dsorders"%(settings.HOSTNAME)
    if order is not None:
        html_content = render_to_string('emails/ADMIN_newDSOrder.htm',{'order':order,'url':url})
        msg = EmailMessage("[Exrate ADMIN Notification]New DS Order",html_content,settings.DEFAULT_FROM_EMAIL,[order.user.email,settings.ADMIN_ROOT_EMAIL])
        msg.content_subtype = "html" # Main content is now text/html
        msg.send()