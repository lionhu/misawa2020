
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
        toAllMessage:""
        // po_id:0,
        // po:{
        //     cart_O_Price:0,
        //     cart_Qty:0,
        //     paid_vendor:false,
        //     paid_customer:false,
        //     status:"new"
        // },
        // items:[],
        // user:{
        //     name:""
        // },
        // customer:{
        //     name:"",
        //     postcode:"",
        //     address1:"",
        //     address2:""
        // }
    },
    methods: {
        sendmessage(){
            axios.post("/admin/sendmessage", {
                "message": this.toAllMessage
            }).then(response=> {
                // window.location.reload(true);
                // var removePO="#rowID_"+this.po.id;
                // $(removePO).remove();
            });
        },
        loadProduct(PO_id){
            console.log("hello");
            var vm = this;
            axios.post("/po/getPOByID", {
                poid: PO_id
            }).then(response=> {
                vm.items=response.data.cart.items;
                vm.customer=response.data.customer;
                vm.po=response.data.po;
                vm.po_id=response.data.po.id;
                vm.user=response.data.user;
                console.log(vm.po.paid_vendor);
                console.log(response.data);
            });
        },
        updatePO(){
            console.log("update");
            console.log(this.po);
            axios.post("/po/updatePO", {
                poid: this.po_id,
                paid_vendor:this.po.paid_vendor,
                paid_customer:this.po.paid_customer,
                status:this.po.status
            }).then(response=> {
                window.location.reload(true);
                // var itemPO="#rowID_"+this.po.id;
                // $(itemPO).find(".status").html(this.po.status);
                //
                // if(this.po.paid_customer==1){
                //     $(itemPO).find(".paid_customer").html("<i class='fa fa-check-circle-o' style='color: green;'></i>");
                // }else{
                //     $(itemPO).find(".paid_customer").html("<i class='fa fa-times-circle-o' style='color: red;'></i>");
                // }
                //
                // if(this.po.paid_vendor==1){
                //     $(itemPO).find(".paid_vendor").html("<i class='fa fa-check-circle-o' style='color: green;'></i>");
                // }else{
                //     $(itemPO).find(".paid_vendor").html("<i class='fa fa-times-circle-o' style='color: red;'></i>");
                // }

            });
            // $('#pagemessage').attr("data-notify-msg","<i class=icon-info-sign></i> PO has been updated!")
            //     .attr("data-notify-type","warning")
            //     .attr("data-notify-position","bottom-full-width");
            // SEMICOLON.widget.notifications($('#pagemessage'));

        },
        deletePO(){
            console.log("delete");
            console.log(this.po);
            axios.post("/po/deletePO", {
                poid: this.po_id
            }).then(response=> {
                window.location.reload(true);
                // var removePO="#rowID_"+this.po.id;
                // $(removePO).remove();
            });

            // $('#pagemessage').attr("data-notify-msg","<i class=icon-info-sign></i> PO has been deleted!")
            //     .attr("data-notify-type","danger")
            //     .attr("data-notify-position","bottom-full-width");
            // SEMICOLON.widget.notifications($('#pagemessage'));
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
            return res;

            // 带小数点的处理

            // if (value.toString().indexOf('.') === -1) {
            //     res = (value || 0).toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,') + '.00'
            // } else {
            //     var prev = value.toString().split('.')[0];
            //     var next = value.toString().split('.')[1] < 10 ? value.toString().split('.')[1] + '0' : value.toString().split('.')[1];
            //     res = (prev || 0).toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,') + '.' + next;
            // }

        }
    },
    created(){
        console.log("before echo");
        Echo.channel('private-channel-admin')
            .listen("BrowseProductEvent",(e)=>{
            var mssage="Someone is browsing product:"+e.product.name;
        $('#adminMessage').attr("data-notify-msg",mssage)
            .attr("data-notify-type","warning")
            .attr("data-notify-position","bottom-full-width");
        SEMICOLON.widget.notifications($('#adminMessage'));
        })
        .listen("SuperAdminMessageEvent",(e)=>{
                var mssage="Message from superadmin:  "+e.message;
            $('#adminMessage').attr("data-notify-msg",mssage)
                .attr("data-notify-type","warning")
                .attr("data-notify-position","bottom-full-width");
            SEMICOLON.widget.notifications($('#adminMessage'));

        });
    }
});

$(".koun_po").on("click",function(){
    var PO_id=$(this).attr("PO_id");

    console.log("product id: "+PO_id);
    app.loadProduct(PO_id);
    // app.qty=0;
    app.productID=PO_id;
    // $("#cart_qty").innerHTML=app.cart_qty;

    // return true;

});
