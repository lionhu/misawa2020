from .models import Order,Offer,Transaction

from rest_framework import serializers
from useraccount.serializers import UserSerializer,UserProfileSerializer,UserProfileSerializer_Full
from useraccount.models import UserProfile
from django.contrib.auth.models import User
import uuid
import datetime
from django.conf import settings

# class SimpleOrderSerializer(serializers.ModelSerializer):
    
#     class Meta:
#         model = Order
#         fields = (
#             'id',
#             'slug',
#             "status",
#             'created',
#             'amount',
#             'send_notification',
#             'from_currency',
#             'to_currency',
#         )

# class PureOrderSerializer(serializers.ModelSerializer):
#     # offers = serializers.PrimaryKeyRelatedField(many=True,read_only=True)
#     user = serializers.ReadOnlyField(source="user.username")

#     class Meta:
#         model = Order
#         fields = (
#             'id',
#             'slug',
#             'created',
#             "status",
#             'last_updated',
#             'amount',
#             'from_currency',
#             'to_currency',
#             'due_at',
#             'rate',
#             'active',
#             'privacy',
#             'price',
#             'send_notification',
#             "memo",
#             "user"
#             # "offers"
#         )

#     def to_representation(self,instance):
#         result = super().to_representation(instance)
#         result["offers_num"]=instance.offers.count()
#         return result

# class OrderSerializer(serializers.ModelSerializer):
#     user = UserSerializer(read_only = True)
#     user_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)

#     def create(self, validated_data):
#         validated_data['user'] = validated_data.get('user_id', None)

#         if validated_data['user'] is None:
#             raise serializers.ValidationError("user not found.") 

#         del validated_data['user_id']

#         validated_data['slug'] = str(uuid.uuid4())
#         validated_data["bonuspoint"]=int(settings.AUCTION_ORDER_BONUS_JPY)*validated_data["amount"]

#         if validated_data["from_currency"]=="rmb" and validated_data["to_currency"]=="jpy":
#           validated_data["rate_alpha"]= settings.ORDER_MARGINRATE_RMB
#         else:
#           validated_data["rate_alpha"]= settings.ORDER_MARGINRATE_JPY

#         return Order.objects.create(**validated_data)

#     def update(self, instance, validated_data):

#         validated_data['user'] = validated_data.get('user_id', None)

#         if validated_data['user'] is None:
#             raise serializers.ValidationError("user not found")

#         instance.user = validated_data['user']
#         instance.status = "updated"
#         instance.amount = validated_data.get("amount",instance.amount)
#         instance.save()
#         return instance


#     class Meta:
#         model = Order
#         fields = (
#             'id',
#             'slug',
#             'user_id',
#             "user",
#             'created',
#             "status",
#             'last_updated',
#             'amount',
#             'from_currency',
#             'to_currency',
#             'due_at',
#             'rate',
#             'active',
#             'privacy',
#             'price',
#             'send_notification',
#             "memo"
#         )


# class PublicOfferListSerializer(serializers.ModelSerializer):
#     follower = serializers.ReadOnlyField(source = "follower.username")

#     class Meta:
#         model = Offer
#         fields = (
#             'id',
#             'slug', 
#             "follower",
#             'created', 
#             'last_updated', 
#             'price', 
#             'currency',
#             'due_at', 
#             'send_notification', 
#             'status', 
#         )




# Good for user
class AdminOrderSerializer(serializers.ModelSerializer):
    user = serializers.ReadOnlyField(source = "user.username")
    transaction = serializers.PrimaryKeyRelatedField(many=False,read_only=True)
    class Meta:
        model = Order
        fields = (
            'id',
            'slug',
            'created',
            'last_updated',
            'amount',
            "bonuspoint",
            'from_currency',
            'to_currency',
            'due_at',
            'rate',
            'rate_alpha',
            'active',
            "status",
            'privacy',
            'send_notification',
            'memo',
            'user',
            'over_due',
            'price',
            'price_alpha',
            'transaction',

        )

    def to_representation(self,instance):
        result = super().to_representation(instance)
        result["offers_num"]=instance.offers.count()
        return result



# Good for user
class AdminOfferSerializer(serializers.ModelSerializer):
    follower = serializers.ReadOnlyField(source = "follower.username")

    class Meta:
        model = Offer
        fields = "__all__"



# Good for user
class PublicOrderSerializer(serializers.ModelSerializer):
    user=serializers.ReadOnlyField(source="user.username")
    transaction = serializers.PrimaryKeyRelatedField(many=False,read_only=True)

    def __init__(self, *args, **kwargs):
        context = kwargs.pop("context")
        self.user_id = context.get('user_id')
        super(PublicOrderSerializer, self).__init__(*args, **kwargs)

    class Meta:
        model = Order
        fields = ('id',"slug",'user',"status",'transaction','amount','from_currency','privacy','to_currency',"due_at","rate","rate_alpha","memo","send_notification",)
        write_only=("rate","rate_alpha")
        read_only=("price","privacy")

    def to_representation(self,instance):
        result = super().to_representation(instance)
        result["offers_num"]=instance.offers.count()

        if instance.user.id !=self.user_id:
            result["isOrderOwner"]=False
            result["price"]=instance.price_alpha

            if instance.from_currency =="jpy":
                rate=instance.rate+instance.rate_alpha
            else:
                rate=instance.rate-instance.rate_alpha

            result["rate"]=rate
        else:
            result["isOrderOwner"]=True
            result["price"]=instance.price
            result["rate"]=instance.rate

        return result


# Good for user
class OfferSerializer(serializers.ModelSerializer):
    follower = serializers.ReadOnlyField(source="follower.username")

    def __init__(self, *args, **kwargs):
        context = kwargs.pop("context")
        self.IsOrderUser = context.get('IsOrderUser')
        self.offer_alpha = context.get('offer_alpha')

        super(OfferSerializer, self).__init__(*args, **kwargs)

    class Meta:
        model = Offer
        fields = ('id','slug',"follower",'created', 'last_updated', 'currency',
            'due_at', 'send_notification', 'status',"price",)

    def to_representation(self,instance):
        result = super().to_representation(instance)

        if self.IsOrderUser:
            result["price"]=instance.price-self.offer_alpha
        else:
            result["price"]=instance.price
        return result


# Good for user
class TransactionsSerializer(serializers.ModelSerializer):
    class Meta:
        model=Transaction
        fields=(
            "id",
            "slug",
            "status",
            "created",
        )


# class PublicOrderSerializer_withOffers(serializers.ModelSerializer):
    # offers = PublicOfferListSerializer(read_only=True,many=True)
    # user = serializers.ReadOnlyField(source="user.username")

    # class Meta:
    #     model = Order
    #     fields = ( 'id', 'slug', 'created', "status", 'last_updated',
    #         'amount', 'from_currency', 'to_currency',
    #         'due_at', 'rate', 'active', 'privacy', 'price', 'send_notification', "memo", "user","offers")

    # def to_representation(self,instance):
    #     result = super().to_representation(instance)
    #     result["offers_num"]=instance.offers.count()

    #     user_id=self.context["user_id"]

    #     if instance.user.id !=user_id:
    #         result["price"]=instance.price_alpha

    #         if instance.from_currency =="jpy":
    #             rate=instance.rate+instance.rate_alpha
    #         else:
    #             rate=instance.rate-instance.rate_alpha

    #         result["rate"]=rate
    #     else:
    #         result["price"]=instance.price
    #         result["rate"]=instance.rate

    #     return result


# class UserOfferSerializer(serializers.ModelSerializer):
#     order = SimpleOrderSerializer(read_only = True)
#     order_id = serializers.PrimaryKeyRelatedField(queryset=Order.objects.all(), write_only=True)

#     class Meta:
#         model = Offer
#         fields = (
#             'id',
#             'slug', 
#             'order_id',
#             "order",
#             'created', 
#             'last_updated', 
#             'price', 
#             'currency',
#             'due_at', 
#             'send_notification', 
#             'status', 
#         )


# class OfferSerializer_withSimpleOrder(serializers.ModelSerializer):
#     follower = UserSerializer(read_only = True)
#     follower_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)

#     class Meta:
#         model = Offer
#         fields = (
#             'id',
#             'slug', 
#             'follower_id',
#             "follower",
#             'order_id',
#             'created', 
#             'last_updated', 
#             'price', 
#             'due_at', 
#             'status', 
#         )


# class OfferSerializer_withOrder(serializers.ModelSerializer):
#     follower = UserSerializer(read_only = True)
#     follower_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)
#     order = OrderSerializer(read_only = True)
#     order_id = serializers.PrimaryKeyRelatedField(queryset=Order.objects.all(), write_only=True)
    
#     def create(self, validated_data):
#         validated_data['follower'] = validated_data.get('follower_id', None)
#         validated_data['order'] = validated_data.get('order_id', None)

#         if validated_data['follower'] is None :
#             raise serializers.ValidationError("follower not found.") 

#         del validated_data['follower_id']

#         if validated_data['order'] is None :
#             raise serializers.ValidationError("order not found.") 

#         # del validated_data['order']
#         del validated_data['order_id']

#         validated_data['slug'] = str(uuid.uuid4())

#         return Offer.objects.create(**validated_data)

#     def update(self, instance, validated_data):
#         instance.price=validated_data.get("price",instance.price)
#         instance.due_at=validated_data.get("due_at",instance.due_at)
#         instance.last_updated=datetime.datetime.now()
#         instance.save()
#         return instance


#     class Meta:
#         model = Offer
#         fields = (
#             'id',
#             'slug', 
#             'follower_id',
#             "follower",
#             'order_id',
#             "order",
#             "currency",
#             'created', 
#             'last_updated', 
#             'price', 
#             'due_at', 
#             'send_notification', 
#             'status', 
#         )


# class OrderSerializer_withOffers(serializers.ModelSerializer):
#     # offers = OfferSerializer(read_only=True,many=True)
#     user = serializers.ReadOnlyField(source="user.username")

#     class Meta:
#         model = Order
#         fields = (
#             'id',
#             'slug',
#             'created',
#             "status",
#             'last_updated',
#             'amount',
#             'from_currency',
#             'to_currency',
#             'due_at',
#             'rate',
#             'active',
#             'privacy',
#             'price',
#             'send_notification',
#             "memo",
#             "user"
#             # "offers"
#         )
#     def to_representation(self,instance):
#         result = super().to_representation(instance)
#         result["offers_num"]=instance.offers.count()
#         return result


# class OrderSerializer_byUser(serializers.ModelSerializer):
#     orders = PureOrderSerializer(read_only=True,many=True)
#     profile = UserProfileSerializer_Full(read_only=True,many=False)
#     class Meta:
#         model = User
#         fields=("orders","profile")

# class OrderSerializer_withOffers_byUser(serializers.ModelSerializer):
#     orders = OrderSerializer_withOffers(read_only=True,many=True)
#     profile = UserProfileSerializer_Full(read_only=True,many=False)
#     class Meta:
#         model = User
#         fields=("orders","profile")




# class PublicOrders_Serializer(serializers.ModelSerializer):
#     user=UserSerializer(read_only=True,many=False)
#     offers=serializers.PrimaryKeyRelatedField(queryset=Offer.objects.all(),many=True)

#     def __init__(self, *args, **kwargs):
#       vss=kwargs.pop('extra', {})
#       self.user_id = vss.get("user_id")
#       super(PublicOrders_Serializer, self).__init__(*args, **kwargs)

#     class Meta:
#         model = Order
#         fields = (
#             'id',
#             "slug",
#             'user',
#             "status",
#             'amount',
#             'from_currency',
#             'to_currency',
#             'rate',
#             "due_at",
#             "offers"
#         )
#     def to_representation(self, instance):
#         result = super().to_representation(instance)

#         if instance.user.id !=self.user_id:
#             if instance.from_currency=="jpy" and instance.to_currency=="rmb":
#               new_rate=float(result["rate"])+settings.ORDER_MARGINRATE_JPY
#               result["rate"]=int(new_rate*10000)/10000
#               result["price"]=int(instance.amount*result["rate"]*100)
            
#             if instance.from_currency=="rmb" and instance.to_currency=="jpy":
#               new_rate=float(result["rate"])-settings.ORDER_MARGINRATE_RMB
#               result["rate"]=int(new_rate*10000)/10000
#               result["price"]=int(instance.amount/result["rate"])*100
#         else:
#             if instance.from_currency=="jpy" and instance.to_currency=="rmb":
#               new_rate=float(result["rate"])
#               result["rate"]=int(new_rate*10000)/10000
#               result["price"]=int(instance.amount*result["rate"]*100)
            
#             if instance.from_currency=="rmb" and instance.to_currency=="jpy":
#               new_rate=float(result["rate"])
#               result["rate"]=int(new_rate*10000)/10000
#               result["price"]=int(instance.amount/result["rate"])*100
              
#         return result
