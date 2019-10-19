<template>
        <div class=" nobottommargin">


            <section id="page-title">

                <div class="container clearfix">
                    <h1>购物车</h1>
                    <input type="text" @blur="evaluateCart" v-model="user_rate">

                </div>

            </section>
            <section id="content" style="margin-bottom: 0px;">

                <div class="content-wrap">

                    <div class="container-fluid clearfix">

                        <div class="table-responsive">
                            <table class="table cart">
                                <thead>
                                <tr>
                                    <th class="cart-product-thumbnail">&nbsp;</th>
                                    <th class="cart-product-name">产品</th>
                                    <th class="cart-product-price">单价</th>
                                    <th class="cart-product-quantity">数量</th>
                                    <th class="cart-product-subtotal">小计</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="cart_item" v-for="item in cart.items">


                                    <td class="cart-product-thumbnail">
                                        <a href="#"><img width="64" height="64" :src="'/'+item.product.thumbImage" :alt="item.product.name"></a>
                                    </td>

                                    <td class="cart-product-name">
                                        <router-link :to="{name:'product',params:{id:item.product.id}}">{{item.product.name}}</router-link>
                                    </td>

                                    <td class="cart-product-price">
                                        <span class="d-block">{{item.product.o_price | currency}}</span>
                                        <span class="d-block">{{item.product.dis_price | currency}}</span>
                                        <span class="d-block">{{item.product.r_price | currency}}</span>
                                    </td>

                                    <td class="cart-product-quantity">
                                        <div class="quantity clearfix">
                                            <input type="text" readonly name="quantity" :value="item.qty" class="qty">
                                        </div>
                                    </td>

                                    <td class="cart-product-subtotal">
                                        <span class="d-block">{{item.total_o_price|currency}}</span>
                                        <span class="d-block">{{item.total_dis_price|currency}}</span>
                                        <span class="d-block">{{item.total_r_price|currency_jpy}}</span>
                                    </td>
                                </tr>
                                </tbody>

                            </table>
                        </div>

                        <div class="row clearfix">
                            <div class="col_half ">

                            </div>
                            <div class="col_half col_last">
                                <h4>购物车</h4>

                                <div class="table-responsive col_full">
                                    <table class="table cart">
                                        <tbody>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>总计金额</strong>
                                            </td>

                                            <td class="cart-product-name">
                                                <span class="d-block color "><strong>{{cart.Total_O_Price|currency_rmb}}</strong></span>
                                                <span class="d-block color "><strong>{{cart.Total_Dis_Price|currency_rmb}}</strong></span>
                                                <span class="d-block color lead"><strong>{{cart.Total_R_Price|currency_jpy}}</strong></span>
                                                <span class="d-block text-danger lead"><strong>{{cart.Total_Dis_Price - parseInt(cart.Total_R_Price*this.jpy_rate/100|currency_rmb)}}</strong></span>
                                            </td>
                                        </tr>
                                        </tbody>

                                    </table>
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


    export default {
        name: "cart",
        components:{
            // cartitem
        },
        data() {
            return {
                user_rate:0.2,
                jpy_rate:6
            }
        },
        mounted(){
            this.$store.dispatch("shoppingcart/superadmin_evaluateCart",this.user_rate);
        },
        computed:{
            ...mapState({
                cart: state =>state.shoppingcart.superadmin_cart,
                // jpyrate:state =>state.shoppingcart.jpyrate
            }),
            ...mapGetters({
                // Qty: "shoppingcart/Qty",
            })
        },
        methods:{
            evaluateCart(){
                this.$store.dispatch("shoppingcart/superadmin_evaluateCart",this.user_rate);
            }
        }
    }
</script>

<style scoped>
</style>