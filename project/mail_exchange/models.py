from django.db import models,connection
from collections import namedtuple
from django.dispatch import receiver
from django.db.models.signals import post_save
from django.contrib.auth.models import User
from django.conf import settings
import datetime
import uuid
import math
import logging

logger=logging.getLogger("error_logger")

def uuid_time():
    now=datetime.datetime.now()
    nowstr=now.strftime("%Y%m%d%H%M%S")
    return str(uuid.uuid4())+nowstr

class Order(models.Model):

    # Fields
    slug = models.SlugField(default=uuid_time,null=True, blank=True)
    created = models.DateTimeField(auto_now_add=True, editable=False)
    last_updated = models.DateTimeField(auto_now=True, editable=False)
    amount = models.IntegerField(default=0)
    bonuspoint = models.IntegerField(default=0)
    from_currency = models.CharField(max_length=3,default="jpy")
    to_currency = models.CharField(max_length=3,default="rmb")
    due_at = models.DateTimeField(null=False,blank=False,default= datetime.datetime.now()+datetime.timedelta(hours=72))
    rate = models.DecimalField(max_digits=10, decimal_places=4)
    rate_alpha = models.DecimalField(default=0,max_digits=10, decimal_places=4)
    active = models.BooleanField(default=False)
    status = models.CharField(max_length=10, default="new")
    privacy = models.CharField(max_length=10,default="public")
    send_notification = models.BooleanField(default=False)
    memo = models.TextField(blank=True,null=True,default="...")

    # Relationship Fields
    user = models.ForeignKey(User,on_delete=models.CASCADE, related_name="orders",)

    class Meta:
        app_label = "mail_exchange"
        permissions = (
            ("can_place_order","Can place order"),
            ("can_edit_order","Can edit order"),
            )

    def __str__(self):
        return "%s's order"%self.user

    def __unicode__(self):
        return u'%s' % self.slug
    #
    def get_absolute_url(self):
        return reverse('mail_exchange_bill_detail', args=(self.slug,))


    def get_update_url(self):
        return reverse('mail_exchange_bill_update', args=(self.slug,))

    @property
    def over_due(self):
        dt = datetime.datetime.now()
        return True if dt - self.due_at else False

    @property
    def price(self):
        price=0

        if self.from_currency=="jpy":
            price = math.floor(self.amount*self.rate*100)
        else:
            price = math.floor(self.amount/self.rate*100)
        return price

    @property
    def price_alpha(self):
        price=0
        new_rate=0

        if self.from_currency=="jpy":
            new_rate=self.rate+self.rate_alpha
            price = math.floor(self.amount*new_rate*100)
        else:
            new_rate=self.rate-self.rate_alpha
            price = math.floor(self.amount/new_rate*100)
        return price

    @property
    def p_bonus(self):
        bonus = math.floor(self.amount/10*settings.ORDER_BONUS_PARENT)
        return bonus

    @property
    def gp_bonus(self):
        bonus = math.floor(self.amount/10*settings.ORDER_BONUS_GRANTPARENT)
        return bonus

    @property
    def dis_bonus(self):
        bonus = math.floor(self.amount/10*settings.ORDER_BONUS_DISTRIBUTOR)
        return bonus

class Offer(models.Model):

    # Fields
    slug = models.SlugField(default=uuid.uuid4(),null=True, blank=True)
    created = models.DateTimeField(auto_now_add=True, editable=False)
    last_updated = models.DateTimeField(auto_now=True, editable=False)
    price = models.IntegerField(default=0)
    currency = models.CharField(max_length=3,default="rmb")
    due_at = models.DateTimeField(null=False,blank=False,default= datetime.datetime.now()+datetime.timedelta(hours=72))
    send_notification = models.BooleanField(default=False)
    status = models.CharField(max_length=10)

    # Relationship Fields
    follower = models.ForeignKey(User,on_delete=models.CASCADE, related_name="follower",)
    order = models.ForeignKey(Order,on_delete=models.CASCADE, related_name="offers",)

    class Meta:
        permissions = (
            ("can_place_offer","Can place offer"),
            ("can_edit_offer","Can edit offer"),
            )

    def __unicode__(self):
        return u'%s' % self.slug

    def get_absolute_url(self):
        return reverse('mail_exchange_offer_detail', args=(self.slug,))


    def get_update_url(self):
        return reverse('mail_exchange_offer_update', args=(self.slug,))

    def over_due(self):
        dt = datetime.datetime.now()
        return True if dt - self.due_at else False


class Transaction(models.Model):

    slug = models.SlugField(default=uuid.uuid4(),null=True, blank=True)
    created = models.DateTimeField(auto_now_add=True, editable=False)
    order = models.OneToOneField(Order,on_delete=models.CASCADE, related_name="transaction",)
    offer = models.OneToOneField(Offer,on_delete=models.CASCADE, related_name="transaction",)
    status = models.CharField(max_length=10,default="new")

    def __str__(self):
        return "orderid:%s , offerid:%s" % (self.order.id,self.offer.id)


@receiver(post_save, sender=Order)
def create_enrolled_record(sender, instance=None, created=False, **kwargs):

    logger.error("in post_save function")
    logger.error(instance)


