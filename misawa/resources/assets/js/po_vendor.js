
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const app= new Vue({
    el: '#po',
    data:{
        po_id:0,
        po:{
            cart_O_Price:0,
            cart_R_Price:0,
            cart_Qty:0,
            paid_vendor:false,
            paid_customer:false,
            status:"new"
        },
        items:[],
        user:{
            name:""
        },
        customer:{
            name:"",
            postcode:"",
            address1:"",
            address2:""
        }
    },
    methods: {
        loadProduct(PO_id){
            // console.log("hello");
            var vm = this;
            axios.post("/vendor/pos/getLoadPOByID", {
                poid: PO_id
            }).then(response=> {
                vm.items=response.data.cart.items;
                vm.customer=response.data.customer;
                vm.po=response.data.po;
                vm.po_id=response.data.po.id;
                vm.user=response.data.user;
                console.log(vm.items);
            });
        },
        getimgURL: function (img) {
            return ""+img;
        }
    },
    filters:{
        currencyFormatter:function (value) {
            var res;
            var prev = value.toString().split('.')[0];
            res = (prev || 0).toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,');
            return res+"円";

            // 带小数点的处理

            // if (value.toString().indexOf('.') === -1) {
            //     res = (value || 0).toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,') + '.00'
            // } else {
            //     var prev = value.toString().split('.')[0];
            //     var next = value.toString().split('.')[1] < 10 ? value.toString().split('.')[1] + '0' : value.toString().split('.')[1];
            //     res = (prev || 0).toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,') + '.' + next;
            // }

        }
    }
});

$(".koun_po").on("click",function(){
    var PO_id=$(this).attr("PO_id");

    console.log("PO_id: "+PO_id);
    app.loadProduct(PO_id);
    app.productID=PO_id;

});
