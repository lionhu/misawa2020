<template>
<div>
  <article class="portfolio-item pf-media pf-icons" v-if="product.article.mediatype=='standard'">
    <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
    <div class="portfolio-image">
        <img :src="product.thumbimage" :alt="product.name">
      <div class="portfolio-overlay">
        <a :href="product.avatar" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
        <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon"><i class="icon-shopping-cart"></i></a>
      </div>
    </div>
    <div class="portfolio-desc">
      <h3><a href="portfolio-single-gallery.html">{{product.name}}</a></h3>
      <span>{{product.subtitle}}</span>
    </div>
  </article>

  <article class="portfolio-item pf-icons pf-illustrations" v-if="product.article.mediatype=='gallery'">
    <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
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
      <h3><a href="portfolio-single-gallery.html">{{product.name}}</a></h3>
      <span>{{product.subtitle}}</span>
    </div>
  </article>


  <article class="portfolio-item pf-graphics pf-uielements" v-if="product.article.mediatype=='video'">
    <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
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
        <h3><a href="portfolio-single-gallery.html">{{product.name}}</a></h3>
        <span>{{product.subtitle}}</span>
    </div>
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
      }
    }
};
</script>

<style lang="scss">
</style>