<template>
<div class="container clearfix">

  <div class="postcontent nobottommargin col_last">
    

    <div class="row grid-container" data-layout="masonry" style="overflow: visible">
        <Article v-for="product in catalogue_products" :product="product" :key="product.slug"></Article>
    </div>

  </div>

  <div class="sidebar nobottommargin">
    <div class="sidebar-widgets-wrap">

      <div class="widget widget-filter-links clearfix">

        <h4>Select Category</h4>
        <ul class="custom-filter" data-container="#shop" data-active-class="active-filter">
          <li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
          <li v-for="item in subcatalogues_now">
            <a href="#" data-filter=".sf-dress">{{item.name}}</a>
            <span>{{item.product_num}}</span>
          </li>
        </ul>

      </div>

    </div>
  </div>

</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import Product from "./Product.vue"
  import Article from "./parts/Article.vue"

  export default {
    name: 'productlist',
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
    },
    subcatalogues_now:function(){
      const catalogue = this.$store.state.lotteryshop.catalogue_now
      return catalogue.subcatalogues
    },
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
      '$route' (to, from) {
          console.log("watch route222")
          const to_id=to.params.catalogue_id
          const from_id =from.params.catalogue_id
          if(from_id !== to_id){
            this.loadCatalogueProducts(to_id)
          }
      }
  }
};
</script>

<style lang="scss">
</style>