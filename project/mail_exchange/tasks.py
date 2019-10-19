from __future__ import absolute_import, unicode_literals
from celery import shared_task,task, chain, uuid
from django.core.cache import cache
import json
import logging
from django.core.mail import EmailMessage
from django.template.loader import render_to_string
from django.conf import settings
from .models import Order


logger=logging.getLogger("error_logger")

@task
def sendEmail_OrderOwner_OfferChange(order_slug):


    logger.error("in sendEmail_OrderOwner_OfferChange function: {%s}"%(order_slug))


    order=Order.objects.filter(slug=order_slug).first()
    logger.error(order)
    # if order is not None:
        # html_content = render_to_string('emails/OrderOwner_OfferChanged_notification.htm',{'order':order,'url':"url"})
        # msg = EmailMessage("[Exrate Notification]Your Order status changed",html_content,settings.DEFAULT_FROM_EMAIL,["huhaiguang@me.com"])
        # msg.content_subtype = "html" # Main content is now text/html
        # msg.send()

