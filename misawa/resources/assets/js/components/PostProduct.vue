<script src="../Cart.js"></script>
<template lang="html">

    <div class="product sf-dress clearfix">
        <div class="product-image">
            <a href="#"><img src="images/shop/dress/1.jpg" alt="Checked Short Dress"></a>
            <a href="#"><img src="images/shop/dress/1-1.jpg" alt="Checked Short Dress"></a>
            <div class="sale-flash">50% Off*</div>
            <div class="product-overlay">
                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
            </div>
        </div>
        <div class="product-desc center">
            <div class="product-title"><h3><a href="#">Checked Short Dress</a></h3></div>
            <div class="product-price"><del>$24.99</del> <ins>$12.49</ins></div>
            <div class="product-rating">
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star-half-full"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product'],
        data: function () {
            return {
            }
        },
        methods: {
        },
        computed:{
            imgurl(){
                return "http://localhost:8000/"+this.product.postimage;
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
//            var vm=this;
//            axios.get("/cart/getcart").then(response => {
//                vm.shoppingcart = response.data.cart;
//                vm.Total_Qty = response.data.cart.Total_Qty;
//                vm.Total_O_Price = response.data.cart.Total_O_Price;
//                vm.items = response.data.cart.items;
//            });
        }
    }
</script>

<style lang="css">

</style>