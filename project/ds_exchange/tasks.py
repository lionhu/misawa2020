# from __future__ import absolute_import, unicode_literals
# from celery import shared_task,task, chain, uuid
# from django.core.cache import cache
# import json
# import logging
# from django.core.mail import EmailMessage
# from django.template.loader import render_to_string
# from django.conf import settings
# from .models import Order


# logger=logging.getLogger("error_logger")

# @task
# def sendEmail_OrderOwner_OfferChange(order_slug):


#     logger.error("in sendEmail_OrderOwner_OfferChange function: {%s}"%(order_slug))


#     order=Order.objects.filter(slug=order_slug).first()
#     logger.error(order)

