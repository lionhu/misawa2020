<template>
<div class="container clearfix">

  <!-- Portfolio Filter
  ============================================= -->
  <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio" hidden>

    <li class="activeFilter"><a href="#" data-filter="*">Show All</a></li>
    <li><a href="#" data-filter=".pf-icons">Icons</a></li>
    <li><a href="#" data-filter=".pf-illustrations">Illustrations</a></li>
    <li><a href="#" data-filter=".pf-uielements">UI Elements</a></li>
    <li><a href="#" data-filter=".pf-media">Media</a></li>
    <li><a href="#" data-filter=".pf-graphics">Graphics</a></li>

  </ul><!-- #portfolio-filter end -->

  <div id="portfolio-shuffle" class="portfolio-shuffle" data-container="#portfolio" hidden="">
    <i class="icon-random"></i>
  </div>

  <div class="clear"></div>

  <!-- Portfolio Items
  ============================================= -->
  <div id="portfolio" class="portfolio grid-container portfolio-nomargin clearfix">

    <Article v-for="product in catalogue_products" :product="product" :key="product.slug"></Article>

  </div><!-- #portfolio end -->
  <!-- Sidebar
  ============================================= -->
  <div class="sidebar nobottommargin">
    <div class="sidebar-widgets-wrap">

      <div class="widget widget-filter-links clearfix">

        <h4>Select Category</h4>
        <ul class="custom-filter" data-container="#shop" data-active-class="active-filter">
          <li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
          <li><a href="#" data-filter=".sf-dress">Dress</a><span>3</span></li>
          <li><a href="#" data-filter=".sf-tshirt">Tshirts</a><span>2</span></li>
          <li><a href="#" data-filter=".sf-pant">Pants</a><span>2</span></li>
          <li><a href="#" data-filter=".sf-sunglass">Sunglasses</a><span>2</span></li>
          <li><a href="#" data-filter=".sf-shoes">Shoes</a><span>2</span></li>
          <li><a href="#" data-filter=".sf-watch">Watches</a><span>1</span></li>
        </ul>

      </div>

      <div class="widget widget-filter-links clearfix">

        <h4>Sort By</h4>
        <ul class="shop-sorting">
          <li class="widget-filter-reset active-filter"><a href="#" data-sort-by="original-order">Clear</a></li>
          <li><a href="#" data-sort-by="name">Name</a></li>
          <li><a href="#" data-sort-by="price_lh">Price: Low to High</a></li>
          <li><a href="#" data-sort-by="price_hl">Price: High to Low</a></li>
        </ul>

      </div>

    </div>
  </div><!-- .sidebar end -->

</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import Product from "./Product.vue"
  import Article from "./parts/Article.vue"

  export default {
    name: 'neworder',
    components:{
      Product,
      Article
    },
    inject:["reload"],
    data () {
      return {
        ME:null,

      }
    },
  computed: {
    catalogue_products:function(){
      return this.$store.state.lotteryshop.catalogue_products
    }
  },
    mounted() {
      this.loadCatalogueProducts(this.$route.params.catalogue_id)
    },
    methods: {
      loadCatalogueProducts(catalogue_id){
        this.$store.dispatch("lotteryshop/fetchCatalogueProducts",catalogue_id)
      }
    },
    watch: {
        $route: {
          handler(to, from) {
            console.log(from)
            console.log(to)
            const to_id=to.params.catalogue_id
            const from_id =from.params.catalogue_id
            if(from_id !== to_id){
              this.loadCatalogueProducts(to_id)
            }
            window.location.reload()
          },
          deep: true
    }  
  }
};
</script>

<style lang="scss">
</style>