<template>
    <div>
        <ul class="process-steps process-3 clearfix hidden-xs">
                <li id="process-step-1">
                    <a href="#" class="i-bordered i-circled divcenter icon-shopping-cart"></a>
                    <h5>浏览购物车</h5>
                </li>
                <li id="process-step-2" class="active">
                    <a href="#" class="i-bordered i-circled divcenter icon-pencil2"></a>
                    <h5>输入快递信息</h5>

                </li>
                <li id="process-step-3" >
                    <a href="#" class="i-bordered i-circled divcenter icon-ok"></a>
                    <h5>订单完成</h5>
                </li>
            </ul>
        <div class="clear"></div>
        <div id="order_form">
            <div class="col-md-6 clearfix">
                <div class="bottommargin-sm col_half">
                    <label>选择商店</label>
                    <select v-model="shop" class="select-1 form-control select2-hidden-accessible" name="billing_shop" id="billing_shop"
                            style="width:100%;background-color: #C5EBD1;" tabindex="-1" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="处方药请选用三澤药局">
                        <option value="2">三澤薬局</option>
                        <option value="3">三澤薬局OTC</option>
                        <option value="1">KOUN</option>
                    </select>
                </div>

                <div class="col_half bottommargin-sm">
                    <!--<label for="billing-form-phone">Phone:</label>-->
                    <input @blur="check_user_information()" type="text" id="billing-form-phone"
                           name="billing-form-phone" v-model="phone"
                           style="background-color: #C5EBD1;" class="sm-form-control oldcustomer"
                           placeholder="电话" data-toggle="tooltip" data-placement="top"
                           title="填写后，过去的客户会自动填入"/>
                </div>

                <div id="customer_info" style="display: none;">
                    <div class="col_half bottommargin-sm">
                        <!--<label for="billing-form-name">Name:</label>-->
                        <input type="text" id="billing-form-name" name="billing-form-name" v-model="name"
                               class="sm-form-control oldcustomer" placeholder="姓名"/>
                    </div>

                    <div class="col_half bottommargin-sm">
                        <label for="billing-form-name">性别:</label>
                        <input type="text" id="sex" name="sex" value="Mr." hidden/>
                        <input class="bt-switch" type="checkbox" checked data-on-text="男" data-off-text="女"
                               data-on-color="success" data-off-color="danger">
                    </div>

                    <div class="col_half bottommargin-sm">
                        <!--<label for="billing-form-email">Email Address:</label>-->
                        <input type="email" id="billing-form-email"
                               name="billing-form-email" v-model="email"
                               class="sm-form-control oldcustomer" placeholder="邮箱"/>
                    </div>

                    <div class="col_half bottommargin-sm">
                        <!--<label for="billing-form-email">Email Address:</label>-->
                        <input type="text" id="billing-form-postcode"
                               name="billing-form-postcode" v-model="postcode"
                               class="sm-form-control oldcustomer" placeholder="邮编"/>
                    </div>


                    <div class="col_full bottommargin-sm">

                        <!--<label for="billing-form-address">Address:</label>-->
                        <input type="text" id="billing-form-address" name="billing-form-address" v-model="address_1"
                               class="sm-form-control oldcustomer" placeholder="地址 1"/>
                    </div>

                    <div class="col_full bottommargin-sm">
                        <input type="text" id="billing-form-address2" name="billing-form-adress" v-model="address_2"
                               class="sm-form-control oldcustomer" placeholder="地址 2"/>

                        <p class="clearfix text-danger">*输入地址信息请分段。 <br>
                            比如：上海市黄浦区哈尔滨路998弄大富小区2栋2022室 <br>
                            请在 地址栏1处输入：上海市黄浦区哈尔滨路998弄 <br>
                            地址栏2处输入：大富小区2栋2022室
                        </p>
                    </div>

                </div>

                <div class="clear"></div>
            </div>

            <div class="col-md-6">

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
                    <div class="panel-heading"><h4 style="margin-bottom: 0;">购物车合计</h4></div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table cart">
                                <tbody>
                                <tr class="cart_item">
                                    <td class="notopborder cart-product-name">
                                        <strong>总数量</strong>
                                    </td>

                                    <td class="notopborder cart-product-name">
                                        <span class="amount">{{Total_Qty}}</span>
                                    </td>
                                </tr>
                                <tr class="cart_item">
                                    <td class="notopborder cart-product-name">
                                        <strong>市场销售价</strong>
                                    </td>

                                    <td class="notopborder cart-product-name">
                                        <span class="amount">{{Total_O_Price | currencyFormat}}</span>
                                    </td>
                                </tr>
                                <!--<tr class="cart_item">-->
                                    <!--<td class="cart-product-name">-->
                                        <!--<strong>支付金额合计</strong>-->
                                    <!--</td>-->

                                    <!--<td class="cart-product-name">-->
                                        <!--<span class="amount color lead"><strong>{{total_dis_price | currencyFormat}}</strong></span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                </tbody>
                            </table>

                            <div class="col_full bottommargin-sm">
                                <label for="shipping-form-message">备注
                                    <small>*</small>
                                </label>
                                <input class="sm-form-control" id="shipping-form-message" v-model="memo"
                                       name="shipping-form-message"/>
                            </div>
                            <a href="#" @click="placeOrder" class="button button-3d fright">下单</a>
                            <a href="/cart" class="button button-3d button-black fleft">返回</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["total_dis_price","total_o_price", "qty"],
        data: function () {
            return {
                name: "",
                shop: 2,
                sex: "man",
                postcode: "",
                address_1: "",
                address_2: "",
                email: "",
                phone: "",
                memo: "",
                errors: [],
                hasError: false,
                oldcustomer:false,
                steps:[true,false,true,false,false],
                setp:"delivery",

                Total_O_Price:0,
                Total_Qty:0,

            }
        },
        filters: {
            currencyFormat: function (num) {
                var result = [], counter = 0;
                num = (num || 0).toString().split('');
                for (var i = num.length - 1; i >= 0; i--) {
                    counter++;
                    result.unshift(num[i]);
                    if (!(counter % 3) && i != 0) {
                        result.unshift(',');
                    }
                }
                return result.join('') + "元";
            }
        },
        methods: {
            check_user_information(){

                if (this.phone.length) {
                    $("#customer_info").css("display","block");
                    var vm = this;
                    axios.post("/user/checkcustomerinformation", {
                        phone: this.phone
                    }).then(function (response) {
                        if (response.data.result == "OK") {
//                            console.log(response.data.user);
                            var user = response.data.user;
//                            console.log(user.name);
//                            $("#billing-form-name").val(response.data.user.name);
                            vm.name = user.name;
                            vm.sex = user.sex;
                            vm.postcode = user.postcode;
                            vm.address_1 = user.address1;
                            vm.address_2 = user.address2;
                            vm.email = user.email;
                            vm.phone = user.phone;
                            vm.oldcustomer = true;

                            $(".oldcustomer").css("background-color","#C5EBD1");
                        }else{
                            $(".oldcustomer").css("background-color","pink");
                        }

                    }).catch(function (error) {
                        console.log(error);
                    });
                }
//                console.log(this.name);
            },
            placeOrder(){
                var url = "/cart/checkout";
                var info_sex = $("#sex").val();
                var self = this;

                $("#myModal").modal();
                var params={
                    name: this.name,
                    shop: this.shop,
                    sex: info_sex,
                    postcode: this.postcode,
                    address_1: this.address_1,
                    address_2: this.address_2,
                    email: this.email,
                    phone: this.phone,
                    memo: this.memo,
                    oldcustomer:this.oldcustomer
                };

                axios.post(url, params).then(function (response) {
                        self.errors = [];
                        self.hasError = false;

                        $(".successmsg").css("display","block");
                        $("#order_form").css("display","none");
                        $("#process-step-3").addClass("active");
                        $("#process-step-2").removeClass("active");
                        $("#checkresult").html("订单完成："+response.data.poid);

                        $("#myModal").modal("hide");
                }).catch(function (error) {
                    self.hasError = true;
                    self.errors = error.response.data;

                    $("#myModal").modal("hide");
                });

                return false;
            }
        },
        mounted(){
            axios.post("/cart/getcart").then(response => {
                this.Total_O_Price=response.data.Total_O_Price;
                this.Total_Qty=response.data.Total_Qty;
                $("#cart_total").html(response.data.Total_Qty);
            });

            // $("#billing_shop").options[0].selected = true;
        }
    }

</script>

<style lang="css">

</style>