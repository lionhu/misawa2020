<template>
    <div class="table-responsive bottommargin" >
        <div class="emptycart_message" v-show="emptyCart">
            <h2>空的购物车</h2>
            <div class="style-msg errormsg">
                <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Sorry!</strong> You have nothing in your shopping cart.</div>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>
        </div>
        <div class="mycart" v-show="!emptyCart">
            <div class="col-md-10 clearfix hidden-xs">
                <ul class="process-steps process-3 clearfix">
                    <li class="active">
                        <a href="#" class="i-bordered i-circled divcenter icon-shopping-cart"></a>
                        <h5>浏览购物车</h5>
                    </li>
                    <li >
                        <a href="#" class="i-bordered i-circled divcenter icon-pencil2"></a>
                        <h5>输入快递信息</h5>
                    </li>
                    <!--<li v-bind:class="{active:steps[3]}">-->
                    <!--<a href="#" class="i-circled i-alt divcenter bgcolor icon-like"></a>-->
                    <!--<h5>Complete Payment</h5>-->
                    <!--</li>-->
                    <li>
                        <a href="#" class="i-bordered i-circled divcenter icon-ok"></a>
                        <h5>订单完成</h5>
                    </li>
                </ul>
            </div>
            <div class="col-md-2">
                <span id="addcartmessage"></span>
                <button class="button button-3d nomargin button-green" @click="cleanCart">清空购物车</button>
            </div>
            <div class="clearfix"></div>
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
                                    <strong> <span class="amount color lead">{{Total_O_Price | currencyFormat}} </span></strong>
                                </td>
                            </tr>
                            </tbody>

                        </table>
                        <a v-if="cart_editmode != 'edit'" href="/cart/checkout" class="button button-3d nomargin" @click="checkout">结账!</a>
                        <a v-if="cart_editmode == 'edit'" href="/admin/pos/edit_updatePO" class="button button-3d nomargin">更新订单!</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import cartitem from "./CartItem";

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
                items:null
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
                $('#addcartmessage').attr("data-notify-msg","<i class=icon-info-sign></i> Hope to see you again!")
                    .attr("data-notify-type","warning")
                    .attr("data-notify-position","bottom-full-width");
                SEMICOLON.widget.notifications($('#addcartmessage'));

                return false;
            },
            alertme(operation,id,qty,price){
                if(operation=="add"){
                    this.Total_Qty +=1;
                    this.Total_O_Price +=parseInt(price);
                }
                if(operation=="minus"){
                    this.Total_Qty -=1;
                    this.Total_O_Price -=parseInt(price);
                }

                this.sync_seesion_cartitem(operation,id,qty);
            },
            sync_seesion_cartitem(operation,id,qty){
                axios.post("/cart/updateitem",{
                    id:id,
                    qty:qty,
                    operation:operation
                }).then(function(res){
                    console.log(res.data);
                    $(".cart_total").html(res.data.cart_Total_Qty);
                })
                    .catch(function(err){
                        console.log(err);
                    });
            },
            checkout(){
                console.log("checkout");
                return false;
            }
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
                vm.items = response.data.cart.items;

                $("#cart_total").html(response.data.Total_Qty);
            });
        }
    }
</script>

<style lang="css">

</style>