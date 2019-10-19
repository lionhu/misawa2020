<template>
        <div class=" nobottommargin">
            <!-- Page Title
            ============================================= -->
            <section id="page-title" v-if="Qty == 0" class="page-title-parallax page-title-dark" style="background-image: url('/images/parallax/4.jpg'); background-size: cover; padding: 120px 0;" data-bottom-top="background-position:0px 0px;" data-top-bottom="background-position:0px -300px;">

                <div class="container-fluid clearfix">
                    <h1>亲，您的购物车是空滴！</h1>
                    <router-link to="/" class="button button-3d notopmargin pull-right">继续选购</router-link>
                </div>

            </section><!-- #page-title end -->

            <section id="page-title"  v-if="Qty>0">

                <div class="container clearfix">
                    <h1>购物车</h1>
                </div>

            </section>
            <section id="content" style="margin-bottom: 0px;"  v-if="Qty>0">

                <div class="content-wrap">

                    <div class="container-fluid clearfix">

                        <div class="table-responsive">
                            <table class="table cart">
                                <thead>
                                <tr>
                                    <th class="cart-product-remove">&nbsp;</th>
                                    <th class="cart-product-thumbnail">&nbsp;</th>
                                    <th class="cart-product-name">产品</th>
                                    <th class="cart-product-price">单价</th>
                                    <th class="cart-product-quantity">数量</th>
                                    <th class="cart-product-subtotal">小计</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="cart_item" v-for="item in cartitems">
                                    <td class="cart-product-remove">
                                        <a href="javascript:void(0);" class="remove" title="Remove this item" @click="cart_removeItem(item.product)"><i class="icon-trash2"></i></a>
                                    </td>

                                    <td class="cart-product-thumbnail">
                                        <a href="#"><img width="64" height="64" :src="'/'+item.product.thumbImage" :alt="item.product.name"></a>
                                    </td>

                                    <td class="cart-product-name">
                                        <router-link :to="{name:'product',params:{id:item.product.id}}">{{item.product.name}}</router-link>
                                    </td>

                                    <td class="cart-product-price">
                                        <span class="amount">{{item.product.o_price | currency}}</span>
                                    </td>

                                    <td class="cart-product-quantity">
                                        <div class="quantity clearfix">
                                            <input type="button" value="-" class="minus" @click="cart_removeProduct(1,item.product)">
                                            <input type="text" readonly name="quantity" :value="item.qty" class="qty">
                                            <input type="button" value="+" class="plus" @click="cart_addProduct(1,item.product)">
                                        </div>
                                    </td>

                                    <td class="cart-product-subtotal">
                                        <span class="amount">{{item.total_o|currency}}</span>
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
                                                <span class="amount color lead"><strong>{{Total_O|currency_rmb}}</strong></span>
                                            </td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>

                                    <div class="col_full nopadding">
                                            <div class="col_half">
                                                <input type="text" v-model="coupon" class="sm-form-control" placeholder="Enter Coupon Code..">
                                            </div>
                                            <div class="col_half col_last">
                                                <a href="javascript:void(0);" @click="SetCoupon" class="button button-3d button-black nomargin">Apply Coupon</a>
                                            </div>
                                    </div>
                                    <div class="col_full nopadding">
                                        <router-link to="/checkout" class="button button-3d notopmargin fright">结账</router-link>
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
                coupon:""
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
            cart_removeItem(_product){
                this.$store.commit("shoppingcart/removeitem",_product.id);
                misawa_functions.ShowMessage("error",_product.name+ " 被删除的一个不剩啦！");
            },
            cart_addProduct(_qty,_product){
                const params={
                    qty:_qty,
                    product:_product
                }
                this.$store.commit("shoppingcart/add_product",params);
                misawa_functions.ShowMessage("success",_product.name+" 追加成功啦！");
            },
            cart_removeProduct(_qty,_product){
                const params={
                    qty:_qty,
                    product:_product
                }
                this.$store.commit("shoppingcart/remove_product",params);
                misawa_functions.ShowMessage("error",_product.name+" 删除成功啦！");
            },
            SetCoupon(){
                this.$store.commit("shoppingcart/set_coupon",this.coupon);
                misawa_functions.ShowMessage("success","Coupon Applied!");
            },
        }
    }
</script>

<style scoped>
</style>