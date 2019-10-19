
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
        customer:{
            id: "",
            name: "",
            postcode: "",
            address1: "",
            address2:"",
            email:"",
            phone:""
        }
    },
    methods: {
        loadEditUserModal: function loadEditUserModal(customerid) {
            var vm = this;
            axios.post("/admin/customer/getCustomerInfo", {
                "customerid": customerid
            }).then(function (response) {
                vm.customer = response.data.customer;
            });
            // console.log(this.rolename);
        },
        updateCustomerInfo: function updateCustomerInfo() {
            console.log("update info");
            var data = {
                id: this.customer.id,
                name: this.customer.name,
                postcode: this.customer.postcode,
                address1: this.customer.address1,
                address2: this.customer.address2,
                email: this.customer.email,
                phone: this.customer.phone
            };

            console.log(data);

            axios.post("/admin/customer/updateCustomerInfo", data).then(function (response) {
                window.location.reload()
            });
        },
        deleteCustomer:function deleteCustomer(customerid,row) {
            if(customerid > 0){
                    var data = {
                        id: customerid
                    };

                    axios.post("/admin/customer/deleteCustomer", data).then(function (response) {
                    });
                    var customer_table=document.getElementById("example");
                    var customer_row=document.getElementById("rowID_"+customerid);
                    customer_table.deleteRow(customer_row.rowIndex);

                    console.log("customer has been removed: "+customerid);

            }
        }

    }
});


$(".koun_customer").on("click", function () {
    var customerid = $(this).attr("customerid");
    console.log("customerid: " + customerid);
    app.loadEditUserModal(customerid);
});

$(".delete_customer").on("click", function () {
    var customerid = $(this).attr("customerid");
    app.deleteCustomer(customerid,this);
});
