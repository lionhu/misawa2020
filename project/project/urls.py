from django.contrib import admin
from django.urls import path,include
from django.conf.urls.static import static
from django.conf import settings
from django.views.generic import TemplateView

from rest_framework_jwt.views import obtain_jwt_token,refresh_jwt_token,verify_jwt_token
from rest_framework import routers
from useraccount.viewsets import UserProfileViewSet
from useraccount.views import users as apiUsers,show_signup,user_active
from mail_exchange.viewsets  import OrderViewSet as AuctionOrderViewSet,OfferViewSet as AuctionOfferViewSet,TransactionViewSet
from exrate.viewsets import BonusViewSet,BonusDetailViewSet,BankRateViewSet
from lottery_shop.viewsets import CatalogueViewSet,SubcatalogueViewSet,ProductViewSet
from shoppingcart.viewsets import AddressViewSet,CartViewSet,CartItemViewSet,OrderViewSet
from ds_exchange.viewsets import DSOrderViewSet
from rest_framework_swagger.views import get_swagger_view
schema_view = get_swagger_view(title='Pastebin API')



router = routers.DefaultRouter()
router.register('userprofiles', UserProfileViewSet)
router.register('ds_order', DSOrderViewSet)
router.register('auction_order', AuctionOrderViewSet)
router.register('autcion_offer', AuctionOfferViewSet)
router.register('autcion_transaction', TransactionViewSet)
router.register('bonus', BonusViewSet)
router.register('bonus_details', BonusDetailViewSet)
router.register('bankrate', BankRateViewSet)
router.register('catalogue', CatalogueViewSet)
router.register('subcatalogue', SubcatalogueViewSet)
router.register('product', ProductViewSet)
router.register('address', AddressViewSet)
router.register('cart', CartViewSet)
router.register('cartitem', CartItemViewSet)
router.register('shop_order', OrderViewSet)



urlpatterns = [
    path('admin/', admin.site.urls),
    path('auth/', include('djoser.urls')),
    path('auth/', include('djoser.urls.authtoken')),
    path('auth/', include('djoser.urls.jwt')),

    path('api/', include(router.urls)),
    path('api-auth/', include('rest_framework.urls')),
    path('api-token-auth/', obtain_jwt_token),
    path('api-token-refresh/', refresh_jwt_token),
    path('api-token-verify/', verify_jwt_token),

    path('admin/statuscheck/', include('celerybeat_status.urls')),


    path('accounts/', include('useraccount.urls')),
    path('accounts/', include('allauth.urls')),
    path('users/', apiUsers),
    path('openAPIS/', schema_view),

    path('', TemplateView.as_view(template_name="coming_soon.html")),
    path('member/', TemplateView.as_view(template_name="vue_single.html")),
    path('exrate/', TemplateView.as_view(template_name="vue.html")),
    path('backyard/', TemplateView.as_view(template_name="vue_admin.html")),
    path('shoptop/', TemplateView.as_view(template_name="shop_top.html")),
    path('shop/', TemplateView.as_view(template_name="shop.html")),
    path('chat/', include('chat.urls')),

    path('login/', obtain_jwt_token),
    path('active/<str:active_code>/', user_active,name="user_active"),


]+ static(settings.STATIC_URL,document_root=settings.STATIC_ROOT)+static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)