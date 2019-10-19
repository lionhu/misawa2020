
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const app= new Vue({
    el: '#shop',
    data:{
        toAllMessage:"",
        product:{
        },
        catalogue:{},
        subcatalogue:{}
    },
    methods: {
        loadProduct(productid){
            var vm = this;
            axios.post("/vendor/products/getProductByID", {
                productid: productid
            }).then(response=> {
                vm.product=response.data.product;
                vm.catalogue=response.data.product.catalogue;
                vm.subcatalogue=response.data.product.subcatalogue;
                vm.product.r_price=this.currencyFormatter(response.data.product.r_price);

            });
        },
        getimgURL: function (img) {
            return "/"+img;
        },
        currencyFormatter:function (value) {
            var res;
            var prev = value.toString().split('.')[0];
            res = (prev || 0).toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,');
            return res;
        }
    }
});

$(".koun_product").on("click",function(){
    var productid=$(this).attr("productid");
    app.loadProduct(productid);

});
