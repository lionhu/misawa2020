<template>
  <div class="container clearfix">

              <!-- Shop Categories
          ============================================= -->
    <div class="fancy-title title-dotted-border title-center mb-4">
      <h4>Shop popular categories</h4>
    </div>

    <div class="row shop-categories clearfix">
      <div class="col-lg-7">
        <a href="#" style="background: url(/static/canvas/demos/shop/images/categories/2-1.jpg) no-repeat right center; background-size: cover;">
          <div class="vertical-middle dark center">
            <div class="heading-block nomargin noborder">
              <h3 class="nott t600 ls0">For Him</h3>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-5">
        <a href="#" style="background: url(/static/canvas/demos/shop/images/categories/1.jpg) no-repeat center right; background-size: cover;">
          <div class="vertical-middle dark center">
            <div class="heading-block nomargin noborder">
              <h3 class="nott t600 ls0">For Her</h3>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-4">
        <a href="#" style="background: url(/static/canvas/demos/shop/images/categories/4.jpg) no-repeat center center; background-size: cover;">
          <div class="vertical-middle dark center">
            <div class="heading-block nomargin noborder">
              <h3 class="nott t600 ls0">Popular Products</h3>
              <small class="button bg-white text-dark button-light button-mini">Browse Now</small>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4">
        <a href="#" style="background: url(/static/canvas/demos/shop/images/categories/3.jpg) no-repeat center center; background-size: cover;">
          <div class="vertical-middle dark center">
            <div class="heading-block nomargin noborder">
              <h3 class="nott t600 ls0">Footwears</h3>
              <small class="button bg-white text-dark button-light button-mini">Shop Now</small>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4">
        <a href="#" style="background: url(/static/canvas/demos/shop/images/categories/5.jpg) no-repeat center center; background-size: cover;">
          <div class="vertical-middle dark center">
            <div class="heading-block nomargin noborder">
              <h3 class="nott t600 ls0">Sportswear</h3>
              <small class="button bg-white text-dark button-light button-mini">Shop Now</small>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- Featured Carousel
    ============================================= -->
    <div class="fancy-title title-dotted-border mt-4 mb-1 title-center">
      <h4>Weekly Featured Items</h4>
    </div>

    <div id="oc-products" class="owl-carousel products-carousel carousel-widget" data-margin="20" data-loop="true" data-autoplay="5000" data-nav="true" data-pagi="false" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4" data-items-xl="5">

        <!-- Shop Item 1
        ============================================= -->
        <div class="oc-item">
          <div class="product iproduct clearfix">
            <div class="product-image">
              <a href="#"><img src="/static/canvas/demos/shop/images/items/featured/1.jpg" alt="Round Neck T-shirts"></a>
              <a href="#"><img src="/static/canvas/demos/shop/images/items/featured/1-1.jpg" alt="Round Neck T-shirts"></a>
              <div class="sale-flash">Sale!</div>
              <div class="product-overlay">
                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                <a href="demos/shop/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-line-search"></i><span>Quick View</span></a>
              </div>
            </div>
            <div class="product-desc">
              <div class="product-title mb-1"><h3><a href="#">Round Neck Solid Light Blue Colour T-shirts</a></h3></div>
              <div class="product-price font-primary"><del class="mr-1">$24.99</del> <ins>$12.49</ins></div>
              <div class="product-rating">
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star-half-full"></i>
                <i class="icon-star-empty"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Shop Item 2
        ============================================= -->
        <div class="oc-item">
          <div class="product iproduct clearfix">
            <div class="product-image">
              <a href="#"><img src="/static/canvas/demos/shop/images/items/featured/2.jpg" alt="Navy Blue Dress"></a>
              <a href="#"><img src="/static/canvas/demos/shop/images/items/featured/2-1.jpg" alt="Navy Blue Dress"></a>
              <div class="product-overlay">
                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                <a href="demos/shop/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-line-search"></i><span>Quick View</span></a>
              </div>
            </div>
            <div class="product-desc">
              <div class="product-title mb-1"><h3><a href="#">Navy Blue Dress For Women</a></h3></div>
              <div class="product-price font-primary"><ins>$19.99</ins></div>
              <div class="product-rating">
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star-half-full"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Shop Item 3
        ============================================= -->
        <div class="oc-item">
          <div class="product iproduct clearfix">
            <div class="product-image">
              <a href="#"><img src="/static/canvas/demos/shop/images/items/featured/5.jpg" alt="Shoes"></a>
              <a href="#"><img src="/static/canvas/demos/shop/images/items/featured/5-1.jpg" alt="Shoes"></a>
              <div class="product-overlay">
                <a href="demos/shop/ajax/shop-item-no-stock.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-line-search"></i><span>Quick View</span></a>
              </div>
            </div>
            <div class="sale-flash bg-danger">Out of Stock!</div>
            <div class="product-desc">
              <div class="product-title mb-1"><h3><a href="#">White athletic shoe</a></h3></div>
              <div class="product-price font-primary"><ins>$35.00</ins></div>
              <div class="product-rating">
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Shop Item 4
        ============================================= -->
        <div class="oc-item">
          <div class="product iproduct clearfix">
            <div class="product-image">
              <div class="fslider" data-arrows="false" data-autoplay="4500">
                <div class="flexslider">
                  <div class="slider-wrap">
                    <div class="slide"><a href="#"><img src="/static/canvas/demos/shop/images/items/featured/4.jpg" alt="T-shirts"></a></div>
                    <div class="slide"><a href="#"><img src="/static/canvas/demos/shop/images/items/featured/4-1.jpg" alt="T-shirts"></a></div>
                    <div class="slide"><a href="#"><img src="/static/canvas/demos/shop/images/items/featured/4-2.jpg" alt="T-shirts"></a></div>
                    <div class="slide"><a href="#"><img src="/static/canvas/demos/shop/images/items/featured/4-3.jpg" alt="T-shirts"></a></div>
                  </div>
                </div>
              </div>
              <div class="product-overlay">
                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                <a href="demos/shop/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-line-search"></i><span>Quick View</span></a>
              </div>
            </div>
            <div class="sale-flash">Sale!</div>
            <div class="product-desc">
              <div class="product-title mb-1"><h3><a href="#">Navy blue T-shirt, Round neck, Short Sleeves</a></h3></div>
              <div class="product-price font-primary"><del class="mr-1">$27.99</del> <ins>$21.00</ins></div>
              <div class="product-rating">
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star-empty"></i>
                <i class="icon-star-empty"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Shop Item 5
        ============================================= -->
        <div class="oc-item">
          <div class="product iproduct clearfix">
            <div class="product-image">
              <a href="#"><img src="/static/canvas/demos/shop/images/items/featured/3.jpg" alt="T-shirts"></a>
              <div class="product-overlay">
                <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                <a href="demos/shop/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-line-search"></i><span>Quick View</span></a>
              </div>
            </div>
            <div class="product-desc">
              <div class="product-title mb-1"><h3><a href="#">Women Black T-Shirt</a></h3></div>
              <div class="product-price font-primary"><ins>$13.00</ins></div>
              <div class="product-rating">
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star3"></i>
                <i class="icon-star-empty"></i>
              </div>
            </div>
          </div>
        </div>

      </div>
  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  // import Swal from 'sweetalert2'

  export default {
    name: 'neworder',
    components:{
    },
    inject:["reload"],
    data () {
      return {
        ME:null,
        // todayrate:{},
        // order:{
        //   amount:10,
        //   rate:0,
        //   from_currency:"jpy",
        //   to_currency:"rmb",
        //   due_at:"",
        //   price:6200,
        //   user_id:0,
        //   memo:"....",
        //   send_notification:false
        // }
      }
    },
  computed: {
  },
    mounted() {
      // this.$store.dispatch("lotteryshop/getOrderBySlug","30c6d1d4-7631-4cde-af14-613c8e802ee20742").then(
      //         resolve=>{
      //           console.log(resolve.cart.id)
      //         },reject=>{})
    },
    methods: {
    }
};
</script>

<style lang="scss">
</style>