<template>
  <Gallery :images="product.medias" ></Gallery>
</template>
  
<script>
import Gallery from "./MoaGallery.vue"
import 'bootstrap'; 
import 'bootstrap/dist/css/bootstrap.min.css';
export default {
  
  name: "Example",
  components: {
    Gallery
  },
  data() {
    return {
      product:{},
    };
  },
  mounted(){
    if (this.$route.params.slug !="" || this.$route.params.slug !=undefined){
      this.loadProduct(this.$route.params.slug)
    }
  },
  methods:{
    loadProduct(slug){
      var productIndex=this.$store.state.lotteryshop.catalogue_products.findIndex(product =>product.slug == slug)
      if(productIndex > -1){
        const findProduct=this.$store.state.lotteryshop.catalogue_products[productIndex]
        this.product=findProduct
      }
    }

  }
};
</script> 
 
<style scoped>
#blueimp-gallery p .description{
  margin-top: 10px;
}
</style> 