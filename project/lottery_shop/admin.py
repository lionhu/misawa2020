from django.contrib import admin
from .models import Catalogue,Subcatalogue,Product

# Register your models here.

class SubcatalogueInline(admin.TabularInline):
	model = Subcatalogue

class ProductInline(admin.TabularInline):
	model = Product


class CatalogueAdmin(admin.ModelAdmin):
	fields=("name","avatar",)
	inlines = [SubcatalogueInline]
	search_fields = ("name",)


admin.site.register(Catalogue,CatalogueAdmin)
admin.site.register([Product])