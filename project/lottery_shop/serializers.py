from rest_framework import serializers
from .models import Catalogue,Subcatalogue,Product,Groupon,Applicant,ProductImage
from useraccount.serializers import UserSerializer

# class SubcatalogueUrlField(serializers.RelatedField):
#     def to_representation(self,value):
#         return "subcatalogue/%s"%(value.slug)


        
class SubproductSerializer(serializers.ModelSerializer):

    class Meta:
        model = Product
        fields = ("id","name","avatar","slug","price","active")

        
class ProductImageSerializer(serializers.ModelSerializer):
    class Meta:
        model = ProductImage
        fields = ("thumbimage","avatar",)

class ProductSerializer(serializers.ModelSerializer):
    owner=serializers.ReadOnlyField(source="owner.username")
    images = ProductImageSerializer(many=True,read_only=True)
    # subproducts=SubproductSerializer(many=True,read_only=True)

    def to_representation(self,instance):
        result=super().to_representation(instance)

        subproducts=Product.objects.filter(active=True,main_product_id=instance.id)
        serializer=SubproductSerializer(subproducts,many=True)
        result["subproducts"]=serializer.data

        return result

    class Meta:
        model = Product
        fields = ("id","name","avatar","images","slug","price","stock","active","owner","catalogue")

        
class ProductSerializer_list(serializers.ModelSerializer):
    owner=serializers.ReadOnlyField(source="owner.username")
    images = ProductImageSerializer(many=True,read_only=True)

    def to_representation(self,instance):
        result=super().to_representation(instance)

        subproducts=Product.objects.filter(active=True,main_product_id=instance.id)
        result["subproducts"]=len(subproducts)

        return result

    class Meta:
        model = Product
        # exclude = ['purchase_price']

        fields = ("id","name","avatar","images","thumbimage","slug","price","open_price","ranks","owner","catalogue")


class SubcatalogueSerializer(serializers.ModelSerializer):
    products=ProductSerializer_list(many=True,read_only=True)

    class Meta:
        model = Subcatalogue
        fields = ("id","name","avatar","slug","products")



class SubcatalogueSerializer_list(serializers.ModelSerializer):
    class Meta:
        model = Subcatalogue
        fields = ("id","name","avatar","slug")

    def to_representation(self,instance):
        result=super().to_representation(instance)

        result["url"]="subcatalogue/%s"%(instance.slug)

        return result


class CatalogueSerializer(serializers.ModelSerializer):
    subcatalogues=SubcatalogueSerializer_list(many=True,read_only=True)
    class Meta:
        model = Catalogue
        fields = ("id","name","avatar","slug","subcatalogues")


class GrouponSerializer(serializers.ModelSerializer):
    product = ProductSerializer(many=False, read_only=True)

    class Meta:
        model = Groupon
        fields = (
            "slug",
            "product",
            "name",
            "description",
            "status",
            "target",
            "price",
            "feedbackprice",
            "price_overflow",
            "feedbackprice_overflow",
            "applicants_count",
            "target_overflow",
            "created",
        )
        read_only_fields = (
            "slug",
            "created",
            "applicants_count",
            "target_overflow",
        )


class ApplicantSerializer(serializers.ModelSerializer):
    groupon = GrouponSerializer(many=False, read_only=True)
    user = UserSerializer(many=False, read_only=True)

    class Meta:
        model = Applicant
        fields = (
            "slug",
            "address",
            "num",
            "price",
            "feedbackprice",
            "groupon",
            "user",
            "deposite_paycode",
            "deposite_paid",
            "deposite_paid_at",
            "orderpaid",
            "orderpaid_at",
            "delivery_status",
            "delivery_no",
            "created",
        )
        read_only_fields = (
            "slug",
            "groupon",
            "user",
            "deposite_paid_at",
            "created",
        )
