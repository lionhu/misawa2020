# from django.contrib import admin
# from .models import DSOrder

# class OfferInline(admin.TabularInline):
# 	model = Offer
# 	fields=("price","due_at","status","follower",)

# class OrderAdmin(admin.ModelAdmin):
# 	fields=("amount","from_currency","to_currency","due_at","rate","status",
# 		"active","privacy","send_notification","user",)
# 	list_display = ("amount","from_currency","to_currency","over_due","rate",
# 		"active","status","user",)
# 	inlines = [OfferInline]
# 	search_fields = ("user",)


# admin.site.register(Order,OrderAdmin)

