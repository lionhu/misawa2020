import uuid
import os
from django.utils import timezone
from django.db import models,connection
from django.dispatch import receiver
from django.contrib.auth.models import User
from imagekit.models import ImageSpecField, ProcessedImageField
from imagekit.processors import ResizeToFill
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
    return "%s_%s"%(uuid.uuid4(),dt)

class Catalogue(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    name = models.CharField(default="catalogue_name",max_length=128,blank=True)
    avatar = models.ImageField(upload_to=get_image_path,default="new.jpg", blank=True, null=True)
    thumbnail = ImageSpecField(source='avatar',
                            processors=[ResizeToFill(250,250)],
                            format="PNG",
                            options={'quality': 60}
                            )
    mod_date = models.DateTimeField('Last modified',auto_now=True)

    class Meta:
        verbose_name="Catalogue"
        app_label="lottery_shop"

    def __str__(self):
        return "{}".format(self.name)
    def __unicode__(self):
        return self.name

class Subcatalogue(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    catalogue = models.ForeignKey(Catalogue,on_delete=models.CASCADE, blank=True, null=True, related_name="subcatalogues")
    name = models.CharField(default="subcatalogue_name",max_length=128,blank=True)
    avatar = models.ImageField(upload_to=get_image_path,default="new.jpg", blank=True, null=True)
    thumbnail = ImageSpecField(source='avatar',
                            processors=[ResizeToFill(250,250)],
                            format="PNG",
                            options={'quality': 60}
                            )
    mod_date = models.DateTimeField('Last modified',auto_now=True)

    class Meta:
        verbose_name="Subatalogue"
        app_label="lottery_shop"

    def __str__(self):
        return "{}".format(self.name)

    def __unicode__(self):
        return self.name

class Product(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    name = models.CharField(default="catalogue_name",max_length=128,blank=True)
    purchase_price = models.IntegerField(default=0)
    price = models.IntegerField(default=0)
    point = models.IntegerField(default=0)
    open_price = models.IntegerField(default=0)
    wanted = models.IntegerField(default=0)
    ranks = models.IntegerField(default=0)
    main_product_id = models.IntegerField(default=0,blank=True,null=True)
    catalogue = models.ForeignKey(Subcatalogue,on_delete=models.CASCADE, blank=True, null=True, related_name="products")
    avatar = models.ImageField(upload_to=get_image_path,default="new.jpg", blank=True, null=True)
    thumbnail = ImageSpecField(source='avatar',
                            processors=[ResizeToFill(250,250)],
                            format="PNG",
                            options={'quality': 60}
                            )
    owner=models.ForeignKey(User,on_delete=models.CASCADE,related_name="products",blank=True,null=True)
    active = models.BooleanField(default=False)
    stock = models.IntegerField(default=0)
    mod_date = models.DateTimeField('Last modified',auto_now=True)


    class Meta:
        verbose_name="Product"
        app_label="lottery_shop"

    def __str__(self):
        return "{}".format(self.name)
    def __unicode__(self):
        return self.name

    def thumbimage(self):
    	return self.thumbnail.url

class WantedProduct(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    user=models.ForeignKey(User,on_delete=models.CASCADE,related_name="wanted_products",blank=True,null=True)
    product=models.ForeignKey(Product,on_delete=models.CASCADE,related_name="wanted_products",blank=True,null=True)
    quantity=models.IntegerField(default=0)
    created = models.DateTimeField('created',auto_now=True)


    class Meta:
        verbose_name="WantedProduct"
        app_label="lottery_shop"

    def __str__(self):
        return "{}".format(self.name)
    def __unicode__(self):
        return self.name
