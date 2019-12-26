from django_filters import rest_framework as filters
from .models import Order

class OrderFilter(filters.FilterSet):
    first_name = filters.CharFilter( lookup_expr='contains')
    
    class Meta:
        model = Order
        fields = ("total","first_name")

    # @property
    # def qs(self):
    #     parent = super().qs
    #     owner = getattr(self.request,"user",None)

    #     return parent(user = owner)