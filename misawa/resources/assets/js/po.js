/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#po',
    data: {
        po_id: 0,
        po: {
            cart_O_Price: 0,
            cart_Qty: 0,
            paid_vendor: false,
            paid_customer: false,
            paid_margin: false,
            status: "new"
        },
        items: [],
        user: {
            name: ""
        },
        customer: {
            name: "",
            postcode: "",
            address1: "",
            address2: ""
        }
    },
    methods: {
        loadPO(PO_id){
            // console.log("hello");
            var vm = this;
            axios.post("/po/getPOByID", {
                poid: PO_id
            }).then(response => {
                vm.items = response.data.cart.items;
                vm.customer = response.data.customer;
                vm.po = response.data.po;
                vm.po_id = response.data.po.id;
                vm.user = response.data.user;
                if (response.data.po.paid_customer == 1)
                {
                    vm.po.paid_customer = true;
                } else {
                    vm.po.paid_customer = false;
                }

                if (response.data.po.paid_margin == 1) {
                    vm.po.paid_margin = true;
                } else {
                    vm.po.paid_margin = false;
                }
                if (response.data.po.paid_vendor == 1) {
                    vm.po.paid_vendor = true;
                } else {
                    vm.po.paid_vendor = false;
                }

                if (response.data.po.status !== "new") {
                    $(".po_deleteBtn").css("display", "none");
                } else {

                    $(".po_deleteBtn").css("display", "inline-block");
                }

        });
        },
        updatePO(){
            console.log("update");
            // console.log(this.po);
            axios.post("/po/updatePO", {
                poid: this.po_id,
                paid_vendor: this.po.paid_vendor,
                paid_customer: this.po.paid_customer,
                paid_margin: this.po.paid_margin,
                status: this.po.status
            }).then(response => {
                // window.location.reload(true);
                var itemPO = "#rowID_" + this.po.id;
            $(itemPO).find(".status").html(this.po.status);

            });

        },

        updatePOVendor(){
            axios.post("/po/updatePOVendor", {
                poid: this.po_id,
                vendor_id:this.po.vendor_id
            }).then(response => {
                // window.location.reload(true);
                var itemPO = "#rowID_" + this.po.id;
                $(itemPO).find(".vendor").html(response.data.vendorname);

        });

        },
        deletePO(){
            console.log("delete");
            console.log(this.po);
            axios.post("/po/deletePO", {
                poid: this.po_id
            }).then(response => {
                $("#returnMessage").text("PO has been deleted!");
                window.location.reload();
        });
        },
        getimgURL: function (img) {
            return "/" + img;
        },
        resentPOMail(){
            var mailType=$("#resentMailType").val();
            var poid=parseInt($("#poid").text());

            var resentMailReceiver=$("#resentMailReceiver").val();

            if (mailType !="" && resentMailReceiver !=""){

                axios.post("/admin/pos/resentMail", {
                    poid: poid,
                    receiver:resentMailReceiver,
                    messageType:mailType
                }).then(response => {
                    console.log(response.data);
                $("#returnMessage").text(response.data.poid+" message sent!");
                });
            }

            return false;
        },
        updatePOPayment(){
            var poid=parseInt($("#poid").text());


                axios.post("/admin/pos/updatePaymentStatus", {
                    poid: poid,
                    vendorpay: this.po.paid_vendor,
                    customerpay: this.po.paid_customer,
                    marginpay: this.po.paid_margin
                }).then(response => {
                    console.log(response.data);
                    $("#returnMessage").text(response.data.poid+" payment changed!");
                });

            var itemPO = "#rowID_" + this.po.id;
            if (this.po.paid_customer == 1) {
                $(itemPO).find(".paid_customer").html("<i class='fa fa-check-circle-o' style='color: green;'></i>");
            } else {
                $(itemPO).find(".paid_customer").html("<i class='fa fa-times-circle-o' style='color: red;'></i>");
            }

            if (this.po.paid_vendor == 1) {
                $(itemPO).find(".paid_vendor").html("<i class='fa fa-check-circle-o' style='color: green;'></i>");
            } else {
                $(itemPO).find(".paid_vendor").html("<i class='fa fa-times-circle-o' style='color: red;'></i>");
            }


            if (this.po.paid_margin == 1) {
                $(itemPO).find(".paid_margin").html("<i class='fa fa-check-circle-o' style='color: green;'></i>");
            } else {
                $(itemPO).find(".paid_margin").html("<i class='fa fa-times-circle-o' style='color: red;'></i>");
            }

            return false;
        },
        updatePOStatus(){
            console.log("update");
            // console.log(this.po);
            axios.post("/admin/pos/updatePOStatus", {
                poid: this.po_id,
                status: this.po.status
            }).then(response => {
                // window.location.reload(true);
                var itemPO = "#rowID_" + this.po.id;
                $(itemPO).find(".status").html(this.po.status);
                $("#returnMessage").text(response.data.poid+" status changed!");
            });
        }
    },
    filters: {
        currencyFormatter: function (value) {
            var res;
            var prev = value.toString().split('.')[0];
            res = (prev || 0).toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,');
            return res + "元";

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

$(".koun_po").on("click", function () {
    var PO_id = $(this).attr("PO_id");

    console.log("PO_id: " + PO_id);
    app.loadPO(PO_id);
    app.productID = PO_id;

});

// $("#resentMailButton").on("click",function () {
    // var mailType=$("#resentMailType").val();
    // var poid=parseInt($("#poid").text());
    //
    // var resentMailReceiver=$("#resentMailReceiver").val();
    //
    // if (mailType !="" && resentMailReceiver !=""){
    //
    //     axios.post("/admin/pos/resentMail", {
    //         poid: poid,
    //         receiver:resentMailReceiver,
    //         messageType:mailType
    //     }).then(response => {
    //        console.log(response.data);
    //         $("#returnMessage").text(response.data.poid);
    // });
    // }
    //
    // return false;
// });