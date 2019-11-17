from django.contrib import admin
from .models import Catalogue,Subcatalogue,Product

# Register your models here.

class SubcatalogueInline(admin.TabularInline):
	model = Subcatalogue

class CatalogueAdmin(admin.ModelAdmin):
	fields=("name","avatar",)
	inlines = [SubcatalogueInline]
	search_fields = ("name",)


class ProductAdmin(admin.ModelAdmin):
	list_display = ('name', "purchase_price",'price', 'open_price','point',)
	list_editable = ("purchase_price",'price', 'open_price','point')
	fieldsets = (
        (None, {
            'fields': ('active', "name","owner")
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
        }),
    )
	search_fields = ("name",)


admin.site.register(Catalogue,CatalogueAdmin)
admin.site.register(Product,ProductAdmin)