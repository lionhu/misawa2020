<template>

    <div class="product sf-dress clearfix">
      <div class="product-image">
        <a href="#"><img :src="product.avatar" :alt="product.name"></a>
        <!-- <a href="#"><img src="images/shop/dress/1-1.jpg" :alt="product.name"></a> -->
        <div class="sale-flash">50% Off*</div>
        <div class="product-overlay">
          <a href="javascript:void(0);" @click="addProductToCart(product.slug)">
            <i class="icon-shopping-cart"></i><span> Add 2 Cart</span>
          </a>

          <router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"><i class="icon-zoom-in2"></i></router-link>
        </div>
      </div>
      <div class="product-desc center">
        <div class="product-title"><h3><a href="#">{{product.name}}</a></h3></div>
        <div class="product-price"><del>$24.99</del> <ins>{{product.price|currency}}</ins></div>
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

  import {mapActions, mapState,mapGetters} from "vuex"

  import {setToken,getToken,showNotification} from "../../lib/util.js"
  // import Swal from 'sweetalert2'

  export default {
    name: 'product',
    props:["product"],

    data () {
      return {
        // ME:null,
      }
    },
  computed: {
  },
  mounted() {
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
                showNotification("add successfully!","success")
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