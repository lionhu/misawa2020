from django.contrib import admin
from .models import Coupon

# Register your models here.

class CouponAdmin(admin.ModelAdmin):
	fields=("coupontype","description","discount",)
	list_display = ('coupontype', "slug",'description', 'discount',)
	readonly_fields = ('slug',)
	list_editable = ("slug",'description', 'discount',)
	search_fields = ("coupontype",)


admin.site.register(Coupon,CouponAdmin)