from django.db import models
from django.db.models import Sum
from django.conf import settings
from django.contrib.postgres.fields import JSONField
import uuid

# Create your models here.
class BankRate(models.Model):
	hui_in = models.DecimalField(blank=True, max_digits=10, decimal_places=4,null=True, default=6.0000)
	hui_out = models.DecimalField(blank=True, max_digits=10, decimal_places=4,null=True, default=6.0000)
	chao_in = models.DecimalField(blank=True, max_digits=10, decimal_places=4,null=True, default=6.0000)
	chao_out = models.DecimalField(blank=True, max_digits=10, decimal_places=4,null=True, default=6.0000)
	name = models.CharField(max_length=10, null=False, blank=False)
	code = models.CharField(max_length=10, null=False, blank=False)
	created = models.DateTimeField(auto_now_add=True)

	class Meta:
		db_table = "bankrates"

	def __str__(self):
		return "{0},created:{1}".format(self.name,self.created.strftime("%Y/%m/%d %H:%M:%S"))

class Bonus(models.Model):

    # Fields
    slug = models.SlugField(null=True,blank=True,default=uuid.uuid4())
    created = models.DateTimeField(auto_now_add=True, editable=False)
    last_updated = models.DateTimeField(auto_now=True, editable=False)
    currency = models.CharField(max_length=5,default="rmb")
    amount = models.IntegerField(default=0)

    # Relationship Fields
    user = models.OneToOneField(
        settings.AUTH_USER_MODEL,
        on_delete=models.CASCADE, related_name="bonus", 
    )

    class Meta:
        ordering = ('-created',)


    def __str__(self):
        return "{}'s amount:{}".format(self.user.__str__,self.amount)

    def __unicode__(self):
        return u'%s' % self.slug

    def get_absolute_url(self):
        return reverse('exrate_bonus_detail', args=(self.slug,))


    def get_update_url(self):
        return reverse('exrate_bonus_update', args=(self.slug,))

    def recaculate_amount(self,currency):
    	return self.details.filter(currency=currency).aggregate(Sum('amount'))
    

class BonusDetail(models.Model):

    # Fields
    slug = models.SlugField(null=True,blank=True,default=uuid.uuid4())
    created = models.DateTimeField(auto_now_add=True, editable=False)
    last_updated = models.DateTimeField(auto_now=True, editable=False)
    currency = models.CharField(max_length=5,default="rmb")
    amount = models.IntegerField(default=0)
    fromType = models.CharField(max_length=20,blank=True,null=True)
    fromObjectID = models.IntegerField(blank=True, null=True)
    description = models.TextField(max_length=100)

    # Relationship Fields
    bonus = models.ForeignKey(
        Bonus,
        on_delete=models.CASCADE, related_name="details", 
    )

    class Meta:
        ordering = ('-created',)

    def __unicode__(self):
        return u'%s' % self.slug

    def get_absolute_url(self):
        return reverse('exrate_bonus_detail', args=(self.slug,))


    def get_update_url(self):
        return reverse('exrate_bonus_detail_update', args=(self.slug,))

# Create your models here.
class SystemEnv(models.Model):
    env_type = models.CharField(max_length=20, null=True, blank=True)
    name = models.CharField(max_length=50, null=False, blank=False)
    params=JSONField()
    created = models.DateTimeField(auto_now_add=True)

    class Meta:
        db_table = "systemEnvs"

    def __str__(self):
        return self.name
