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
    name = models.CharField(default="catalogue_name",max_length=256,blank=True)
    Manufacturer = models.CharField(default="Manufacturer",max_length=128,blank=True)
    specs = models.CharField(default="specs",max_length=256,blank=True)
    sku = models.CharField(default="sku",max_length=128,blank=True)
    
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
    vendor=models.ForeignKey(User,on_delete=models.CASCADE,related_name="products",blank=True,null=True)
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



class ProductImage(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    product = models.ForeignKey(Product,on_delete=models.CASCADE, blank=True, null=True, related_name="images")
    avatar = models.ImageField(upload_to=get_image_path,default="new.jpg", blank=True, null=True)
    thumbnail = ImageSpecField(source='avatar',
                            processors=[ResizeToFill(320,320)],
                            format="PNG",
                            options={'quality': 80}
                            )
    created = models.DateTimeField('created',auto_now=True)


    class Meta:
        verbose_name="ProductImages"
        app_label="lottery_shop"

    def __str__(self):
        return "{}".format(self.product.id)
    def __unicode__(self):
        return self.self.product.id

    def thumbimage(self):
    	return self.thumbnail.url

class Groupon(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    product=models.OneToOneField(Product,related_name="groupon",on_delete=models.CASCADE,blank=False,null=False)
    name = models.CharField(default="groupon name",max_length=1024,blank=False)
    description = models.CharField(default="description of groupon",max_length=1024,blank=True)
    status = models.CharField(default="groupon status",max_length=20,blank=False)
    target=models.IntegerField(default=0)
    price=models.IntegerField(default=0)
    feedbackprice=models.IntegerField(default=0)
    
    created = models.DateTimeField('created',auto_now=True)


    class Meta:
        verbose_name="Groupon"
        app_label="lottery_shop"

    def __str__(self):
        return "{}".format(self.name)

    def __unicode__(self):
        return self.name


class Applicant(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    groupon=models.OneToOneField(Groupon,on_delete=models.CASCADE,blank=False,null=False)
    user=models.ForeignKey(User,on_delete=models.CASCADE,related_name="groupon_applicants",blank=False,null=False)
    status = models.CharField(default="status",max_length=20,blank=False)
    num=models.IntegerField(default=0)
    created = models.DateTimeField('created',auto_now=True)


    class Meta:
        verbose_name="GrouponApplicant"
        app_label="lottery_shop"

    def __str__(self):
        return "{}".format(self.user.username)

    def __unicode__(self):
        return self.user.username
