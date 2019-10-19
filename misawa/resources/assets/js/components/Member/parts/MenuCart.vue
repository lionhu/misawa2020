<template>

    <!-- Top Cart
    ============================================= -->
    <div id="top-cart">
        <a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span>{{Qty}}</span></a>
        <div class="top-cart-content">
            <div class="top-cart-title">
                <h4>购物车
                    <button class="button button-3d button-mini button-amber nomargin fright"
                            style="bottom: 5px;" @click="ClearCart">清空购物车</button>
                </h4>
            </div>
            <div class="top-cart-items">
                <div class="top-cart-item clearfix" v-for="item in cartitems">
                    <div class="top-cart-item-image">
                        <a href="#"><img :src="'/'+item.product.thumbImage" :alt="item.product.name" /></a>
                    </div>
                    <div class="top-cart-item-desc">
                        <a href="javascript:void(0);" class="d-block">{{item.product.name}}</a>
                        <span class="top-cart-item-price">{{item.product.o_price|currency}}x {{item.qty}}
                            <a href="javascript:void(0);" @click="RemoveItem(item.product.id)" class="pull-right"><i class="icon-trash text-red"></i></a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="top-cart-action clearfix">
                <span class="fleft top-checkout-price">{{Total_O|currency_rmb}}</span>
                <button class="button button-3d button-small nomargin fright" @click="ViewCart">结账</button>
            </div>
        </div>
    </div><!-- #top-cart end -->

</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import Swal from 'sweetalert2'

    export default {
        data: function () {
            return {
            }
        },
        methods: {
            ClearCart(){
                this.$store.commit("shoppingcart/reset")
                var top_cart = document.getElementById("top-cart");
                top_cart.className=""
            },
            RemoveItem(product_id){
                this.$store.commit("shoppingcart/removeitem",product_id)
            },
            ViewCart(){
                var top_cart = document.getElementById("top-cart");
                top_cart.className=""
                window.location.href="/#/cart";
            }
        },
        mounted(){
            // this.$store.dispatch("system/load_management_info");
        },
        computed:{
            ...mapState({
                cartitems: state =>state.shoppingcart.items,
            }),
            ...mapGetters({
                Qty: 'shoppingcart/Qty',
                Total_B: 'shoppingcart/Total_B',
                Total_O: 'shoppingcart/Total_O'
            })
        }
    }
</script>

<style lang="css">
</style>