<template>

    <div  :style="dynamicHeight">

        <!-- Page Title
        ============================================= -->
        <section id="page-title">

            <div class="container clearfix">
                <h1>{{Viewproduct.name}}</h1>
                <h4>{{Viewproduct.name_jp}}</h4>
                <h6 class="color">
                    <a :href="'/#/subcatalogue/'+Viewproduct.catalogue.id+'/'+Viewproduct.subcatalogue.id" >{{Viewproduct.catalogue.name}}--{{Viewproduct.subcatalogue.name}}</a>
                </h6>
                <!--<ol class="breadcrumb">-->
                    <!--<li class="breadcrumb-item"><a href="/">Home</a></li>-->
                    <!--<li class="breadcrumb-item"><a href="#">Shop</a></li>-->
                    <!--<li class="breadcrumb-item active" aria-current="page">Shop Single</li>-->
                <!--</ol>-->
            </div>

        </section><!-- #page-title end -->

        <div class="mt-50 nobottommargin">
            <div class="single-product">

                <div class="product">

                    <div class="col_half">

                        <!-- Product Single - Gallery
                        ============================================= -->
                        <!--<div class="product-image">-->
                            <!--<a :href="Viewproduct.postimage" :title="Viewproduct.name" data-lightbox="gallery-item">-->
                                <!--<img :src="Viewproduct.postimage" :alt="Viewproduct.name">-->
                            <!--</a>-->
                            <!--<div class="sale-flash">Sale!</div>-->
                        <!--</div>-->
                        <div class="product-image">
                            <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                                <div class="flexslider">
                                    <div class="slider-wrap" data-lightbox="gallery">
                                        <div class="slide" :data-thumb="image.path_image" :key="image.id" v-for="image in Viewproduct.images">
                                            <a :href="image.path_image" :title="Viewproduct.name" data-lightbox="gallery-item">
                                                <img :src="image.path_image" alt="Viewproduct.name">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sale-flash">Sale!</div>
                        </div>

                    </div>

                    <div class="col_half col_last product-desc">

                        <!-- Product Single - Price
                        ============================================= -->
                        <div class="product-price">
                            <ins>{{Viewproduct.o_price|currency_rmb}}</ins>
                        </div><!-- Product Single - Price End -->

                        <!-- Product Single - Rating
                        ============================================= -->
                        <!--<div class="product-rating" v-for="1 to Viewproduct.rate">-->
                            <!--<i class="icon-star3"></i>-->
                        <!--</div>&lt;!&ndash; Product Single - Rating End &ndash;&gt;-->

                        <!--<div class="clear"></div>-->
                        <!--<div class="line"></div>-->

                        <!-- Product Single - Quantity & Cart Button
                        ============================================= -->
                            <!--<button class="add-to-cart button nomargin" v-if="ME.role !=='guest'" @click="cart_addProduct(1,Viewproduct)">Add to cart</button>-->

                        <div class="clear"></div>
                        <el-rate
                                v-model="Viewproduct.rate"
                                disabled
                                show-score
                                text-color="#ff9900"
                                score-template="{value}">
                        </el-rate>
                        <div class="line"></div>

                        <p v-html="Viewproduct.efficacy"></p>
                        <!-- Product Single - Short Description
                        ============================================= -->
                        <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero velit id eaque ex quae laboriosam nulla optio doloribus! Perspiciatis, libero, neque, perferendis at nisi optio dolor!</p>-->
                        <!--<p>Perspiciatis ad eveniet ea quasi debitis quos laborum eum reprehenderit eaque explicabo assumenda rem modi.</p>-->
                        <!--<ul class="iconlist">-->
                            <!--<li><i class="icon-caret-right"></i> Dynamic Color Options</li>-->
                            <!--<li><i class="icon-caret-right"></i> Lots of Size Options</li>-->
                            <!--<li><i class="icon-caret-right"></i> 30-Day Return Policy</li>-->
                        <!--</ul>&lt;!&ndash; Product Single - Short Description End &ndash;&gt;-->

                        <!-- Product Single - Meta
                        ============================================= -->
                        <div class="card product-meta">
                            <div class="card-body">
                                <span itemprop="productID" class="sku_wrapper">厂家: <span class="sku">{{Viewproduct.manufactory}}</span></span>
                                <br>
                                <span itemprop="productID" class="sku_wrapper">SKU: <span class="sku">{{Viewproduct.product_code}}</span></span>
                                <br>
                                <span class="posted_in">大类别: <a :href="'/#/subcatalogue/'+Viewproduct.catalogue.id+'/'+Viewproduct.subcatalogue.id" rel="tag">{{Viewproduct.catalogue.name}}</a>.</span>
                                <br>
                                <span class="posted_in">小类别: <a :href="'/#/subcatalogue/'+Viewproduct.catalogue.id+'/'+Viewproduct.subcatalogue.id" rel="tag">{{Viewproduct.subcatalogue.name}}</a>.</span>
                                <br>
                                <!--<span class="tagged_as">Tags: <a href="#" rel="tag">Pink</a>, <a href="#" rel="tag">Short</a>, <a href="#" rel="tag">Dress</a>, <a href="#" rel="tag">Printed</a>.</span>-->
                            </div>
                        </div><!-- Product Single - Meta End -->

                        <!-- Product Single - Share
                        ============================================= -->
                        <!--<div class="si-share noborder clearfix">-->
                            <!--<span>Share:</span>-->
                            <!--<div>-->
                                <!--<a href="#" class="social-icon si-borderless si-facebook">-->
                                    <!--<i class="icon-facebook"></i>-->
                                    <!--<i class="icon-facebook"></i>-->
                                <!--</a>-->
                                <!--<a href="#" class="social-icon si-borderless si-twitter">-->
                                    <!--<i class="icon-twitter"></i>-->
                                    <!--<i class="icon-twitter"></i>-->
                                <!--</a>-->
                                <!--<a href="#" class="social-icon si-borderless si-pinterest">-->
                                    <!--<i class="icon-pinterest"></i>-->
                                    <!--<i class="icon-pinterest"></i>-->
                                <!--</a>-->
                                <!--<a href="#" class="social-icon si-borderless si-gplus">-->
                                    <!--<i class="icon-gplus"></i>-->
                                    <!--<i class="icon-gplus"></i>-->
                                <!--</a>-->
                                <!--<a href="#" class="social-icon si-borderless si-rss">-->
                                    <!--<i class="icon-rss"></i>-->
                                    <!--<i class="icon-rss"></i>-->
                                <!--</a>-->
                                <!--<a href="#" class="social-icon si-borderless si-email3">-->
                                    <!--<i class="icon-email3"></i>-->
                                    <!--<i class="icon-email3"></i>-->
                                <!--</a>-->
                            <!--</div>-->
                        <!--</div>&lt;!&ndash; Product Single - Share End &ndash;&gt;-->

                    </div>

                    <div class="col_full nobottommargin">

                        <div class="tabs clearfix nobottommargin" id="tab-1">

                            <ul class="tab-nav clearfix">
                                <!--<li><a href="#tabs-1"><i class="icon-align-justify2"></i><span class="d-none d-md-inline-block"> 产品介绍</span></a></li>-->
                                <li><a href="#tabs-2"><i class="icon-info-sign"></i><span class="d-none d-md-inline-block"> 服用方法</span></a></li>
                                <!--<li><a href="#tabs-3"><i class="icon-star3"></i><span class="d-none d-md-inline-block"> Reviews (2)</span></a></li>-->
                            </ul>

                            <div class="tab-container">

                                <!--<div class="tab-content clearfix" id="tabs-1">-->
                                    <!--<p v-html="Viewproduct.efficacy"></p>-->
                                <!--</div>-->
                                <div class="tab-content clearfix" id="tabs-2">
                                    <p v-html="Viewproduct.description"></p>
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

    import misawa_functions from "../../api/functions"

    export default {
        data: function () {
            return {
                CatalogueProducts:[],
                dynamicHeight:{
                    height:''
                }
            }
        },
        methods: {
            getContentHeight(){
                this.dynamicHeight.height=window.innerHeight+70+'px';
                console.log(this.dynamicHeight.height)
            },
            cart_addProduct(_qty,_product){
                const params={
                    qty:_qty,
                    product:_product
                }
                this.$store.commit("shoppingcart/add_product",params);
                misawa_functions.ShowMessage("success",_product.name+"添加成功！");
            },
        },
        created(){
            window.addEventListener("resize",this.getContentHeight);
            this.getContentHeight();

        },
        destroyed(){
            window.removeEventListener("resize",this.getContentHeight);
        },
        mounted(){
            this.$store.dispatch("shoppingcart/get_viewproduct",{productid:this.$route.params.id,rate:this.ME.rate});

        },
        computed:{
            Viewproduct(){
                return this.$store.state.shoppingcart.viewproduct;
            },
            ME(){
                return this.$store.state.system.ME
            }
        },
        watch:{
            $route(to,from){
                this.$store.dispatch("shoppingcart/get_viewproduct",this.$route.params.id);

                // this.loadCatalogueProducts(to.params.id);
                this.getContentHeight();
                window.location.reload()
            }
        }
    }
</script>

<style lang="css">

</style>