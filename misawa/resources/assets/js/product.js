

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('modal_product', require('./components/Modal_Product.vue'));
// Vue.component('product', require('./components/PostProduct.vue'));

var app=new Vue({
    el: '#app_product',
    data: {
        productID:"",
        qty:0,
        catalogue:"",
        product:"",
        images:""
    },
    computed:{
        totalprice(){
            return this.product.price*this.count;
        }
    },
    methods:{
        removeProduct(){
            console.log("qty: "+this.qty);
            if(this.qty>0){
                this.qty -=1;
            }
        },
        loadProduct(productID){
            var url="/shop/get_post_product/"+productID;
            axios.get(url).then(response=>{
                this.product=response.data.product;
                this.images=response.data.images;
            });
        },
        add2cart(){
            $("#exampleModalLong").modal('toggle');
        }
    }
});

$(".koun_product").on("click",function(){
    console.log("onclick");

    var product_id=$(this).attr("product_ID");

    console.log("product id: "+product_id);
    app.loadProduct(product_id);
    app.qty=0;
    app.productID=product_id;

});

$('#exampleModalLong').on('hidden.bs.modal', function (e) {
    console.log("before closing");
    var url="/cart/updateitem";

    axios.post(url, {
                id:app.productID,
                qty:app.qty,
                operation:"add"
        }).then(function (response) {
            console.log(response.data);
        }).catch(function (error) {
            console.log(error);
        });

});
