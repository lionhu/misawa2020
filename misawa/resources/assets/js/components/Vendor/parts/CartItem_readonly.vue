<template>

        <tr class="cart_item">
            <td class="cart-product-name"  v-if="device=='xs'">
                <div class="col-xs-6">
                    <a :href="producturl(cartitem.product.id)">
                        <img width="64" height="64" :src="'/'+cartitem.product.thumbimage">
                    </a>
                </div>
                <div class="col-xs-6">
                    <span> {{cartitem.r_price | currency_jpy}}</span> <br>
                    <span> qty: {{cartitem.qty}}</span>
                </div>
                <div class="col-xs-12 clearfix">
                    <!--{{cartitem.product.name}}(#{{cartitem.product.id}})-->
                    <a href="javascript:void(0);">{{cartitem.product.name_jp}}(#{{cartitem.product.id}}) </a>
                </div>
            </td>

            <td class="cart-product-thumbnail " v-if="device=='md'">
                <img width="64" height="64" :src="'/'+cartitem.product.thumbimage">
            </td>

            <td class="cart-product-name" v-if="device=='md'">
                <a href="javascript:void(0);">{{cartitem.product.name_jp}}(#{{cartitem.product.id}}) <br>
                    {{cartitem.product.product_code}}
                </a>
            </td>

            <td class="cart-product-price " v-if="device=='md'">
                <span>{{cartitem.r_price | currency_jpy}}</span>
            </td>

            <td class="cart-product-quantity " v-if="device=='md'">
                <div class="quantity clearfix">
                    {{cartitem.qty}}
                </div>
            </td>

            <td class="cart-product-subtotal " v-if="device=='md'" >
                <span class="amount">{{subtotal_r | currency_jpy}}</span>
            </td>

        </tr>

</template>

<script>
    export default {
        props: ['cartitem',"device"],
        data: function () {
            return {
                id:0,
                name:"",
                r_price:0,
                qty:0,
                // visible:true
            }
        },
        methods: {
            imgurl(url){
                return ""+url;
            },
            producturl(id){
                return "/product/"+id;
            },
        },
        mounted(){
            this.id=this.cartitem.product_id;
            this.name=this.cartitem.product.name;
            this.r_price=this.cartitem.r_price;
            this.qty=this.cartitem.qty;
        },
        computed:{
            subtotal_r(){
                return this.r_price*this.qty;
            }
        }
    }
</script>

<style lang="css">
 .title{
    display: inline-block;
    width: 80px;
     text-align:right;
}
</style>