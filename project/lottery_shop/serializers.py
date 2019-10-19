from rest_framework import serializers
from .models import Catalogue,Subcatalogue,Product

# class SubcatalogueUrlField(serializers.RelatedField):
#     def to_representation(self,value):
#         return "subcatalogue/%s"%(value.slug)


        
class SubproductSerializer(serializers.ModelSerializer):

    class Meta:
        model = Product
        fields = ("id","name","avatar","slug","price","active")

        
class ProductSerializer(serializers.ModelSerializer):
    owner=serializers.ReadOnlyField(source="owner.username")
    # subproducts=SubproductSerializer(many=True,read_only=True)

    def to_representation(self,instance):
        result=super().to_representation(instance)

        subproducts=Product.objects.filter(active=True,main_product_id=instance.id)
        serializer=SubproductSerializer(subproducts,many=True)
        result["subproducts"]=serializer.data

        return result

    class Meta:
        model = Product
        fields = ("id","name","avatar","slug","price","stock","active","owner","catalogue")

        
class ProductSerializer_list(serializers.ModelSerializer):
    owner=serializers.ReadOnlyField(source="owner.username")
    # subproducts=serializers.PrimaryKeyRelatedField(many=True, read_only=True)

    def to_representation(self,instance):
        result=super().to_representation(instance)

        subproducts=Product.objects.filter(active=True,main_product_id=instance.id)
        result["subproducts"]=len(subproducts)

        return result

    class Meta:
        model = Product
        fields = ("id","name","avatar","slug","price","owner","catalogue")


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

