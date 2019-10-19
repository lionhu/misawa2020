from __future__ import absolute_import, unicode_literals
from celery import shared_task,task, chain, uuid
from django.core.cache import cache
import json
import logging
from django.core.mail import EmailMessage
from django.template.loader import render_to_string
from django.conf import settings
from shoppingcart.models import Cart,CartItem,Product
import datetime


logger=logging.getLogger("error_logger")

@task
def ClearOutdatedCart():
		
	dt=datetime.datetime.now()-datetime.timedelta(hours=3)
	carts=Cart.objects.filter(created__lte=dt,status="new")

	if carts is not None:
		for cart in carts :

			cartitems=CartItem.objects.filter(cart=cart,status="new")

			if cartitems is not None:
				for cartitem in cartitems:
					product=Product.objects.filter(pk=cartitem.product.id).first()

					if product is not None:
						product.stock += cartitem.quantity
						product.save()
					cartitem.delete()

			cart.delete()

