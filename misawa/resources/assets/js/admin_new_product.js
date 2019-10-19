
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const app= new Vue({
    el: '#product',
    data:{
        toAllMessage:"",
        product:{
            name:"",
            name_jp:"",
            product_code:"",
            catalogue:"",
            subcatalogue:"",
            o_price:0,
            b_price:0,
            r_price:0,
            vendor_id:0,
            manufactory:"",
            efficacy:"<b>hello</b> this the test",
            description:"",
            unit:"",
            tables:"",
            active:true,
            rate:0

        },
        catalogues:[],
        subcatalogues:[]
    },
    methods: {
        postSubmitNewProductInfo(){

            // 上传信息的时候，要把使用wysiwyg5的textare的取值更新到product 的属性去。
            // 这里不能顺利同步的
            // $('#Efficacy').val();
            // console.log($('#Efficacy').val());
            // $("#textEfficacy").html($('#Efficacy').val());

            console.log(this.product.efficacy);

        },
        test(){

            $('#Efficacy').val();
            console.log($('#Efficacy').val());
            $("#textEfficacy").html($('#Efficacy').val());
        },
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

            });
        },
        deletePO(){
            console.log("delete");
            console.log(this.po);
            axios.post("/po/deletePO", {
                poid: this.po_id
            }).then(response=> {
                window.location.reload(true);
            });
        },
        getimgURL: function (img) {
            return ""+img;
        },
        loadSubcatalogues(){
            var cataclogueid=this.product.catalogue;
            var vm = this;
            axios.post("/shop/getSubcatalogues",{
                catalogueid:cataclogueid
                }).then(response=> {
                    vm.subcatalogues=response.data.subcatalogues;
            });
        }
    },
    mounted(){
        var vm = this;
        axios.post("/shop/getCatalogues")
            .then(response=> {
                vm.catalogues=response.data.catalogues;
        });
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
