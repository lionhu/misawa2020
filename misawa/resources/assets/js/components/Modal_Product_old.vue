<template lang="html">
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="single-product shop-quick-view-ajax clearfix">

                        <div class="ajax-modal-title">
                            <h2>{{product.name}}</h2>
                        </div>

                        <div class="product modal-padding clearfix">

                            <div class="col_half nobottommargin">
                                <div class="product-image">
                                    <div class="fslider" data-pagi="false">
                                        <div class="flexslider">
                                            <div class="slider-wrap">
                                                <div class="slide"><a href="images/shop/dress/3.jpg"
                                                                      title="Pink Printed Dress - Front View"><img
                                                        src="images/shop/dress/3.jpg" alt="Pink Printed Dress"></a></div>
                                                <div class="slide"><a href="images/shop/dress/3-1.jpg"
                                                                      title="Pink Printed Dress - Side View"><img
                                                        src="images/shop/dress/3.jpg" alt="Pink Printed Dress"></a></div>
                                                <div class="slide"><a href="images/shop/dress/3-2.jpg"
                                                                      title="Pink Printed Dress - Back View"><img
                                                        src="images/shop/dress/3.jpg" alt="Pink Printed Dress"></a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sale-flash">Sale!</div>
                                </div>
                            </div>
                            <div class="col_half nobottommargin col_last product-desc">
                                <div class="product-price">
                                    <del>{{product.o_price}}</del>
                                    <ins>{{product.b_price}}</ins>
                                </div>
                                <div class="product-rating">
                                    <i class="icon-star3"></i>
                                    <i class="icon-star3"></i>
                                    <i class="icon-star3"></i>
                                    <i class="icon-star-half-full"></i>
                                    <i class="icon-star-empty"></i>
                                </div>
                                <div class="clear"></div>
                                <div class="line"></div>

                                <!-- Product Single - Quantity & Cart Button
                                ============================================= -->
                                <form class="cart nobottommargin clearfix" method="post" enctype='multipart/form-data'>
                                    <div class="quantity clearfix">
                                        <a href="#" v-on:click="qty += 1">+</a>
                                        <!--<input type="button" value="-" class="minus">-->
                                        <input type="text" step="1" min="1" name="quantity" :value="qty" title="Qty" class="qty" size="4"/>
                                        <!--<input type="button" value="+" class="plus">-->
                                        <a href="#" v-on:click="qty -= 1">-</a>
                                    </div>
                                    <button type="submit" class="add-to-cart button nomargin">Add to cart</button>
                                </form><!-- Product Single - Quantity & Cart Button End -->

                                <div class="clear"></div>
                                <div class="line"></div>
                                <p>Libero velit id eaque ex quae laboriosam nulla optio doloribus! Perspiciatis, libero, neque, perferendis
                                    at nisi optio dolor!</p>
                                <ul class="iconlist">
                                    <li><i class="icon-caret-right"></i> Dynamic Color Options</li>
                                    <li><i class="icon-caret-right"></i> Lots of Size Options</li>
                                    <li><i class="icon-caret-right"></i> 30-Day Return Policy</li>
                                </ul>
                                <div class="panel panel-default product-meta nobottommargin">
                                    <div class="panel-body">
                                        <span itemprop="productID" class="sku_wrapper">SKU: <span class="sku">8465415</span></span>
                                        <span class="posted_in">Category: <a href="http://localhost/offbeat/wp/product-category/shoes/"
                                                                             rel="tag">Shoes</a>.</span>
                                        <span class="tagged_as">Tags: <a href="http://dante.swiftideas.net/product-tag/barena/" rel="tag">Barena</a>, <a
                                                href="http://dante.swiftideas.net/product-tag/blazers/" rel="tag">Blazers</a>, <a
                                                href="http://dante.swiftideas.net/product-tag/tailoring/" rel="tag">Tailoring</a>, <a
                                                href="http://dante.swiftideas.net/product-tag/unconstructed/"
                                                rel="tag">Unconstructed</a>.</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['product_id'],
        data: function () {
            return {
                tabs: [],
                product:"",
                qty:0
            }
        },
        methods: {
//            selectTab(selectedTab){
//                this.tabs.forEach(tab=>{
//                    tab.isActive=(tab.name==selectedTab.name);
//                });
//            }
        },
        created(productid){
            var url="/product/"+productid;
            axios.get(url).then(response=>{

                this.product=response.data.product;
            console.log(this.product);
        });
        },
        mounted(){
//            var url="/product/"+this.product_id;
//            axios.get(url).then(response=>{
//
//                this.product=response.data.product;
//            console.log(this.product);
//        });
        }
    }
</script>

<style lang="css">

</style>