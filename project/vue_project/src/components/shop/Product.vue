<template>

    <div class="product sf-dress clearfix">
      <div class="product-image">
        <a href="javascript:void(0);"><img :src="product.thumbimage" :alt="product.name"></a>
        <a href="javascript:void(0);">
          <img :src="product.images[0].thumbimage" :alt="product.name">
        </a>
        <div class="sale-flash">50% Off*</div>
        <div class="product-overlay">
          <a href="javascript:void(0);" @click="addProductToCart(product.slug)">
            <i class="icon-shopping-cart"></i><span> Add 2 Cart</span>
          </a>

          <router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"><i class="icon-zoom-in2"></i></router-link>
        </div>
      </div>
      <div class="product-desc center">
        <div class="product-title"><h3><a href="javascript:void(0);">{{product.name}}</a></h3></div>
        <div class="product-price"><del>{{product.open_price|currency_jpy}}</del> <ins>{{product.price|currency_jpy}}</ins></div>
        <el-rate
          v-model="value"
          disabled
          text-color="#ff9900"
          score-template="{value}">
        </el-rate>
      </div>

    </div>

</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"

  import { Rate } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';
  import {setToken,getToken,showNotification} from "../../lib/util.js"


  export default {
    name: 'product',
    props:["product"],

    data () {
      return {
        value:0
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