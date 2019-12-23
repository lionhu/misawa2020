<template>
  <div>
      <Gallery :images="product.medias" ></Gallery>
      <VueCtkDateTimePicker
          @input="PickDate"
          v-model="requestDate"
          :format="'YYYY-MM-DD'"
          formatted ="ll"
          color="#1ABC9C"
          no-label
          no-shortcuts
          range
          locale="ja_JP"
          :customer-shortcuts="shortcuts"
          :overlay="true"/>
  </div>

</template>
  
<script>
import moment from 'moment'
import Gallery from "./MoaGallery.vue"
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import 'bootstrap'; 
import 'bootstrap/dist/css/bootstrap.min.css';
export default {
  
  name: "Example",
  components: {
    Gallery,
    VueCtkDateTimePicker
  },
  data() {
    return {
      product:{},
      requestDate: '',
      shortcuts:[
        { key: 'thisWeek', label: 'This week', value: 'isoWeek' },
        { key: 'lastWeek', label: 'Last week', value: '-isoWeek' },
        { key: 'thisMonth', label: 'This month', value: 'month' },
        { key: 'lastMonth', label: 'Last month', value: '-month' },
        { key: 'thisYear', label: 'This year', value: 'year' }
      ],
    }
  },
  mounted(){

    if (this.$route.params.slug !="" || this.$route.params.slug !=undefined){
      this.loadProduct(this.$route.params.slug)
    }
  },
  computed:{

  },
  methods:{    
    PickDate(){
      const start = moment(this.requestDate.start).locale('ja')
      const end = start.add(7, 'days')
      this.requestDate.end = end;
    },
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