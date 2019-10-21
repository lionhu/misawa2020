from .models import Order,Offer,Transaction

from rest_framework import serializers
from useraccount.serializers import UserSerializer,UserProfileSerializer,UserProfileSerializer_Full
from useraccount.models import UserProfile
from django.contrib.auth.models import User
import uuid
import datetime
from django.conf import settings

class SimpleOrderSerializer(serializers.ModelSerializer):
    
    class Meta:
        model = Order
        fields = (
            'id',
            'slug',
            "status",
            'created',
            'amount',
            'send_notification',
            'from_currency',
            'to_currency',
        )

class PureOrderSerializer(serializers.ModelSerializer):
    offers = serializers.PrimaryKeyRelatedField(many=True,read_only=True)

    class Meta:
        model = Order
        fields = (
            'id',
            'slug',
            'created',
            "status",
            'last_updated',
            'amount',
            'from_currency',
            'to_currency',
            'due_at',
            'rate',
            'active',
            'privacy',
            'price',
            'send_notification',
            "memo",
            "offers"
        )

class OrderSerializer(serializers.ModelSerializer):
    user = UserSerializer(read_only = True)
    user_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)

    def create(self, validated_data):
        validated_data['user'] = validated_data.get('user_id', None)

        if validated_data['user'] is None:
            raise serializers.ValidationError("user not found.") 

        del validated_data['user_id']

        validated_data['slug'] = str(uuid.uuid4())
        validated_data["bonuspoint"]=int(settings.AUCTION_ORDER_BONUS_JPY)*validated_data["amount"]

        return Order.objects.create(**validated_data)

    def update(self, instance, validated_data):

        validated_data['user'] = validated_data.get('user_id', None)

        if validated_data['user'] is None:
            raise serializers.ValidationError("user not found")

        instance.user = validated_data['user']
        instance.status = "updated"
        instance.amount = validated_data.get("amount",instance.amount)
        instance.save()
        return instance


    class Meta:
        model = Order
        fields = (
            'id',
            'slug',
            'user_id',
            "user",
            'created',
            "status",
            'last_updated',
            'amount',
            'from_currency',
            'to_currency',
            'due_at',
            'rate',
            'active',
            'privacy',
            'price',
            'send_notification',
            "memo"
        )


class OfferSerializer(serializers.ModelSerializer):
    follower = UserSerializer(read_only = True)
    follower_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)

    class Meta:
        model = Offer
        fields = (
            'id',
            'slug', 
            'follower_id',
            "follower",
            'created', 
            'last_updated', 
            'price', 
            'currency',
            'due_at', 
            'send_notification', 
            'status', 
        )


class UserOfferSerializer(serializers.ModelSerializer):
    order = SimpleOrderSerializer(read_only = True)
    order_id = serializers.PrimaryKeyRelatedField(queryset=Order.objects.all(), write_only=True)

    class Meta:
        model = Offer
        fields = (
            'id',
            'slug', 
            'order_id',
            "order",
            'created', 
            'last_updated', 
            'price', 
            'currency',
            'due_at', 
            'send_notification', 
            'status', 
        )




class TransactionsSerializer(serializers.ModelSerializer):
    order = OrderSerializer(read_only = True)
    order_id = serializers.PrimaryKeyRelatedField(queryset=Order.objects.all(), write_only=True)
    offer = OfferSerializer(read_only = True)
    offer_id = serializers.PrimaryKeyRelatedField(queryset=Offer.objects.all(), write_only=True)

    class Meta:
        model=Transaction
        fields=(
            "id",
            "slug",
            "status",
            "order",
            "order_id",
            "offer",
            "offer_id",
            "created",
        )

    def create(self, validated_data):
        validated_data['offer'] = validated_data.get('offer_id', None)
        validated_data['order'] = validated_data.get('order_id', None)

        if validated_data['offer'] is None :
            raise serializers.ValidationError("offer_id not found.") 

        del validated_data['offer_id']

        if validated_data['order'] is None :
            raise serializers.ValidationError("order not found.") 

        # del validated_data['order']
        del validated_data['order_id']

        validated_data['slug'] = str(uuid.uuid4())

        return Transaction.objects.create(**validated_data)


class OfferSerializer_withSimpleOrder(serializers.ModelSerializer):
    follower = UserSerializer(read_only = True)
    follower_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)

    class Meta:
        model = Offer
        fields = (
            'id',
            'slug', 
            'follower_id',
            "follower",
            'order_id',
            'created', 
            'last_updated', 
            'price', 
            'due_at', 
            'status', 
        )




class OfferSerializer_withOrder(serializers.ModelSerializer):
    follower = UserSerializer(read_only = True)
    follower_id = serializers.PrimaryKeyRelatedField(queryset=User.objects.all(), write_only=True)
    order = OrderSerializer(read_only = True)
    order_id = serializers.PrimaryKeyRelatedField(queryset=Order.objects.all(), write_only=True)
    
    def create(self, validated_data):
        validated_data['follower'] = validated_data.get('follower_id', None)
        validated_data['order'] = validated_data.get('order_id', None)

        if validated_data['follower'] is None :
            raise serializers.ValidationError("follower not found.") 

        del validated_data['follower_id']

        if validated_data['order'] is None :
            raise serializers.ValidationError("order not found.") 

        # del validated_data['order']
        del validated_data['order_id']

        validated_data['slug'] = str(uuid.uuid4())

        return Offer.objects.create(**validated_data)

    def update(self, instance, validated_data):
        instance.price=validated_data.get("price",instance.price)
        instance.due_at=validated_data.get("due_at",instance.due_at)
        instance.last_updated=datetime.datetime.now()
        instance.save()
        return instance


    class Meta:
        model = Offer
        fields = (
            'id',
            'slug', 
            'follower_id',
            "follower",
            'order_id',
            "order",
            "currency",
            'created', 
            'last_updated', 
            'price', 
            'due_at', 
            'send_notification', 
            'status', 
        )


class OrderSerializer_withOffers(serializers.ModelSerializer):
    offers = OfferSerializer(read_only=True,many=True)

    class Meta:
        model = Order
        fields = (
            'id',
            'slug',
            'created',
            "status",
            'last_updated',
            'amount',
            'from_currency',
            'to_currency',
            'due_at',
            'rate',
            'active',
            'privacy',
            'price',
            'send_notification',
            "memo",
            "offers"
        )



class OrderSerializer_byUser(serializers.ModelSerializer):
    orders = PureOrderSerializer(read_only=True,many=True)
    profile = UserProfileSerializer_Full(read_only=True,many=False)
    class Meta:
        model = User
        fields=("orders","profile")

class OrderSerializer_withOffers_byUser(serializers.ModelSerializer):
    orders = OrderSerializer_withOffers(read_only=True,many=True)
    profile = UserProfileSerializer_Full(read_only=True,many=False)
    class Meta:
        model = User
        fields=("orders","profile")




class PublicOrders_Serializer(serializers.ModelSerializer):
    user=UserSerializer(read_only=True,many=False)
    offers=serializers.PrimaryKeyRelatedField(queryset=Offer.objects.all(),many=True)

    def __init__(self, *args, **kwargs):
      vss=kwargs.pop('extra', {})
      self.user_id = vss.get("user_id")
      super(PublicOrders_Serializer, self).__init__(*args, **kwargs)

    class Meta:
        model = Order
        fields = (
            'id',
            "slug",
            'user',
            "status",
            'amount',
            'from_currency',
            'to_currency',
            'rate',
            "due_at",
            "offers"
        )
    def to_representation(self, instance):
        result = super().to_representation(instance)

        if instance.user.id !=self.user_id:
            if instance.from_currency=="jpy" and instance.to_currency=="rmb":
              new_rate=float(result["rate"])+settings.ORDER_MARGINRATE_JPY
              result["rate"]=int(new_rate*10000)/10000
              result["price"]=int(instance.amount*result["rate"]*100)
            
            if instance.from_currency=="rmb" and instance.to_currency=="jpy":
              new_rate=float(result["rate"])-settings.ORDER_MARGINRATE_RMB
              result["rate"]=int(new_rate*10000)/10000
              result["price"]=int(instance.amount/result["rate"])*100
        else:
            if instance.from_currency=="jpy" and instance.to_currency=="rmb":
              new_rate=float(result["rate"])
              result["rate"]=int(new_rate*10000)/10000
              result["price"]=int(instance.amount*result["rate"]*100)
            
            if instance.from_currency=="rmb" and instance.to_currency=="jpy":
              new_rate=float(result["rate"])
              result["rate"]=int(new_rate*10000)/10000
              result["price"]=int(instance.amount/result["rate"])*100
              
        return result
