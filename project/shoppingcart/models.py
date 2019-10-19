
import uuid
import os
from django.utils import timezone
from django.db import models,connection
from django.dispatch import receiver
from django.contrib.auth.models import User
from lottery_shop.models import Product
import logging
import datetime

logger=logging.getLogger("error_logger")

def get_image_path(instance, filename):
    # prefix = 'avatars/'
    prefix = "products/"
    name = str(uuid.uuid4()).replace('-', '')
    extension = os.path.splitext(filename)[-1]
    imagepath=prefix + name + extension
    logger.error(imagepath)
    return imagepath

def get_sentinel_user():
    return User.objects.get_or_create(username='deleted')[0]

def now_slug():
    dt=datetime.datetime.now().strftime("%I%S")
    return "%s%s"%(uuid.uuid4(),dt)


class Address(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    date_created = models.DateTimeField('Last modified',auto_now=True)
    user = models.ForeignKey(User, default=1,related_name="addresses",on_delete=models.SET(get_sentinel_user))
    first_name = models.CharField(default="",max_length=255)
    last_name = models.CharField(default="",max_length=255)
    email = models.CharField(default="",max_length=50)
    phone = models.CharField(default="",max_length=255, blank=True, null=True)
    postcode = models.CharField(default="",max_length=20)
    state = models.CharField(default="",max_length=255)
    city = models.CharField(default="",max_length=255)
    street_address1 = models.CharField(default="",max_length=255)
    street_address2 = models.CharField(default="",max_length=255, blank=True, null=True)

    class Meta:
        verbose_name="Address"
        app_label="shoppingcart"

    def __str__(self):
        return "%s %s"%(self.first_name,self.last_name)

 
class Cart(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    created = models.DateTimeField(auto_now_add=True)
    status = models.CharField(default="new",max_length=255, blank=True, null=True)
    user = models.ForeignKey('auth.User',on_delete=models.CASCADE, related_name="cart")

    class Meta:
        verbose_name="Cart"
        app_label="shoppingcart"

    def __str__(self):
        return "cart of %s "%(self.user.username)

class Order(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    created_at = models.DateTimeField(auto_now_add=True)
    cart = models.ForeignKey(Cart,on_delete=models.CASCADE, blank=True, null=True)
    user = models.ForeignKey('auth.User',on_delete=models.CASCADE, related_name="shoporders")
    address = models.ForeignKey('Address',on_delete=models.CASCADE)
    coupon =models.ForeignKey('Coupon',on_delete=models.CASCADE, blank=True, null=True)
    discount = models.IntegerField(default=0,null=True,blank=True)
    note = models.TextField(default="",blank=True,null=True,max_length=1024)
    cartjson = models.TextField(default="",blank=True,null=True,max_length=1024)

    class Meta:
        verbose_name="Order"
        app_label="shoppingcart"

    def __str__(self):
        return "%s"%(self.user.username)

    def get_total(self):
        Qty=0
        Total=0

        for cartitem in self.cart.cartitems:
            Qty += caritem.quantity
            Total += cartitem.sub_total

        return {'Qty':qty,'Total':Total}



class CartItem(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    product = models.ForeignKey(Product, null=True,blank=True,on_delete=models.CASCADE)
    cart = models.ForeignKey(Cart, on_delete=models.CASCADE,related_name="cartitems")
    quantity = models.IntegerField()
    active = models.BooleanField(default=True)
    created_at = models.DateTimeField(auto_now_add=True)
    status = models.CharField(default="new", max_length=50)

    class Meta:
        verbose_name="CartItem"
        app_label="shoppingcart"
        ordering=['slug'] 

    def sub_total(self):
        return self.product.price * self.quantity

    def __str__(self):
        return "CartItem %s"%(self.quantity)


 
class Coupon(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    created = models.DateTimeField(auto_now_add=True)
    description = models.CharField(default="",max_length=50, blank=True, null=True)
    discount = models.IntegerField(default=0,blank=True,null=True)

    class Meta:
        verbose_name="Coupon"
        app_label="shoppingcart"

    def __str__(self):
        return "%s: %s "%(self.coupon,self.discount)
