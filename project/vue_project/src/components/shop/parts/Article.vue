<template>
<div>

<!--           <article class="portfolio-item pf-media pf-icons wide"  v-if="product.article.mediatype=='standard'">
            <div class="portfolio-image">
              <router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">
                <img :src="product.thumbimage" alt="Open Imagination">
              </router-link>
              <div class="portfolio-overlay">
                <div class="sale-flash soldout" v-if="product.stock==0">Sold Out!</div>
                <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
                <div class="portfolio-desc">
                  <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
                  <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
                </div>
                <a :href="product.avatar" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon" ><i class="icon-shopping-cart"></i></a>
              </div>
            </div>
          </article>



          <article class="portfolio-item pf-icons pf-illustrations wide"  v-if="product.article.mediatype=='gallery'">
            <div class="portfolio-image">
              <div class="fslider" data-arrows="false" data-speed="400" data-pause="4000">
                <div class="flexslider">
                  <div class="slider-wrap">
                    <div class="slide" v-for="_image in product.article.galleryimages">
                      <router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">
                        <img :src="_image.thumbimage" :alt="product.name">
                      </router-link>
                    </div>
                  </div>
                </div>
              </div>
              <div class="portfolio-overlay" data-lightbox="gallery">
                <div class="sale-flash soldout" v-if="product.stock==0">Sold Out!</div>
                <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>

                <a :href="_image.postimage" v-bind:class="{'left-icon':_image.memo=='show','hidden':_image.memo=='hidden'}"  data-lightbox="gallery-item" v-for="_image in product.article.galleryimages"><i class="icon-line-stack-2"></i></a>
                <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon"  ><i class="icon-shopping-cart"></i></a>
              </div>
            </div>
            <div class="portfolio-desc">
              <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
              <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
            </div>
          </article>





          <article class="portfolio-item pf-graphics pf-media pf-uielements"  v-if="product.article.mediatype=='video'">
            <div class="portfolio-image">
              <router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">
                <img :src="product.thumbimage" :alt="product.name">
              </router-link>
              <div class="portfolio-overlay">
                <div class="sale-flash soldout" v-if="product.stock==0">Sold Out!</div>
                <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
                <div class="portfolio-desc">
                  <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
                  <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
                </div>
                <a :href="product.article.video_url" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
                <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon" ><i class="icon-shopping-cart"></i></a>
              </div>
            </div>
          </article> -->

  <article class="portfolio-item pf-media pf-icons" data-loader="include/ajax/portfolio-ajax-image.php" v-if="product.article.mediatype=='standard'">
    <div class="ribbon ribbon-bookmark bg-secondary" v-if="product.hasGroupon">
      <a href="javascript:void(0);" @click="GrouponME(product.grouponSlug)"><i class="fas fa-bullhorn"></i></a>
    </div>
    <div class="portfolio-image">
        <img :src="product.thumbimage" :alt="product.name">
        <div class="portfolio-overlay">
          <a :href="product.avatar" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
          <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon"><i class="icon-shopping-cart"></i></a>
        </div>
    </div>
    <div class="portfolio-desc">
        <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
        <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
    </div>  
    <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
  </article>



  <article class="portfolio-item pf-icons pf-illustrations"  data-loader="include/ajax/portfolio-ajax-gallery.php" v-if="product.article.mediatype=='gallery'">
    <div class="ribbon ribbon-bookmark bg-secondary" v-if="product.hasGroupon">
      <a href="javascript:void(0);" @click="GrouponME(product.grouponSlug)"><i class="fas fa-bullhorn"></i></a>
    </div>
    <div class="portfolio-image">
      <div class="fslider" data-arrows="false" data-speed="400" data-pause="4000">
        <div class="flexslider">
          <div class="slider-wrap">
            <div class="slide" v-for="_image in product.article.galleryimages">
              <a href="portfolio-single-gallery.html">
                <img :src="_image.thumbimage" :alt="product.name">
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="portfolio-overlay" data-lightbox="gallery">
        <a :href="_image.postimage" class="left-icon" :class="_image.memo" data-lightbox="gallery-item" v-for="_image in product.article.galleryimages"><i class="icon-line-stack-2"></i></a>
        <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon"><i class="icon-shopping-cart"></i></a>
      </div>
    </div>
    <div class="portfolio-desc">
        <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
        <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
    </div>    
    <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
  </article>


  <article class="portfolio-item pf-graphics pf-uielements"  data-loader="include/ajax/portfolio-ajax-video.php"  v-if="product.article.mediatype=='video'">
    <div class="ribbon ribbon-bookmark bg-secondary" v-if="product.hasGroupon">
      <a href="javascript:void(0);" @click="GrouponME(product.grouponSlug)"><i class="fas fa-bullhorn"></i></a>
    </div>
    <div class="portfolio-image">
      <a href="#">
        <img :src="product.thumbimage" :alt="product.name">
      </a>
      <div class="portfolio-overlay">
        <a :href="product.article.video_url" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
        <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon"><i class="icon-shopping-cart"></i></a>
      </div>
    </div>
    <div class="portfolio-desc">
        <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
        <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
    </div>    
    <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
  </article>


</div>


</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"

  import { Rate,Dialog,Button } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';
  import {setToken,getToken,showNotification} from "../../../lib/util.js"


  export default {
    name: 'product',
    props:["product"],
    components:{
      Dialog,Rate,Button
    },
    data () {
      return {
        value:0,
        centerDialogVisible:false
      }
    },    
    components:{
      elRate:Rate
    },
    mounted() {
      this.value=this.product.ranks
    },
    methods: {
      addProductToCart(slug){
        const jwt_token=getToken("jwt_token")

        if (jwt_token !==undefined && jwt_token !==null){
          const params={
            product_slug:slug,
            quantity:1
          }
          let jwt_token=getToken("jwt_token")
          this.$store.dispatch("lotteryshop/addToCart",params).then(
            resolve=>{
                  showNotification(this.$t("m.add2cart"),"success")
            },reject=>{})
        }else{
          showNotification("You have to login!","warning")
        }
      },
      GrouponME(grouponSlug){
        console.log(grouponSlug)
      }
    }
};
</script>

<style lang="scss">
.soldout{
  background-color:red;
  color:white-space
}
</style>