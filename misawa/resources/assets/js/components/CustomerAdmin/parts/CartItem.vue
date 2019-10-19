<template>
    <tr class="cart_item" v-show="visible">
        <!--<td class="cart-product-remove">-->
            <!--<a href="#" class="remove" title="Remove this item" @click="clearitem"><i class="icon-trash2"></i></a>-->
        <!--</td>-->

        <td class="cart-product-thumbnail">
            <img width="64" height="64" :src="'/'+cartitem.item.thumbimage">
        </td>

        <td class="cart-product-name">
            <a :href="producturl(id)"> {{cartitem.item.name}}</a> <br>
            <span class="amount money visible-xs"> {{cartitem.item.o_price | currency}}</span> <br>
            <span class="amount money visible-xs"> {{cartitem.item.b_price | currency}}</span>

            <div class="quantity clearfix visible-xs">
                <input type="button" value="-" class="minus hidden-print" @click="removeitem">
                <input type="text" name="quantity" :value="qty" class="qty" />
                <input type="button" value="+" class="plus hidden-print" @click="additem">
            </div>
            <div class="visible-xs">
                subtotal:<span class="amount">{{subtotal_o | currency}}</span> <br>
                <span class="amount">{{subtotal_b | currency}}</span>

            </div>
        </td>

        <td class="cart-product-price hidden-xs">
            <span class="amount money"> {{cartitem.item.o_price | currency}}</span> <br>
            <span class="amount money"> {{cartitem.item.b_price | currency}}</span>
        </td>

        <td class="cart-product-quantity hidden-xs">
            <div class="quantity clearfix">
                <input type="button" value="-" class="minus hidden-print" @click="removeitem">
                <input type="text" name="quantity" :value="qty" class="qty" />
                <input type="button" value="+" class="plus hidden-print" @click="additem">
            </div>
        </td>

        <td class="cart-product-subtotal hidden-xs" >
            <span class="amount">{{subtotal_o | currency}}</span> <br>
            <span class="amount">{{subtotal_b | currency}}</span>
        </td>

    </tr>

</template>

<script>
    export default {
        props: ['cartitem'],
        data: function () {
            return {
                id:0,
                name:"",
                o_price:0,
                b_price:0,
                qty:0,
                visible:true
            }
        },
        methods: {
            imgurl(url){
                return ""+url;
            },
            producturl(id){
                return "/product/"+id;
            },
            additem(){
                this.qty +=1;
                this.$emit('change_qty', "add",this.id,this.qty,this.o_price,this.b_price);
            },
            removeitem(){
                this.qty >0?this.qty -=1:0;
                if(this.qty==0){
                    this.visible=false;
                }
                this.$emit('change_qty', "minus",this.id,this.qty,this.o_price,this.b_price);
            },
            clearitem(){
                this.visible=false;
                this.$emit('change_qty', "remove",this.id,this.qty,this.o_price,this.b_price);
            }
        },
        filters:{
            currencyFormat: function (num) {
                var result = [ ], counter = 0;
                num = (num || 0).toString().split('');
                for (var i = num.length - 1; i >= 0; i--) {
                    counter++;
                    result.unshift(num[i]);
                    if (!(counter % 3) && i != 0) { result.unshift(','); }
                }
                return result.join('')+"元";
            }
        },
        mounted(){
            this.id=this.cartitem.item.id;
            this.name=this.cartitem.item.name;
            this.o_price=this.cartitem.item.o_price;
            this.b_price=this.cartitem.item.b_price;
            this.qty=this.cartitem.qty;
        },
        computed:{
            subtotal_o(){
                return this.o_price*this.qty;
            },
            subtotal_b(){
                return this.b_price*this.qty;
            }
        }
    }
</script>

<style lang="css">

</style>