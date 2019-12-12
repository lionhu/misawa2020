import uuid
import os
from django.utils import timezone
from django.db import models,connection
from django.dispatch import receiver
from django.contrib.auth.models import User
from imagekit.models import ImageSpecField, ProcessedImageField
from imagekit.processors import ResizeToFill
from django.contrib.postgres.fields import JSONField
import logging
import datetime

logger=logging.getLogger("error_logger")

ProductImageType = (
    ('iframe', 'iframe'),
    ('video', 'video'),
    ('standard', 'standard'),
    ('Others', 'Others'),
)

SNSType = (
    ('youtube', 'youtube'),
    ('facebook', 'facebook'),
    ('twitter', 'twitter'),
    ('instagram', 'instagram'),
    ('line', 'line'),
    ('wechat', 'wechat'),
)


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

# class Product(models.Model):
#     slug = models.SlugField(null=True,blank=True,default=now_slug)
#     name = models.CharField(default="catalogue_name",max_length=256,blank=True)
#     main_product_id = models.IntegerField(default=0,blank=True,null=True)
#     catalogue = models.ForeignKey(Subcatalogue,on_delete=models.CASCADE, blank=True, null=True, related_name="products")
#     manufacturer = models.CharField(default="manufacturer",max_length=128,blank=True)
#     brand = models.CharField(default="brand",max_length=128,blank=True)
#     vendor=models.ForeignKey(User,on_delete=models.CASCADE,related_name="products",blank=True,null=True)
#     specs = models.CharField(default="specs",max_length=256,blank=True)
#     sku = models.CharField(default="sku",max_length=128,blank=True)
    
#     purchase_price = models.IntegerField(default=0)
#     price = models.IntegerField(default=0)
#     point = models.IntegerField(default=0)
#     open_price = models.IntegerField(default=0)
    
#     wanted = models.IntegerField(default=0)
#     ranks = models.IntegerField(default=0)
#     avatar = models.ImageField(upload_to=get_image_path,default="new.jpg", blank=True, null=True)
#     thumbnail = ImageSpecField(source='avatar',
#                             processors=[ResizeToFill(250,250)],
#                             format="PNG",
#                             options={'quality': 60}
#                             )
                            
#     active = models.BooleanField(default=False)
#     stock = models.IntegerField(default=0)
#     mod_date = models.DateTimeField('Last modified',auto_now=True)


#     class Meta:
#         verbose_name="Product"
#         app_label="lottery_shop"

#     def __str__(self):
#         return "{}".format(self.name)
#     def __unicode__(self):
#         return self.name

#     def thumbimage(self):
#     	return self.thumbnail.url



class Product(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    name = models.CharField(default="product name",max_length=256,blank=True)
    subtitle = models.CharField(default="subtitle",max_length=256,blank=True)
    main_product_id = models.IntegerField(default=0,blank=True,null=True)
    catalogue = models.ForeignKey(Subcatalogue,on_delete=models.CASCADE, blank=True, null=True, related_name="products")
    manufacturer = models.CharField(default="manufacturer",max_length=128,blank=True)
    brand = models.CharField(default="brand",max_length=128,blank=True)
    vendor=models.ForeignKey(User,on_delete=models.CASCADE,related_name="products",blank=True,null=True)
    specs = models.CharField(default="specs",max_length=256,blank=True)
    sku = models.CharField(default="sku",max_length=128,blank=True)
    
    purchase_price = models.IntegerField(default=0)
    price = models.IntegerField(default=0)
    point = models.IntegerField(default=0)
    open_price = models.IntegerField(default=0)
    
    wanted = models.IntegerField(default=0)
    ranks = models.IntegerField(default=0)
    avatar = models.ImageField(upload_to=get_image_path,default="new.jpg", blank=True, null=True)
    thumbnail = ImageSpecField(source='avatar',
                            processors=[ResizeToFill(250,250)],
                            format="PNG",
                            options={'quality': 60}
                            )
                            
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

class snsURL(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    mediatype = models.CharField(default="facebook",max_length=10,choices=SNSType)
    product = models.ForeignKey("Product",on_delete=models.CASCADE, blank=True, null=True, related_name="snsURLs")
    description = models.CharField(default="description",max_length=256,blank=True)
    href = models.CharField(default="href",max_length=256,blank=True)
    memo = models.CharField(default="memo",max_length=1024,blank=True)
    created = models.DateTimeField('created',auto_now=True)


    class Meta:
        verbose_name="snsURL"
        app_label="lottery_shop"

    def __str__(self):
        return "{} snsURL".format(self.product.id)

    def __unicode__(self):
        return self.self.product.id

class GalleryImage(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    mediatype = models.CharField(default="Image",max_length=10,choices=ProductImageType)
    product = models.ForeignKey("Product",on_delete=models.CASCADE, blank=True, null=True, related_name="medias")
    postimage = models.ImageField(upload_to=get_image_path,default="new.jpg", blank=True, null=True)
    thumbnail = ImageSpecField(source='postimage',
                            processors=[ResizeToFill(320,320)],
                            format="PNG",
                            options={'quality': 80}
                            )
    title = models.CharField(default="title",max_length=256,blank=True)
    description = models.CharField(default="description",max_length=256,blank=True)
    href = models.CharField(default="href",max_length=256,blank=True)
    memo = models.CharField(default="memo",max_length=1024,blank=True)
    created = models.DateTimeField('created',auto_now=True)


    class Meta:
        verbose_name="GalleryImage"
        app_label="lottery_shop"

    def __str__(self):
        return "{} image".format(self.product.id)
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
    price_overflow=models.IntegerField(default=0)
    feedbackprice_overflow=models.IntegerField(default=0)
    
    created = models.DateTimeField('created',auto_now=True)


    class Meta:
        verbose_name="Groupon"
        app_label="lottery_shop"

    def __str__(self):
        return "{}".format(self.name)

    def __unicode__(self):
        return self.name

    def applicants_count(self):
        return self.applicants.count()

    def target_overflow(self):
        return True if self.applicants.count() >=self.target else False


class Applicant(models.Model):
    slug = models.SlugField(null=True,blank=True,default=now_slug)
    groupon=models.ForeignKey(Groupon,on_delete=models.CASCADE,blank=False,null=False,related_name="applicants")    
    address=JSONField(blank=True,null=True)
    user=models.ForeignKey(User,on_delete=models.CASCADE,related_name="user_applicants",blank=False,null=False)
    num=models.IntegerField(default=0)
    price=models.IntegerField(default=0)
    feedbackprice=models.IntegerField(default=0)

    deposite_paycode = models.CharField(default="",max_length=20,blank=False)
    deposite_paid = models.BooleanField(default=False)
    deposite_paid_at = models.DateTimeField('deposite_paid_at',auto_now=True)

    orderpaid = models.BooleanField(default=False)
    orderpaid_at = models.DateTimeField('order_paid_at',auto_now=True)
    

    delivery_status = models.CharField(default="delivery status",max_length=20,blank=False)
    delivery_no = models.CharField(default="delivery_no",max_length=50,blank=False)
    

    created = models.DateTimeField('created',auto_now=True)


    class Meta:
        verbose_name="GrouponApplicant"
        app_label="lottery_shop"

    def __str__(self):
        return "{}".format(self.user.username)

    def __unicode__(self):
        return self.user.username

    def deposite_amount(self):
        return self.num*self.groupon.price

    def feedback_amount(self):
        return self.num*self.groupon.feedbackprice

    def applicant_amount(self):
        return self.num*self.groupon.product.price

