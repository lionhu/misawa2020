from django.contrib import admin
from .models import BankRate, Bonus, BonusDetail

# Register your models here.

class BankRateAdmin(admin.ModelAdmin):
	fields=("hui_in","hui_out","chao_in","chao_out","code",)
	list_display = ("hui_in","hui_out","chao_in","chao_out","code",)


admin.site.register(BankRate,BankRateAdmin)

# Register your models here.
class BonusDetailInline(admin.TabularInline):
	model = BonusDetail
	fields=("bonus","fromType","fromObjectID","description","currency","amount",)
	list_display=("bonus","fromType","fromObjectID","description","currency","amount","last_updated",)

class BonusAdmin(admin.ModelAdmin):
	fields=("user","currency","amount",)
	list_display =("user","currency","amount","last_updated",)
	inlines = [BonusDetailInline]
	search_fields = ("user",)

admin.site.register(Bonus,BonusAdmin)