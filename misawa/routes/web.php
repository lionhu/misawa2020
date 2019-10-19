<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Events\OrderPlacedEvent;
use App\Events\OrderPlaced2VendorEvent;
use App\Events\DeliverPackageEvent;
use App\Events\OrderCompletedEvent;

use App\Events\eventTrigger;
use App\User;
use App\Models\SubCatalogue;
use App\Utilities\Cart;
use App\Models\Product;
use App\Models\Catalogue;
use App\Models\PO;
use App\Models\Customer;
use App\Events\BrowseProductEvent;
use App\Repositories\Eloquent\PORepository;
use Carbon\Carbon;


use Jenssegers\Agent\Agent;
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')
    ->name("password.request");

Route::get('/language/{language}', [
    'uses' => 'HomeController@setLanguage',
    'as' => 'setLanguage'
]);

Route::group(['middleware' => ['auth','language']], function () {
    Route::get('/', [
        'uses' => 'ShopController@index',
        'as' => 'shop_home'
    ]);
    Route::get('/product/{id}', [
        'uses' => 'ShopController@getProduct',
        'as' => 'shop_product'
    ]);
    Route::post('/product/newcomment/{productid}', [
        'uses' => 'ProductController@newcomment',
        'as' => 'product_newcomment'
    ]);
    Route::post('/product/deletecomment/{commentid}', [
        'uses' => 'ProductController@deletecomment',
        'as' => 'product_deletecomment'
    ]);

    Route::get('/faq', [
        'uses' => 'ShopController@faq',
        'as' => 'shop_faq'
    ]);
    Route::post('/system/getManagementInfo', 'ShopController@getSystemManagementInfo');

    Route::post('/product/ShareProduct', [
        'uses' => 'ProductController@ShareProduct',
        'as' => 'product_ShareProduct'
    ]);
    
    Route::post('/product/getProductComments/{productid}', [
        'uses' => 'ProductController@getProductComments',
        'as' => 'product_getComments'
    ]);

    Route::post('/ofSubcatalogue','ProductController@getProductsOfSubcatalogue') ;
    Route::post('/contactUS','ShopController@contactUS') ;

    Route::get('/subcatalogue_products/{id}',[
        'uses' => 'ShopController@getSubcatalogueProducts',
        'as' => 'shop_catalogueproducts'
    ]) ;

    Route::get('/searchproducts',[
        'uses' => 'ProductController@getSearchProducts',
        'as' => 'product_getSearchProducts'
    ]) ;

    Route::group(['prefix' => 'cart'], function () {
        Route::get('/',[
            'uses' => 'CartController@index',
            'as' => 'cart_index'
        ]);
        Route::get('/clear',[
            'uses' => 'CartController@clearCart',
            'as' => 'cart_clearCart'
        ]);
        Route::post('/updateAllItems',[
            'uses' => 'CartController@updateAllItems',
            'as' => 'cart_updateAllItems'
        ]);
        Route::post('/updateitem',[
            'uses' => 'CartController@updateItem',
            'as' => 'cart_updateItem'
        ]);
        Route::post('/getcart',[
            'uses' => 'CartController@getCart',
            'as' => 'cart_getcart'
        ]);
        Route::get('/checkout',[
            'uses' => 'CartController@getCheckOut',
            'as' => 'cart_getcheckout'
        ]);

    });

    Route::group(['prefix' => 'shop'], function () {
        Route::get('/subcatalogue/{id}', [
            'uses' => 'ShopController@getSubcatalogueProducts',
            'as' => 'product_getSubCatalogue'
        ]);
        Route::post('/getCatalogues', [
            'uses' => 'ShopController@getCatalogues',
            'as' => 'shop_getCatalogues'
        ]);
        Route::post('/getSubcatalogues', [
            'uses' => 'ShopController@getSubcatalogues',
            'as' => 'shop_getSubcatalogues'
        ]);
        Route::post('/subcatalogue/{id}', [
            'uses' => 'ShopController@getSubcatalogueProducts',
            'as' => 'product_getSubCatalogue'
        ]);
        Route::post('/checkout','CartController@postCheckOut');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::post('/checkuserinformation', [
            'uses' => 'UserController@postCheckUserInformation',
            'as' => 'user_postCheckUserInformation'
        ]);
        Route::post('/checkcustomerinformation', [
            'uses' => 'UserController@postCheckCustomerInformation',
            'as' => 'user_postCheckCustomerInformation'
        ]);
        Route::get('/getcheckcustomerinformation', [
            'uses' => 'UserController@postCheckCustomerInformation',
            'as' => 'user_getcheckcustomerinformation'
        ]);

        Route::get("myPOs",[
            'uses' => 'POController@getMyPOs',
            'as' => 'user_getMyPOs'
        ]);
        
        
        Route::get("sendWelcomeRegister/{id}",[
            'uses' => 'UserController@SendWelcomeRegister',
            'as' => 'user_sendWelcomeRegister'
        ]);
    });

    Route::group(['prefix' => 'product'], function () {

        Route::post('/get','ShopController@getProduct');
        Route::get('/allList',[
            'uses' => 'ProductController@getAllProducts',
            'as' => 'product_getAllList'
        ]) ;
        Route::post('/postProductInfo',[
            'uses' => 'ProductController@postProductInfo',
            'as' => 'product_postProductInfo'
        ]);
        Route::get('/getProductInfo/{productid}',[
            'uses' => 'ProductController@getProductInfo',
            'as' => 'product_getPostProduct'
        ]);

        Route::post('/ofSubcatalogue','ProductController@member_getProductofSubcatalogue');

    });

    Route::group(['prefix' => 'po'], function () {

        Route::post('/all','POController@getAllMyPOS') ;

        Route::post('/deleteMyPO','POController@postDeletePO') ;

        Route::post('/getPOCart',[
            'uses' => 'POController@getPOCart',
            'as' => 'po_getcart'
        ]) ;
        Route::post('/getPOByID',[
            'uses' => 'POController@getPOByID',
            'as' => 'po_getPOByID'
        ]) ;
        Route::post('/updatePO',[
            'uses' => 'POController@updatePO',
            'as' => 'po_updatePO'
        ]) ;
        Route::post('/updatePOVendor',[
            'uses' => 'POController@updatePOVendor',
            'as' => 'po_updatePOVendor'
        ]) ;

        Route::get('/UserPOSummary',[
            'uses' => 'POController@postUserPOSummary',
            'as' => 'po_postUserPOSummary'
        ]) ;

        Route::get('/printMyPO/{poid}',[
            'uses' => 'POController@printMyPO',
            'as' => 'po_postUserprintMyPO'
        ]) ;
        Route::get('/printOpenPO/{poid}',[
            'uses' => 'POController@printOpenPO',
            'as' => 'po_postUserprintOpenPO'
        ]) ;


        Route::get('/print/{type}/{poid}',[
            'uses' => 'POController@PrintPO',
            'as' => 'po_PrintPO'
        ]) ;


    });





    Route::group(['prefix' => 'admin','middleware'=>["isSuperAdmin"]],function(){
        Route::get('/newhome',[
            'uses' => 'AdminController@newhome',
            'as' => 'admin_newhome'
        ]) ;
        Route::get('/',[
            'uses' => 'AdminController@index',
            'as' => 'admin_home'
        ]) ;
        Route::post('/sendmessage',[
            'uses' => 'AdminController@sendmessage',
            'as' => 'admin_sendmessage'
        ]) ;

        Route::group(["prefix"=>"customer"],function(){
            Route::post('/getall',[
                'uses' => 'AdminController@managerCustomers',
                'as' => 'admin_managerCustomers'
            ]) ;
            Route::post('/updateCustomerInfo',[
                'uses' => 'AdminController@updateCustomerInfo',
                'as' => 'admin_updateCustomerInfo'
            ]) ;
            Route::post('/deleteCustomer',[
                'uses' => 'AdminController@deleteCustomer',
                'as' => 'admin_deleteCustomer'
            ]) ;
            Route::post('/getCustomerInfo',[
                'uses' => 'AdminController@getCustomerinfo',
                'as' => 'admin_getCustomerinfo'
            ]) ;
        });

        Route::group(["prefix"=>"user"],function(){
            Route::get('/',[
                'uses' => 'AdminController@managerUsers',
                'as' => 'admin_managerUsers'
            ]) ;
            Route::post('/getall',[
                'uses' => 'AdminController@postGetAllUsers',
                'as' => 'admin_postGetAllUsers'
            ]) ;
            Route::post('/delete',[
                'uses' => 'AdminController@deleteUser',
                'as' => 'admin_deleteUser'
            ]) ;
            Route::post('/getinfo',[
                'uses' => 'AdminController@getinfo',
                'as' => 'admin_getinfo'
            ]) ;
            Route::post('/updateUserInfo',[
                'uses' => 'AdminController@updateUserInfo',
                'as' => 'admin_updateUserInfo'
            ]) ;
            Route::post('/updateInfo/client',[
                'uses' => 'AdminController@updateUserClient',
                'as' => 'admin_updateUserClient'
            ]);
            Route::post('/updateInfo/introcode',[
                'uses' => 'AdminController@updateUserIntrocode',
                'as' => 'admin_updateUserIntrocode'
            ]);
            Route::post('/getManagementinfo',[
                'uses' => 'AdminController@getManagementinfo',
                'as' => 'admin_managementinfo'
            ]) ;

            Route::get('/history/{userid}',[
                'uses' => 'AdminController@getUserHistory',
                'as' => 'admin_getUserHistory'
            ]) ;
        });

        Route::group(["prefix"=>"utilities"],function(){
            Route::post('/postClientSummary',[
                'uses' => 'AdminController@postClientSummary',
                'as' => 'admin_postClientSummary'
            ]) ;
            Route::get('/recentVisit',[
                'uses' => 'AdminController@getRecentVisit',
                'as' => 'admin_recentVisit'
            ]) ;

        });

        Route::group(["prefix"=>"client"],function(){
            Route::post('/list',[
                'uses' => 'AdminController@getClientList',
                'as' => 'getClientList'
            ]) ;
        });

        Route::group(["prefix"=>"pos"],function(){
            Route::post('/evaluate','CartController@SuperAdmin_evaluateCart');

            Route::get('/',[
                'uses' => 'AdminController@getMyPOs_admin',
                'as' => 'admin_getMyPOs'
            ]) ;
            Route::post('/all',[
                'uses' => 'AdminController@getAllPOs_admin',
                'as' => 'admin_getAllPOs_admin'
            ]) ;
            Route::post('/ofStatus',[
                'uses' => 'AdminController@getPOsOfStatus_admin',
                'as' => 'getPOsOfStatus_admin'
            ]) ;
            
            Route::post('/monthlySummary',[
                'uses' => 'AdminController@monthlySummary',
                'as' => 'admin_monthlySummary'
            ]) ;
            
            Route::get('/download_POList',[
                'uses' => 'AdminController@download_POList',
                'as' => 'admin_download_POList'
            ]) ;
            Route::get('/migratePOS',  [
                'uses' => 'POController@migratePOS',
                'as' => 'migratePOS'
            ]);
            Route::post("/setEMScode",[
                'uses' => 'VendorController@setEMScode',
                'as' => 'admin_setEMScode'
            ]);
            Route::post("/resentMail",[
                'uses' => 'AdminController@resentMail',
                'as' => 'admin_resentMail'
            ]);
            Route::post("/updatePaymentStatus",[
                'uses' => 'AdminController@updatePaymentStatus',
                'as' => 'admin_updatePaymentStatus'
            ]);
            Route::post("/updatePOStatus",[
                'uses' => 'AdminController@updatePOStatus',
                'as' => 'admin_updatePOStatus'
            ]);

            Route::get("/printPO/{poid}",[
                'uses' => 'AdminController@printPO',
                'as' => 'admin_printPO'
            ]);

            Route::get("/print_VendorPO/{poid}",[
                'uses' => 'VendorController@printPO',
                'as' => 'admin_print_VendorPO'
            ]);

            //            for edit po
            Route::post("/delete",[
                'uses' => 'AdminController@postDeletePO',
                'as' => 'admin_postDeletePO'
            ]);

            Route::get("/edit_updatePO",[
                'uses' => 'AdminController@getupdatePO',
                'as' => 'admin_edit_updatePO'
            ]);

            Route::post("/updatePOInfo",[
                'uses' => 'AdminController@updatePOInfo',
                'as' => 'admin_updatePOInfo'
            ]);


        });

        Route::group(["prefix"=>"products"],function(){
            Route::post('/all','ProductController@admin_getAllProducts');
            Route::post('/ofSubcatalogue','ProductController@admin_getProductofSubcatalogue');
            Route::post('/addNewProduct',[
                'uses' => 'ProductController@admin_postAddNewProduct',
                'as' => 'admin_Product_postAddNew'
            ]) ;

            Route::get('/addNewProduct',[
                'uses' => 'ProductController@admin_getAddNewProduct',
                'as' => 'admin_Product_getAddNew'
            ]) ;

            Route::post('/UpdateProductPostImage','ProductController@UpdateProductPostImage') ;
            Route::post('/UpdateProductImage','ProductController@UpdateProductImage') ;


            Route::post('/edit',[
                'uses' => 'ProductController@admin_postEditProduct',
                'as' => 'admin_Product_postEdit'
            ]) ;

            Route::get('/edit',[
                'uses' => 'ProductController@admin_getEditProduct',
                'as' => 'admin_Product_getEdit'
            ]);

            Route::post('/updateProductInfo','ProductController@admin_updateProductInfo');


            Route::get('/DL_products',[
                'uses' => 'AdminController@admin_getDownloadProducts',
                'as' => 'admin_download_products'
            ]);
        });

        Route::group(["prefix"=>"system"],function(){
            Route::post('/getManagementInfo',[
                'uses' => 'AdminController@getSystemManagementInfo',
                'as' => 'admin_getSystemManagementInfo'
            ]);
        });


    });

    Route::group(['prefix' => 'customerAdmin','middleware'=>["isCustomerAdmin"]],function(){
        Route::get('/',[
            'uses' => 'CustomerAdminController@index',
            'as' => 'customerAdmin_home'
        ]) ;
        Route::get('/team',[
            'uses' => 'CustomerAdminController@team',
            'as' => 'customerAdmin_team'
        ]) ;
//        Route::get('/teamPOs',[
//            'uses' => 'CustomerAdminController@getTeamPOs',
//            'as' => 'customerAdmin_TeamPOs'
//        ]) ;

//        Route::get('/myPO',[
//            'uses' => 'CustomerAdminController@getMyPOs_customerAdmin',
//            'as' => 'po_getMyPOs_customerAdmin'
//        ]) ;
        Route::get('/download_POList',[
            'uses' => 'CustomerAdminController@download_POList',
            'as' => 'customerAdmin_download_POList'
        ]) ;


        Route::group(["prefix"=>"system"],function(){
            Route::post('/getManagementInfo','CustomerAdminController@getManagementInfo');
        });
        Route::group(["prefix"=>"pos"],function(){
            Route::post('/team',[
                'uses' => 'CustomerAdminController@getTeamPOs',
                'as' => 'customerAdmin_TeamPOs'
            ]);
            Route::post('/mine',[
                'uses' => 'CustomerAdminController@getMyPOs_customerAdmin',
                'as' => 'customerAdmin_getMyPOS'
            ]);
            Route::post('/ofStatus',[
                'uses' => 'CustomerAdminController@getPOs_ofStatus',
                'as' => 'customerAdmin_getPOs_ofStatus'
            ]);
            Route::post('/delete',[
                'uses' => 'CustomerAdminController@getDeleteMyPO',
                'as' => 'customerAdmin_getDeleteMyPO'
            ]);

            Route::post('/monthlySummary',[
                'uses' => 'CustomerAdminController@monthlySummary',
                'as' => 'customerAdmin_getDeleteMyPO'
            ]);

            Route::get("/printPO/{poid}","CustomerAdminController@PrintPO")
                ->name("customerAdmin_printPO");
        });
        Route::group(["prefix"=>"user"],function(){
            Route::get('/',[
                'uses' => 'AdminController@managerUsers',
                'as' => 'customerAdmin_managerUsers'
            ]) ;
            Route::post('/delete',[
                'uses' => 'AdminController@deleteUser',
                'as' => 'customerAdmin_deleteUser'
            ]) ;
            Route::post('/getall',[
                'uses' => 'CustomerAdminController@getAllUsers',
                'as' => 'customerAdmin_getAllUsers'
            ]) ;
            Route::post('/updateUserInfo',[
                'uses' => 'AdminController@updateUserInfo',
                'as' => 'customerAdmin_updateUserInfo'
            ]) ;
            Route::get('/getinfo',[
                'uses' => 'AdminController@getinfo',
                'as' => 'customerAdmin_getinfo'
            ]) ;

            Route::get('/history/{userid}',[
                'uses' => 'CustomerAdminController@getUserHistory',
                'as' => 'customerAdmin_getUserHistory'
            ]) ;
        });
        Route::group(["prefix"=>"customer"],function(){
            Route::post('/getall',[
                'uses' => 'CustomerAdminController@getcustomers',
                'as' => 'customerAdmin_getAllCustomer'
            ]) ;
            Route::post('/update',[
                'uses' => 'CustomerAdminController@updateCustomerInfo',
                'as' => 'customerAdmin_updateCustomerInfo'
            ]) ;
        });
    });

    Route::group(['prefix' => 'distributor','middleware'=>["isDistributor"]],function(){
        Route::get('/',[
            'uses' => 'DistributorController@index',
            'as' => 'distributor_home'
        ]) ;
        Route::get('/myPO',[
            'uses' => 'DistributorController@getMyPOs',
            'as' => 'po_getMyPOs_distributor'
        ]) ;
    });

    Route::group(['prefix' => 'customer','middleware'=>["isCustomer"]],function(){
        Route::get('/',[
            'uses' => 'AdminController@index',
            'as' => 'admin_home'
        ]) ;
        Route::post('/sendmessage',[
            'uses' => 'AdminController@sendmessage',
            'as' => 'admin_sendmessage'
        ]) ;

        Route::group(["prefix"=>"pos"],function(){
            Route::get('/',[
                'uses' => 'POController@getMyPOs_customer',
                'as' => 'getMyPOs_customer'
            ]) ;
        });

    });

    Route::group(['prefix' => 'vendor','middleware'=>["isVendor"]],function(){
        Route::get('/',[
            'uses' => 'VendorController@index',
            'as' => 'vendor_home'
        ]) ;

        Route::group(["prefix"=>"pos"],function(){
            Route::get('/all',function(Request $request){
                return response()->redirectToRoute("vendor_home");
            });
            Route::post('/ofStatus',[
                'uses' => 'VendorController@getStatusPOs',
                'as' => 'vendor_getStatusPOs'
            ]);
            Route::post("/setEMScode",[
                'uses' => 'VendorController@setEMScode',
                'as' => 'vendor_setEMScode'
            ]);
            Route::get("/printPO/{poid}",[
                'uses' => 'VendorController@printPO',
                'as' => 'vendor_printPO'
            ]);
            Route::post("/getLoadPOByID",[
                'uses' => 'VendorController@getLoadPOByID',
                'as' => 'vendor_getLoadPOByID'
            ]);
            Route::get('/download_POList',[
                'uses' => 'VendorController@download_POList',
                'as' => 'vendor_download_POList'
            ]) ;
            Route::post('/monthlySummary',[
                'uses' => 'VendorController@postMonthlySummary',
                'as' => 'vendor_postMonthlySummary'
            ]) ;

        });
        Route::group(["prefix"=>"products"],function(){
            Route::get('/',[
                'uses' => 'VendorController@getAllVendorProducts',
                'as' => 'vendor_getAllVendorProducts'
            ]);
            Route::post('/mine',[
                'uses' => 'VendorController@getVendorProducts',
                'as' => 'vendor_getVendorProducts'
            ]);
            Route::post('/getProductByID',[
                'uses' => 'VendorController@getProductByID',
                'as' => 'vendor_getProductByID'
            ]);

        });
        
        Route::get('/download_CustomerList',[
            'uses' => 'VendorController@download_MisawaCustomer',
            'as' => 'vendor_download_CustomerList'
        ]) ;

        Route::get('/download_POCustomer/{poid}',[
            'uses' => 'VendorController@download_POCustomer',
            'as' => 'vendor_download_POCustomer'
        ]) ;

    });





});