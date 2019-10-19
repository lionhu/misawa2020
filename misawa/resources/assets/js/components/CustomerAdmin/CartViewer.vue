<template>
    <div class="postcontent nobottommargin">

        <input type="text" v-model="rate" class="hidden-print">
        <div class="table-responsive bottommargin" >
        <div class="mycart">
            <table class="table cart">
                <thead>
                <tr>
                    <!--<th class="cart-product-remove">&nbsp;</th>-->
                    <th class="cart-product-thumbnail"></th>
                    <th class="cart-product-name">产品</th>
                    <th class="cart-product-price hidden-xs">单价</th>
                    <th class="cart-product-quantity hidden-xs">数量</th>
                    <th class="cart-product-subtotal hidden-xs">总计</th>
                </tr>
                </thead>
                <tbody>
                <cartitem v-for="item in items" :key="item.id" :cartitem="item" @change_qty="alertme"></cartitem>
                </tbody>

            </table>
            <div class="row clearfix">
                <div class="col-md-6 clearfix">
                </div>

                <div class="col-md-6 clearfix">
                    <div class="table-responsive">
                        <h4>购物车合计:</h4>

                        <table class="table cart">
                            <tbody>
                            <tr class="cart_item">
                                <td class="cart-product-name">
                                    <strong>数量</strong>
                                </td>

                                <td class="cart-product-name">
                                    <span class="amount">{{Total_Qty}}</span>
                                </td>
                            </tr>
                            <tr class="cart_item">
                                <td class="cart-product-name">
                                    <strong>总额</strong>
                                </td>

                                <td class="cart-product-name">
                                    <strong> <span class="amount color lead">{{Total_O_Price | currency_rmb}} </span></strong>
                                </td>
                            </tr>
                            <tr class="cart_item">
                                <td class="cart-product-name">
                                    <strong>代理价格</strong>
                                </td>

                                <td class="cart-product-name">
                                    <strong><span class="amount color lead">{{Total_B_Price+(Total_O_Price-Total_B_Price)*rate | currency_rmb}} </span></strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
    import cartitem from "./parts/CartItem";

    export default {
        props:["cart_editmode"],
        components:{
          cartitem
        },
        data: function () {
            return {
                shoppingcart:null,
                Total_Qty:0,
                Total_O_Price:0,
                Total_B_Price:0,
                items:null,
                rate:0
            }
        },
        methods: {
            cleanCart(){
                this.Total_Qty=0;
                this.Total_O_Price=0;
                this.items=null;
                var vm=this;
                axios.post("/cart/clear")
                    .then(function(res){
                        console.log(res.data.cart);
                        $("#cart_total").html(0);
                    });
            },
            alertme(operation,id,qty,o_price,b_price){
                if(operation=="add"){
                    this.Total_Qty +=1;
                    this.Total_O_Price +=parseInt(o_price);
                    this.Total_B_Price +=parseInt(b_price);
                }
                if(operation=="minus"){
                    this.Total_Qty -=1;
                    this.Total_O_Price -=parseInt(o_price);
                    this.Total_B_Price -=parseInt(b_price);
                }
                this.sync_seesion_cartitem(operation,id,qty);
            },
            sync_seesion_cartitem(operation,id,qty){
                axios.post("/cart/updateitem",{
                    id:id,
                    qty:qty,
                    operation:operation
                }).then(function(res){
                    $(".cart_total").html(res.data.cart_Total_Qty);
                }).catch(function(err){
                        console.log(err);
                    });
            },

        },
        computed:{
            emptyCart(){
                return this.Total_Qty===0?true:false;
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
            var vm=this;

            axios.post("/cart/getcart").then(response => {
                vm.shoppingcart = response.data.cart;
                vm.Total_Qty = response.data.Total_Qty;
                vm.Total_O_Price = response.data.Total_O_Price;
                vm.Total_B_Price = response.data.cart.Total_B_Price;
                vm.items = response.data.cart.items;

                $("#cart_total").html(response.data.Total_Qty);
            });
        }
    }
</script>

<style lang="css">

</style>