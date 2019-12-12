from django.contrib import admin
from .models import Catalogue,Subcatalogue,Product,Groupon,Applicant,\
            GalleryImage,snsURL

# Register your models here.

class SubcatalogueInline(admin.TabularInline):
	model = Subcatalogue

class CatalogueAdmin(admin.ModelAdmin):
	fields=("name","avatar",)
	inlines = [SubcatalogueInline]
	search_fields = ("name",)

# class ProductImageInline(admin.TabularInline):
# 	model = ProductImage
# 	readonly_fields = ('slug',)
		


class GalleryImageInline(admin.TabularInline):
    model = GalleryImage
    extra=0

class snsURLInline(admin.TabularInline):
    model = snsURL
    extra=0


class ProductAdmin(admin.ModelAdmin):
	list_display = ('name', "purchase_price",'price', 'open_price','point')
	list_editable = ("purchase_price",'price', 'open_price','point')
	inlines = [GalleryImageInline,snsURLInline]
	fieldsets = (
        (None, {
            'fields': ('active', "name","vendor")
        }),
        ('Image', {
            'fields': ("avatar",),
        }),
        ('Price', {
            # 'classes': ('collapse',),
            'fields': ("purchase_price",'price', 'open_price','point'),
        }),
        ('catalogue', {
            'fields': ("catalogue",'main_product_id'),
        }),
        ('Others', {
            'fields': ('stock', 'ranks')
        })
    )
	search_fields = ("name",)


class ApplicantInline(admin.TabularInline):
	model = Applicant
	readonly_fields = ('slug',)
		

class GrouponAdmin(admin.ModelAdmin):
	list_display = ('name', "product",'status', 'target',)
	# list_editable = ("purchase_price",'price', 'open_price','point')
	inlines = [ApplicantInline]
	fieldsets = (
        (None, {
            'fields': ('product',"status")
        }),
        (None, {
            'fields': ("name","description"),
        }),
        (None, {
            # 'classes': ('collapse',),
            'fields': ("target",'price', 'feedbackprice',),
        }),
    )
	search_fields = ("name",)


        

admin.site.register(Groupon,GrouponAdmin)
admin.site.register(Catalogue,CatalogueAdmin)
admin.site.register(Product,ProductAdmin)