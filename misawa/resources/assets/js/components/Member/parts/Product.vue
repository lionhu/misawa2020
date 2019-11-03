<template>
    <div class="product clearfix">
            <div class="product-image ribbon_box3">
                <div class="ribbon_area">
                    <span class="ribbon15">NEW..</span>
                </div>
                <a href="javascript:void(0);">
                    <img :src="'/'+product.postimage"></a>

                <div class="product-overlay" v-if="ME.role !=='guest' && ME.role !=='viewer'">

                    <a  href="javascript:void(0);" @click="cart_addProduct(1,product)" >
                        <i class="icon-shopping-cart"></i><span> 加入购物车</span>
                    </a>

                    <a  class="item-quick-view koun_product" data-toggle="modal" :product_ID="product.id" data-target="#exampleModalLong">
                        <i class="icon-zoom-in2"></i><span> 快速浏览</span>
                    </a>
                </div>
            </div>
            <div class="product-desc center">
                <div class="product-title">
                    <h3>{{product.name}}</h3>
                    <small>{{product.name_jp}}</small>

                </div>
                <div class="product-price" v-if="ME.role !=='viewer'">
                    <ins class="d-block"> <span class="money">{{product.o_price|currency_rmb}}</span> </ins>
                    <a :href="'/#/viewproduct/'+product.id" target="_blank" class="btn btn-default  d-block" style="background-color: #1ABC9C;color: white;">
                        详细介绍</a>
                    <span  class="d-block text-warning" v-if="ME.role !=='guest'">{{product.b_price|currency_rmb}}</span>
                    <span  class="d-block text-warning"   v-if="ME.role =='distributor' || ME.role =='customerAdmin' || ME.role =='superadmin' ">({{product.j_price|currency_jpy}})</span>
                </div>
                <div class="product-rating">
                </div>
            </div>
        </div>
</template>

<script>
    import misawa_functions from "../../../api/functions"
    export default {
        props: ['product'],
        data: function () {
            return {
            }
        },
        methods: {
            cart_addProduct(_qty,_product){
                const params={
                    qty:_qty,
                    product:_product
                }
                this.$store.commit("shoppingcart/add_product",params);
                misawa_functions.ShowMessage("success",_product.name+"添加成功！");
            },

        },
        mounted(){

        },
        computed:{
            ME(){
                return this.$store.state.system.ME;
            }
        }
    }
</script>

<style lang="css">

</style>