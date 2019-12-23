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
          :disabled-dates="disabledDates"
          locale="ja_JP"
          :customer-shortcuts="shortcuts"
          :overlay="true"/>
  </div>

</template>
  
<script>
import Moment from 'moment'
import { extendMoment } from 'moment-range';
const moment = extendMoment(Moment);

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
      disabledDates:[],
      rentalPeriods:[
        {start:"2019-12-03",end:"2019-12-06"},
        {start:"2019-12-08",end:"2019-12-12"},
        {start:"2019-12-16",end:"2019-12-20"},
      ]
    }
  },
  mounted(){
    if (this.$route.params.slug !="" || this.$route.params.slug !=undefined){
      this.loadProduct(this.$route.params.slug)
    }

    for(let i in this.rentalPeriods){
        var period = this.rentalPeriods[i]
        const start_date = moment(period.start)
        var end_date = moment(period.end)
        var days = end_date.diff(start_date,"days")
        for (var i =0; i <=days; i++) {
          var temp_date=moment(period.start).add(i,"days").format('YYYY-MM-DD')
          this.disabledDates.push(temp_date)
        }
    }
  },
  computed:{

  },
  methods:{    
    PickDate(e){
      console.log(e)
      if(this.requestDate.start !==null && this.requestDate.end !==null){
        const _range=moment.range(this.requestDate.start,this.requestDate.end)
        console.log(_range)

        const itemIndex= this.rentalPeriods.findIndex(period =>{
          var exist_range=moment.range(period.start,period.end)
          if(_range.overlaps(exist_range) || _range.intersect(exist_range)){
            return true
          }
        })

        if(itemIndex > -1){
          this.requestDate.start=this.requestDate.end;
          this.requestDate.end=null
        }
      }
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