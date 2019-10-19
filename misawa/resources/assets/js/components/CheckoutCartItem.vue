<template>
    <div>

        <td class="cart-product-thumbnail">
            <a href="#"><img width="64" height="64" src="images/shop/thumbs/small/dress-3.jpg" alt="Pink Printed Dress"></a>
        </td>

        <td class="cart-product-name">
            <a href="#">name</a>
        </td>

        <td class="cart-product-quantity">
            <div class="quantity clearfix">
                1x2
            </div>
        </td>

        <td class="cart-product-subtotal">
            <span class="amount">$39.98</span>
        </td>
    </div>
</template>

<script>
    export default {
        props: ['cartitem'],
        data: function () {
            return {
                id:0,
                name:"",
                price:0,
                qty:0
            }
        },
        methods: {
            imgurl(url){
                return "http://localhost:8000/"+url;
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
//            this.id=this.cartitem.item.id;
//            this.name=this.cartitem.item.name;
//            this.price=this.cartitem.item.o_price;
//            this.qty=this.cartitem.qty;
        },
        computed:{
            subtotal(){
                return this.price*this.qty;
            }
        }
    }
</script>

<style lang="css">

</style>