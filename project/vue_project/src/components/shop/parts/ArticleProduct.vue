<template>
      <section id="slider" class="slider-element slider-parallax swiper_wrapper full-screen clearfix" data-loop="true">

      <div class="slider-parallax-inner">

        <div class="swiper-container swiper-parent"  v-for="articleImage in product.article.galleryimages">
          <div class="swiper-wrapper">
            <div class="swiper-slide dark" :style="'background-image: url('+articleImage.postimage+');'">
              <div class="container clearfix">
                <div class="slider-caption slider-caption-center">
                  <h2 data-animate="fadeInUp">Welcome to Canvas</h2>
                  <p class="d-none d-sm-block" data-animate="fadeInUp" data-delay="200">Create just what you need for your Perfect Website. Choose from a wide range of Elements &amp; simply put them on our Canvas.</p>
                </div>
              </div>
            </div>
          <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
          <div class="slider-arrow-right"><i class="icon-angle-right"></i></div>
          <div class="slide-number">
            <div class="slide-number-current"></div>
            <span>/</span>
            <div class="slide-number-total"></div>
          </div>
        </div>
      </div>

      </div>

    </section>






<!-- 
<div id="portfolio" class="portfolio grid-container portfolio-nomargin portfolio-full portfolio-masonry mixed-masonry grid-container clearfix">

  <article class="portfolio-item pf-media pf-icons wide" v-for="articleImage in product.article.galleryimages">
    <div class="portfolio-image">
      <a href="portfolio-single.html">
        <img :src="articleImage.thumbimage" alt="Open Imagination">
      </a>
      <div class="portfolio-overlay">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single.html">Open Imagination</a></h3>
          <span><a href="#">Media</a>, <a href="#">Icons</a></span>
        </div>
        <a :href="articleImage.postimage" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
        <a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article> -->
<!-- 
  <article class="portfolio-item pf-illustrations">
    <div class="portfolio-image">
      <a href="portfolio-single.html">
        <img src="images/portfolio/4/mixed/2.jpg" alt="Locked Steel Gate">
      </a>
      <div class="portfolio-overlay">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single.html">Locked Steel Gate</a></h3>
          <span><a href="#">Illustrations</a></span>
        </div>
        <a href="images/portfolio/full/2.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
        <a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article> -->
<!-- 
  <article class="portfolio-item pf-graphics pf-uielements">
    <div class="portfolio-image">
      <a href="#">
        <img src="images/portfolio/4/mixed/3.jpg" alt="Mac Sunglasses">
      </a>
      <div class="portfolio-overlay">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single-video.html">Mac Sunglasses</a></h3>
          <span><a href="#">Graphics</a>, <a href="#">UI Elements</a></span>
        </div>
        <a href="http://vimeo.com/89396394" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
        <a href="portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article>

  <article class="portfolio-item pf-icons pf-illustrations wide">
    <div class="portfolio-image">
      <div class="fslider" data-arrows="false" data-speed="400" data-pause="4000">
        <div class="flexslider">
          <div class="slider-wrap">
            <div class="slide"><a href="portfolio-single-gallery.html"><img src="images/portfolio/4/mixed/4.jpg" alt="Morning Dew"></a></div>
            <div class="slide"><a href="portfolio-single-gallery.html"><img src="images/portfolio/4/mixed/4-1.jpg" alt="Morning Dew"></a></div>
          </div>
        </div>
      </div>
      <div class="portfolio-overlay" data-lightbox="gallery">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single-gallery.html">Morning Dew</a></h3>
          <span><a href="#">Icons</a>, <a href="#">Illustrations</a></span>
        </div>
        <a href="images/portfolio/full/4.jpg" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-stack-2"></i></a>
        <a href="images/portfolio/full/4-1.jpg" class="hidden" data-lightbox="gallery-item"></a>
        <a href="portfolio-single-gallery.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article>

  <article class="portfolio-item pf-uielements pf-media">
    <div class="portfolio-image">
      <a href="portfolio-single.html">
        <img src="images/portfolio/4/mixed/5.jpg" alt="Console Activity">
      </a>
      <div class="portfolio-overlay">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single.html">Console Activity</a></h3>
          <span><a href="#">UI Elements</a>, <a href="#">Media</a></span>
        </div>
        <a href="images/portfolio/full/5.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
        <a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article>

  <article class="portfolio-item pf-graphics pf-illustrations">
    <div class="portfolio-image">
      <div class="fslider" data-arrows="false">
        <div class="flexslider">
          <div class="slider-wrap">
            <div class="slide"><a href="portfolio-single-gallery.html"><img src="images/portfolio/4/mixed/6.jpg" alt="Shake It"></a></div>
            <div class="slide"><a href="portfolio-single-gallery.html"><img src="images/portfolio/4/mixed/6-1.jpg" alt="Shake It"></a></div>
            <div class="slide"><a href="portfolio-single-gallery.html"><img src="images/portfolio/4/mixed/6-2.jpg" alt="Shake It"></a></div>
            <div class="slide"><a href="portfolio-single-gallery.html"><img src="images/portfolio/4/mixed/6-3.jpg" alt="Shake It"></a></div>
          </div>
        </div>
      </div>
      <div class="portfolio-overlay" data-lightbox="gallery">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single-gallery.html">Shake It!</a></h3>
          <span><a href="#">Illustrations</a>, <a href="#">Graphics</a></span>
        </div>
        <a href="images/portfolio/full/6.jpg" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-stack-2"></i></a>
        <a href="images/portfolio/full/6-1.jpg" class="hidden" data-lightbox="gallery-item"></a>
        <a href="images/portfolio/full/6-2.jpg" class="hidden" data-lightbox="gallery-item"></a>
        <a href="images/portfolio/full/6-3.jpg" class="hidden" data-lightbox="gallery-item"></a>
        <a href="portfolio-single-gallery.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article>

  <article class="portfolio-item pf-uielements pf-icons">
    <div class="portfolio-image">
      <a href="portfolio-single-video.html">
        <img src="images/portfolio/4/mixed/7.jpg" alt="Backpack Contents">
      </a>
      <div class="portfolio-overlay">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single-video.html">Backpack Contents</a></h3>
          <span><a href="#">UI Elements</a>, <a href="#">Icons</a></span>
        </div>
        <a href="http://www.youtube.com/watch?v=kuceVNBTJio" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
        <a href="portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article>

  <article class="portfolio-item pf-graphics">
    <div class="portfolio-image">
      <a href="portfolio-single.html">
        <img src="images/portfolio/4/mixed/8.jpg" alt="Sunset Bulb Glow">
      </a>
      <div class="portfolio-overlay">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single.html">Sunset Bulb Glow</a></h3>
          <span><a href="#">Graphics</a></span>
        </div>
        <a href="images/portfolio/full/8.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
        <a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article>

  <article class="portfolio-item pf-illustrations pf-icons wide">
    <div class="portfolio-image">
      <div class="fslider" data-arrows="false" data-speed="650" data-pause="3500" data-animation="fade">
        <div class="flexslider">
          <div class="slider-wrap">
            <div class="slide"><a href="portfolio-single-gallery.html"><img src="images/portfolio/4/mixed/9.jpg" alt="Bridge Side"></a></div>
            <div class="slide"><a href="portfolio-single-gallery.html"><img src="images/portfolio/4/mixed/9-1.jpg" alt="Bridge Side"></a></div>
            <div class="slide"><a href="portfolio-single-gallery.html"><img src="images/portfolio/4/mixed/9-2.jpg" alt="Bridge Side"></a></div>
          </div>
        </div>
      </div>
      <div class="portfolio-overlay" data-lightbox="gallery">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single.html">Bridge Side</a></h3>
          <span><a href="#">Illustrations</a>, <a href="#">Icons</a></span>
        </div>
        <a href="images/portfolio/full/9.jpg" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-stack-2"></i></a>
        <a href="images/portfolio/full/9-1.jpg" class="hidden" data-lightbox="gallery-item"></a>
        <a href="images/portfolio/full/9-2.jpg" class="hidden" data-lightbox="gallery-item"></a>
        <a href="portfolio-single-gallery.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article>

  <article class="portfolio-item pf-graphics pf-media pf-uielements">
    <div class="portfolio-image">
      <a href="portfolio-single-video.html">
        <img src="images/portfolio/4/mixed/10.jpg" alt="Study Table">
      </a>
      <div class="portfolio-overlay">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single-video.html">Study Table</a></h3>
          <span><a href="#">Graphics</a>, <a href="#">Media</a></span>
        </div>
        <a href="http://vimeo.com/91973305" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
        <a href="portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article>

  <article class="portfolio-item pf-media pf-icons">
    <div class="portfolio-image">
      <a href="portfolio-single.html">
        <img src="images/portfolio/4/mixed/11.jpg" alt="Workspace Stuff">
      </a>
      <div class="portfolio-overlay">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single.html">Workspace Stuff</a></h3>
          <span><a href="#">Media</a>, <a href="#">Icons</a></span>
        </div>
        <a href="images/portfolio/full/11.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
        <a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article>

  <article class="portfolio-item pf-illustrations pf-graphics wide">
    <div class="portfolio-image">
      <a href="portfolio-single-gallery.html">
        <img src="images/portfolio/4/mixed/12.jpg" alt="Workspace Stuff">
      </a>
      <div class="portfolio-overlay" data-lightbox="gallery">
        <div class="portfolio-desc">
          <h3><a href="portfolio-single-gallery.html">Fixed Aperture</a></h3>
          <span><a href="#">Illustrations</a>, <a href="#">Graphics</a></span>
        </div>
        <a href="images/portfolio/full/12.jpg" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-stack-2"></i></a>
        <a href="images/portfolio/full/12-1.jpg" class="hidden" data-lightbox="gallery-item"></a>
        <a href="portfolio-single-gallery.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
      </div>
    </div>
  </article> -->

</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import { Rate,Image } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';
  import {setToken,getToken,showNotification} from "../../../lib/util.js"

  export default {
    name: 'product_article',
    data () {
      return {
        product:{
          article:{
            galleryimages:[]

          }
        }
      }
    },    
    components:{

    },
    mounted() {

      this.loadProductBySlug(this.$route.params.slug)
    },
    methods: {
      loadProductBySlug(slug){
          // const jwt_token=getToken("jwt_token")
          // console.log(jwt_token)
          // if (jwt_token !==undefined && jwt_token !==null){
          //     const cartitems=this.$store.state.lotteryshop.cart.cartitems

          //     console.log(cartitems)
          //     if(cartitems !==undefined && cartitems.length>1){
          //         console.log("cartitems existed")
          //         var itemIndex=cartitems.findIndex(cartitem=>cartitem.product.slug==slug)
          //         console.log(itemIndex)
          //         if (itemIndex>-1){
          //           this.quantity=cartitems[itemIndex].quantity
          //         }else{
          //           this.quantity=0
          //         }
          //     }else if(cartitems.length==1 && cartitems[0].product.slug==slug){
          //       this.quantity=cartitems[0].quantity
          //     }else{
          //       this.quantity=0
          //     }
          // }
          this.$store.dispatch("lotteryshop/getProductBySlug",slug).then(product=>{
            this.product=product
            console.log(this.product)
          },
            reject=>{})
      },
    },
    watch:{
      $route:{
        handler(to,from){
          // console.log(to.params.product_slug)
          if(to !==from){
              this.loadProductBySlug(to.params.product_slug)
          }

        }

      }
  }
};
</script>


<style lang="scss">

</style>