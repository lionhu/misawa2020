let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/bootstrap.js', 'public/js')
    .js('resources/assets/js/shop.js', 'public/js')
    .js('resources/assets/js/product.js', 'public/js')
    .js('resources/assets/js/productComments.js', 'public/js')
    .js('resources/assets/js/admin_vue.js', 'public/js')
    .js('resources/assets/js/admin_products.js', 'public/js')
    .js('resources/assets/js/admin_customers.js', 'public/js')
    .js('resources/assets/js/vendor_products.js', 'public/js')
    .js('resources/assets/js/admin_new_product.js', 'public/js')
    .js('resources/assets/js/po.js', 'public/js')
    .js('resources/assets/js/po_vendor.js', 'public/js')
    .js('resources/assets/js/cart.js', 'public/js')
    .js('resources/assets/js/checkout.js', 'public/js')
    .js('resources/assets/js/vendor.js', 'public/js')
    .js('resources/assets/js/CustomerAdmin.js', 'public/js')
    .js('resources/assets/js/misawashop.js', 'public/js')
    .js('resources/assets/js/admin.js', 'public/js');

mix.sass('resources/assets/sass/app.scss', 'public/css');
