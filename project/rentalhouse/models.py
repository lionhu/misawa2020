from django.db import models
from django.contrib.postgres.fields import JSONField
from django.contrib.auth.models import User
import logging
from django.utils.timezone import now
import datetime
import uuid
from lottery_shop.models import Product
from shoppingcart.models import Address

logger=logging.getLogger("error_logger")

RentalStatus = (
    ('booked', 'booked'),
    ('toCustomer', 'toCustomer'),
    ('fromCustomer', 'fromCustomer'),
    ('inTrouble', 'inTrouble'),
    ('completed', 'completed'),
)
def now_slug():
    dt=datetime.datetime.now().strftime("%I%S")
    return "rt_%s_%s"%(uuid.uuid4(),dt)



class ProductRank(models.Model):
    name = models.CharField(default="A",max_length=10,blank=False)
    price = models.IntegerField(default=0)

    class Meta:
        db_table = "rental_productranks"



class RentalProduct(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    sn = models.CharField(default="serialno",max_length=50,blank=False)
    product = models.ForeignKey(Product,on_delete=models.CASCADE, blank=False, null=False, related_name="rentalproducts")
    condition = models.CharField(default="new",max_length=20,blank=True)
    rank = models.ForeignKey(ProductRank,on_delete=models.CASCADE,blank=False,null=False,related_name="rankproducts")
    avaliable = models.BooleanField(default=False)

    class Meta:
        db_table = "rental_products"
        verbose_name="RentalProduct"
        app_label="rentalhouse"


    def __str__(self):
        return "%s_%s"%(self.product.name,self.sn)




class RentalHistory(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    product = models.ForeignKey(RentalProduct,on_delete=models.CASCADE, blank=False, null=False, related_name="histories")
    user = models.ForeignKey(User,on_delete=models.CASCADE,blank=False,null=False,related_name="myhistories")
    start_at = models.DateTimeField(null=False,blank=False,default= now)
    end_at = models.DateTimeField(null=False,blank=False,default= now)
    days = models.IntegerField(null=False,blank=False,default= 0)
    status = models.CharField(choices=RentalStatus,default="booked",max_length=20)
    address = models.ForeignKey(Address,on_delete=models.CASCADE,blank=True,null=True)
    memo = models.TextField(default="memo",max_length=1024)

    class Meta:
        db_table = "rental_histories"
        verbose_name="RentalHistory"
        app_label="rentalhouse"


    def __str__(self):
        return "%s_<%s-%s>"%(self.product.product.name,self.start_at,self.end_at)

    def rentalfee(self):
        return self.days * self.product.rank.price

