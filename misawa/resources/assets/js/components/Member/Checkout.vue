<template>
    <div class=" nobottommargin">
        <!-- Page Title
        ============================================= -->
        <section id="page-title" v-if="Qty == 0 " class="page-title-parallax page-title-dark"
                 style="background-image: url('/images/parallax/4.jpg'); background-size: cover; padding: 120px 0;"
                 data-bottom-top="background-position:0px 0px;" data-top-bottom="background-position:0px -300px;">

            <div class="container-fluid clearfix">
                <h1 v-if="!checkouted">亲，您的购物车是空滴！</h1>
                <h1 v-if="checkouted" class="color">感谢您的光临！我们为您的健康保驾护航！</h1>

                <router-link to="/" class="button button-3d notopmargin pull-right">继续选购</router-link>

            </div>


        </section><!-- #page-title end -->

        <section id="page-title"  v-if="Qty>0 && !checkouted">

            <div class="container clearfix">
                <h1>购物车</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </div>

        </section>
        <section id="content" style="margin-top: 30px;"  v-if="Qty>0 && !checkouted">

                <div class="col_half ">

                    <h4>亲选购的产品</h4>

                    <div class="table-responsive">
                        <table class="table cart hidden-xs">
                            <thead>
                            <tr>
                                <th class="cart-product-thumbnail">&nbsp;</th>
                                <th class="cart-product-name">产品</th>
                                <th class="cart-product-quantity">数量</th>
                                <th class="cart-product-subtotal">小计</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="cart_item" v-for="item in cartitems">
                                <td class="cart-product-thumbnail">
                                    <a href="javascript:void(0);"><img width="64" height="64" :src="'/'+item.product.thumbImage"
                                                                       :alt="item.product.name"></a>
                                </td>

                                <td class="cart-product-name">
                                    <a href="javascript:void(0);" class="d-block">{{item.product.name}}</a>
                                    <span class="d-block">{{item.product.o_price|currency_rmb}}</span>
                                    <span class="d-block text-danger">{{item.product.b_price|currency}}</span>
                                </td>

                                <td class="cart-product-quantity">
                                    <div class="quantity clearfix">
                                        1x{{item.qty}}
                                    </div>
                                </td>

                                <td class="cart-product-subtotal">
                                    <span class="d-block">{{item.total_o|currency}}</span>
                                    <span class="d-block text-danger">{{item.total_b|currency}}</span>
                                </td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                    <h4>亲的购物车
                    </h4>

                    <div class="table-responsive">
                        <table class="table cart">
                            <tbody>
                            <tr class="cart_item">
                                <td class="notopborder cart-product-name">
                                    <strong>总数量</strong>
                                </td>

                                <td class="notopborder cart-product-name">
                                    <span class="amount lead">{{Qty}}</span>
                                </td>
                            </tr>
                            <tr class="cart_item">
                                <td class="cart-product-name">
                                    <strong>市场建议售价</strong>
                                </td>

                                <td class="cart-product-name">
                                    <span class="amount color"><strong>{{Total_O|currency_rmb}}</strong></span>
                                </td>
                            </tr>
                            <tr class="cart_item">
                                <td class="cart-product-name">
                                    <strong>药房进货价</strong>
                                </td>

                                <td class="cart-product-name">
                                    <span class="amount text-danger lead"><strong>{{Total_B|currency_rmb}}</strong></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="accordion clearfix">
                        <!--<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Direct Bank Transfer</div>-->
                        <!--<div class="acc_content clearfix">Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</div>-->

                        <!--<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Cheque Payment</div>-->
                        <!--<div class="acc_content clearfix">Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.</div>-->

                        <!--<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Paypal</div>-->
                        <!--<div class="acc_content clearfix">Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur.</div>-->
                    </div>
                </div>

                <div class="col_half col_last">

                    <div class="style-msg2 errormsg" v-show="hasError">
                        <div class="msgtitle">修改下面的错误:</div>
                        <div class="sb-msg">
                            <ul>
                                <li v-for="error in errors">
                                    {{error}}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col_full panel panel-default">

                        <div class="panel-heading"><h4 style="margin-bottom: 0;">客户信息</h4></div>
                        <div class="panel-body">
                            <div class="bottommargin-sm">
                                <label>选择商店</label>
                                <select v-model="shop" class="select-1 form-control select2-hidden-accessible" name="billing_shop" id="billing_shop"
                                        style="margin-left:30px;width:70%;background-color: #C5EBD1;" tabindex="-1" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="处方药请选用三澤药局">
                                    <option value="2">三澤薬局</option>
                                    <option value="3">三澤薬局OTC</option>
                                    <option value="1">KOUN</option>
                                </select>
                            </div>

                            <div class="col_full bottommargin-sm">
                                <input @blur="check_user_information()" type="text" id="billing-form-phone"
                                       name="billing-form-phone" v-model="customer.phone"
                                       style="background-color: #C5EBD1;" class="sm-form-control oldcustomer"
                                       placeholder="电话" data-toggle="tooltip" data-placement="top"
                                       title="填写后，过去的客户会自动填入"/>
                            </div>
                            <div id="customer_info" style="display: none;">
                                <div class="col_half bottommargin-sm">
                                    <!--<label for="billing-form-name">Name:</label>-->
                                    <input type="text" id="billing-form-name" name="billing-form-name" v-model="customer.name"
                                           class="sm-form-control oldcustomer" placeholder="姓名"/>
                                </div>

                                <div class="col_half bottommargin-sm">
                                    <label for="billing-form-name">性别:</label>
                                    <el-radio v-model="customer.sex" label="Mr.">男</el-radio>
                                    <el-radio v-model="customer.sex" label="Miss.">女</el-radio>

                                    <!--<input type="text" id="sex" name="sex" value="Mr." hidden/>-->
                                    <!--<input class="bt-switch" type="checkbox" checked data-on-text="男" data-off-text="女"-->
                                           <!--data-on-color="success" data-off-color="danger">-->
                                </div>

                                <div class="col_half bottommargin-sm">
                                    <!--<label for="billing-form-email">Email Address:</label>-->
                                    <input type="email" id="billing-form-email"
                                           name="billing-form-email" v-model="customer.email"
                                           class="sm-form-control oldcustomer" placeholder="邮箱"/>
                                </div>

                                <div class="col_half bottommargin-sm">
                                    <!--<label for="billing-form-email">Email Address:</label>-->
                                    <input type="text" id="billing-form-postcode"
                                           name="billing-form-postcode" v-model="customer.postcode"
                                           class="sm-form-control oldcustomer" placeholder="邮编"/>
                                </div>


                                <div class="col_full bottommargin-sm">

                                    <!--<label for="billing-form-address">Address:</label>-->
                                    <input type="text" id="billing-form-address" name="billing-form-address" v-model="customer.address1"
                                           class="sm-form-control oldcustomer" placeholder="地址 1"/>
                                </div>

                                <div class="col_full bottommargin-sm">
                                    <input type="text" id="billing-form-address2" name="billing-form-adress" v-model="customer.address2"
                                           class="sm-form-control oldcustomer" placeholder="地址 2"/>

                                    <div class="accordion clearfix">
                                        <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>输入地址信息请分段</div>
                                        <div class="acc_content clearfix">
                                            比如：上海市黄浦区哈尔滨路998弄大富小区2栋2022室 <br>
                                            地址栏1输入：上海市黄浦区哈尔滨路998弄 <br>
                                            地址栏2输入：大富小区2栋2022室
                                        </div>

                                        <!--<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Cheque Payment</div>-->
                                        <!--<div class="acc_content clearfix">Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.</div>-->

                                        <!--<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Paypal</div>-->
                                        <!--<div class="acc_content clearfix">Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur.</div>-->
                                    </div>

                                    <a href="#" class="button button-3d pull-right bg-warning" @click="PlaceOrder">下单</a>
                                </div>
                                <div class="center">
                                    <img src="/images/wechatpay.jpg" style="max-width:300px;">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import misawa_functions from "../../api/functions"

    import Swal from 'sweetalert2';

    export default {
        name: "checkout_form",
        components:{
            // cartitem
        },
        data() {
            return {
                coupon:"",
                shop:2,
                hasError:false,
                errors:[],
                checkouted:false,
                customer:{
                    id:0,
                    name:"",
                    sex:"Mr.",
                    phone:"",
                    email:"",
                    postcode:"",
                    address1:"",
                    address2:"",
                    oldcustomer:false
                }
            }
        },
        mounted(){


        },
        computed:{
            ...mapState({
                cartitems: state =>state.shoppingcart.items
            }),
            ...mapGetters({
                Qty: "shoppingcart/Qty",
                Total_O: "shoppingcart/Total_O",
                Total_B: "shoppingcart/Total_B"
            })
        },
        methods:{
            PlaceOrder(){
                var _params = {
                    vendor_id: this.shop,
                    coupon:this.$store.state.shoppingcart.coupon,
                    memo:this.$store.state.shoppingcart.memo,
                    customer: this.customer,
                    cartitems:this.cartitems
                };

                const transportfeeIndex=this.cartitems.findIndex(item =>item.product.id ==221 || item.product.id==304)

                console.log(transportfeeIndex)
                if(transportfeeIndex>-1){
                    Swal.queue([{
                        title: '订单确认',
                        confirmButtonText: '下单',
                        html:
                        '订单信息确认无误了吗？ <br>' +
                        '特别是<span style="color: red;"><strong>收件人的地址信息</strong></span>',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return this.$store.dispatch("shoppingcart/post_checkout",_params)
                                .then(resolve=>{
                                        if(resolve.result=="OK"){
                                            this.checkouted=true;
                                            this.$store.commit("shoppingcart/reset");
                                            Swal.insertQueueStep({
                                                type: 'success',
                                                title: '订单成功发出！',
                                                text:"亲的新订单号："+resolve.po_id
                                            })
                                        }else{
                                            Swal.insertQueueStep({
                                                type: 'error',
                                                title: '订单失败！',
                                                text:JSON.stringify(resolve)
                                            })
                                        }
                                    },reject=>{
                                        Swal.insertQueueStep({
                                            type: 'error',
                                            title: '订单失败！',
                                            text:"请联系您的代理，回报订单失败详细内容！"
                                        })
                                    })
                        }
                        }])
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: '添加运费',
                        text:"亲，你不加运费的呀！"
                    });
                    window.location.href='/#/subcatalogue/5/37';
                }


            },

            check_user_information(){
                var vm = this.customer;
                if (vm.phone.length) {
                    $("#customer_info").css("display","block");
                    axios.post("/user/checkcustomerinformation", {
                        phone: vm.phone
                    }).then(function (response) {
                        if (response.data.result == "OK") {
                            var user = response.data.user;
                            vm.id = user.id;
                            vm.name = user.name;
                            vm.sex = user.sex;
                            vm.postcode = user.postcode;
                            vm.address1 = user.address1;
                            vm.address2 = user.address2;
                            vm.email = user.email;
                            vm.phone = user.phone;
                            vm.oldcustomer = true;

                            $(".oldcustomer").css("background-color","#C5EBD1");
                        }else{
                            vm.oldcustomer = false;
                            vm.id=0;
                            $(".oldcustomer").css("background-color","pink");
                        }

                    }).catch(function (error) {
                        console.log(error);
                    });
                }
//                console.log(this.name);
            },

        }
    }
</script>

<style scoped>
</style>