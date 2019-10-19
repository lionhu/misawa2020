
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//
// Vue.component('postproduct', require('./components/PostProduct.vue'));

import Swal from 'sweetalert2'

const app= new Vue({
    el: '#shop',
    data:{
        productID:0,
        productname:"",
        productcode:"",
        o_price:0,
        qty:0,
        cart_qty:0,
        catalogue:"",
        subcatalogue:"",
        postimage:"",
        thumbimage:"",
        efficacy:""

    },
    filters:{
        currencyFormat: function (num) {
            var result = [ ], counter = 0;
            num = (num || 0).toString().split('');
            for (var i = num.length - 1; i >= 0; i--) {
                counter++;
                result.unshift(num[i]);
                if (!(counter % 3) && i != 0) { result.unshift(','); }
            }
            return result.join('')+"元";
        }
    },
    mounted(){
        var vm=this;
        axios.post("/cart/getcart").then(response => {
            $(".cart_total").html(response.data.Total_Qty);
    });
    },
    methods:{
        showMessage(title,message){
            Swal.fire({
                title: title,
                text: message,
                type: "info"
            });
        },
        removeItem(){
            if (this.qty > 0) {
                this.qty -= 1;
            }
            console.log("qty: " + this.qty);
        },
        addItem(){
            this.qty += 1;
            console.log("qty: " + this.qty);
        },
        loadProduct(productID){
            var url="/product/postProductInfo";
            var vm=this;
            // console.log("ready to load?");
            axios.post(url,{
                productid:productID
            }).then(response=>{
                vm.productname=response.data.productname;
                vm.productcode=response.data.productcode;
                vm.catalogue=response.data.catalogue;
                vm.subcatalogue=response.data.subcatalogue;
                vm.o_price=response.data.o_price;
                vm.efficacy=response.data.efficacy;
                vm.postimage=response.data.postimage;
                vm.thumbimage=response.data.thumbimage;
                vm.qty=response.data.qty;
                vm.cart_total=response.data.cart_total;
                $("#efficacy").html(response.data.efficacy);
                // console.log(response.data);
                // console.log(response.data.images);

            });

        },

        getimageurl(val){
            return ""+val;
        }
    },
    computed:{
    },
    created(){
        // console.log("before echo");
        // Echo.channel('private-channel-admin')
        //     .listen("BrowseProductEvent",(e)=>{
        //         var mssage="Someone is browsing product:"+e.product.name;
        //         $('#adminMessage').attr("data-notify-msg",mssage)
        //         .attr("data-notify-type","warning")
        //         .attr("data-notify-position","bottom-full-width");
        //         SEMICOLON.widget.notifications($('#adminMessage'));
        //     })
        //     .listen("SuperAdminMessageEvent",(e)=>{
        //         var mssage="Message from superadmin:  "+e.message;
        //         $('#adminMessage').attr("data-notify-msg",mssage)
        //             .attr("data-notify-type","warning")
        //             .attr("data-notify-position","bottom-full-width");
        //         SEMICOLON.widget.notifications($('#adminMessage'));
        //
        //     });
        }
});

$(".koun_product").on("click",function(){
    var product_id=$(this).attr("product_ID");

    // console.log("product id: "+product_id);
    app.loadProduct(product_id);
    // app.qty=0;
    app.productID=product_id;
    $("#cart_qty").innerHTML=app.cart_qty;
    // console.log("productname: "+app.catalogue);



});

$('#add2cart').on('click', function (e) {
    var url="/cart/updateitem";

    var data={
        id:app.productID,
        qty:app.qty
    };
    console.log(data);
    axios.post(url, data).then(function (response) {
        // console.log(response.data);
        $(".cart_total").html(response.data.cart_Total_Qty);

        $('#addcartmessage').attr("data-notify-msg","<a href='/cart'><i class=icon-info-sign></i> 成功添加到购物车！<i class='icon-shopping-cart'></i></a>")
            .attr("data-notify-type","success")
            .attr("data-notify-position","bottom-full-width");
        SEMICOLON.widget.notifications($('#addcartmessage'));

    }).catch(function (error) {
        console.log(error);
    });

});
$('.add2cart_one').on('click', function (e) {
    var product_id=this.getAttribute("product_ID");
    console.log("Add by One");
    // return false;
    var url="/cart/updateitem";
    //
    var data={
        id:product_id,
        qty:1,
        operation:"addone"
    };
    // console.log(data);
    axios.post(url, data).then(function (response) {
        // console.log(response.data);
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            type: 'success',
            title: "成功添加到购物车！"
        });

        $(".cart_total").html(response.data.cart_Total_Qty);
        $('#addcartmessage').attr("data-notify-msg","<a href='/cart'><i class=icon-info-sign></i> 成功添加到购物车！<i class='icon-shopping-cart'></i></a>")
            .attr("data-notify-type","success")
            .attr("data-notify-position","bottom-full-width");
        SEMICOLON.widget.notifications($('#addcartmessage'));
    }).catch(function (error) {
        console.log(error);
    });

});

// for product single page
$('#product_add2cart').on('click', function (e) {
    var url="/cart/updateitem";

    var product_id=this.getAttribute("product_ID");

    var data={
        id:product_id,
        qty:app.qty
    };
    console.log(data);
    axios.post(url, data).then(function (response) {
        // console.log(response.data);
        $(".cart_total").html(response.data.cart_Total_Qty);

        $('#addcartmessage').attr("data-notify-msg","<a href='/cart'><i class=icon-info-sign></i> Thank you! See my shopping cart.<i class='icon-shopping-cart'></i></a>")
            .attr("data-notify-type","success")
            .attr("data-notify-position","bottom-full-width");
        SEMICOLON.widget.notifications($('#addcartmessage'));

    }).catch(function (error) {
        console.log(error);
    });

});