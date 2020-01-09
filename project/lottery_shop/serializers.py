from rest_framework import serializers
from .models import Catalogue,Subcatalogue,Product,Groupon,Applicant,GalleryImage,ProductReview
from rentalhouse.models import RentalProduct,ProductRank,RentalHistory

from django.conf import settings
import datetime
import logging
logger=logging.getLogger("error_logger")

class FilteredListSerializer(serializers.ListSerializer):

    filter_kwargs = {}

    def to_representation(self, data):
        if not self.filter_kwargs or not isinstance(self.filter_kwargs, dict):
            raise TypeError(_('Invalid Attribute Type: `filter_kwargs` must be a of type `dict`.'))
        data = data.filter(**self.filter_kwargs)
        return super().to_representation(data)

class FutureRentalHistoryListSerializer(FilteredListSerializer):
     filter_kwargs = {'end_at__gte': datetime.datetime.now(),"status__in":settings.IN_RENTAL_MODE}


class ProductRankSerializer(serializers.ModelSerializer):
    class Meta:
        model = ProductRank
        fields = ("__all__")


class ProductReviewSerializer(serializers.ModelSerializer):
    class Meta:
        model = ProductReview
        fields = ("__all__")


class RentalHistorySerializer(serializers.ModelSerializer):
    user_email = serializers.ReadOnlyField(source="user.email")
    class Meta:
        model = RentalHistory
        fields = ("start_at","end_at","status","days","user_email")
        list_serializer_class = FutureRentalHistoryListSerializer

class RentalProductSerializer(serializers.ModelSerializer):
    histories = RentalHistorySerializer(many=True,read_only=True)
    rank = ProductRankSerializer(many=False,read_only=True)
    class Meta:
        model = RentalProduct
        fields = ['id','slug',"sn","condition","avaliable","rank","histories"]



class GalleryImageSerializer(serializers.ModelSerializer):
    class Meta:
        model = GalleryImage
        fields = ("slug","mediatype","thumbimage","postimage","memo","title","description")

    def to_representation(self,instance):
        result=super().to_representation(instance)
        result["href"]=instance.postimage_url()
        return result

class SubproductSerializer(serializers.ModelSerializer):

    class Meta:
        model = Product
        fields = ("id","name","avatar","slug","price","active")


class ProductSerializer(serializers.ModelSerializer):
    vendor=serializers.ReadOnlyField(source="vendor.username")
    medias = GalleryImageSerializer(many=True,read_only=True)
    rentalproducts = RentalProductSerializer(many=True,read_only=True)
    reviews = ProductReviewSerializer(many=True,read_only=True)

    class Meta:
        model = Product
        fields = ("id","name","avatar","slug","open_price","price","specs","manufacturer","description","stock","sku","ranks", \
                  "active","vendor","catalogue","medias","rentalproducts","reviews")


class CartItemProductSerializer(serializers.ModelSerializer):
    vendor=serializers.ReadOnlyField(source="vendor.username")

    class Meta:
        model = Product
        fields = ("id","name","avatar","slug","price","stock","active","vendor","catalogue")

class ProductSerializer_list(serializers.ModelSerializer):
    vendor=serializers.ReadOnlyField(source="vendor.username")
    # medias = GalleryImageSerializer(many=True,read_only=True)

    def to_representation(self,instance):
        result=super().to_representation(instance)

        subproducts=Product.objects.filter(active=True,main_product_id=instance.id)
        result["subproducts"]=len(subproducts)
        # result["galleryimages"]=instance.medias

        try:
            logger.error(instance.groupon)
            result["hasGroupon"]=True
            result["groupon_applicants_count"]=instance.groupon.applicants_count()
            result["groupon_target"]=instance.groupon.target
            result["grouponSlug"]=instance.groupon.slug
            result["grouponActive"]= True if instance.groupon.status=="active" else False
        except:
            result["hasGroupon"]=False

        return result

    class Meta:
        model = Product
        # fields = ("id","name","avatar","thumbimage","slug","price","open_price","ranks","stock","vendor","catalogue","manufacturer","brand","medias")
        fields = ("id","name","avatar","thumbimage","slug","price","open_price","ranks","stock","vendor","catalogue","manufacturer","brand")


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
        products=Product.objects.filter(active=True,catalogue=instance)

        result["url"]="subcatalogue/%s"%(instance.slug)
        result["product_num"]=products.count()


        return result

class CatalogueSerializer(serializers.ModelSerializer):
    subcatalogues=SubcatalogueSerializer_list(many=True,read_only=True)
    class Meta:
        model = Catalogue
        fields = ("id","name","avatar","slug","subcatalogues")


class GrouponSerializer(serializers.ModelSerializer):
    # product = ProductSerializer(many=False, read_only=True)
    product=serializers.ReadOnlyField(source="product.slug")

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
    # groupon = GrouponSerializer(many=False, read_only=True)
    # user = UserSerializer(many=False, read_only=True)
    groupon = serializers.ReadOnlyField(source="groupon_slug")
    user = serializers.ReadOnlyField(source="user.slug")

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
            # "deposite_paycode",
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
