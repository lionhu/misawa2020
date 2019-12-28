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
          :overlay="true"/>
      <RentalProductAlarm :product_slug="product.slug" @rentalhistory="eventRentalHistory"></RentalProductAlarm>
  </div>

</template>
  
<script>
import Moment from 'moment'
import { extendMoment } from 'moment-range';
const moment = extendMoment(Moment);

import RentalProductAlarm from "./websocks/RentalEvent.vue"
import Gallery from "./MoaGallery.vue"
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import 'bootstrap'; 
import 'bootstrap/dist/css/bootstrap.min.css';
import {StandardDate} from "../../../lib/util.js"

export default {
  
  name: "ProductArticle",
  components: {
    Gallery,
    VueCtkDateTimePicker,
    RentalProductAlarm
  },
  data() {
    return {
      product:{},
      requestDate: '',
      disabledDates:[],
      rentalPeriods:[],
      rentalproduct_sn:""
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
    PickDate(e){
      console.log(e)
      if(this.requestDate.start !==null && this.requestDate.end !==null){
        const _range=moment.range(this.requestDate.start,this.requestDate.end)
        console.log(_range)

        const itemIndex= this.rentalPeriods.findIndex(period =>{
          var exist_range=moment.range(period.start_at,period.end_at)
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
      axios.get('/api/product/'+this.$route.params.slug+"/",).then((res)=>{
                // console.log(res.data.product.rentalproducts)
                if(res.data.result){
                  this.product = res.data.product
                  if (res.data.product.rentalproducts.length>0){
                    var first_rentalproduct=res.data.product.rentalproducts[0];
                    this.rentalproduct_sn=first_rentalproduct.sn
                    this.prepare_rentalCalendar()
                  }
                }
            }).catch(function(error){
                console.log(error)
            })
    },
    prepare_rentalCalendar(){
      var rentalproductIndex = this.product.rentalproducts.findIndex(r_product => r_product.sn = this.rentalproduct_sn)
      if (rentalproductIndex > -1){
        var _rentalPeriods = this.product.rentalproducts[rentalproductIndex].histories.map(history =>{
          history["start_at"]= StandardDate(history["start_at"])
          history["end_at"] = StandardDate(history["end_at"])
          return history
        })
        this.rentalPeriods = _rentalPeriods;

        if(this.rentalPeriods.length>0){
          for(let i in this.rentalPeriods){
                var period = this.rentalPeriods[i]
                const start_date = moment(period.start_at)
                var end_date = moment(period.end_at)
                var days = end_date.diff(start_date,"days")
                for (var i =0; i <=days; i++) {
                  var temp_date=moment(period.start_at).add(i,"days").format('YYYY-MM-DD')
                  this.disabledDates.push(temp_date)
                }
            }
        }
      }
    },
    eventRentalHistory(data){
      // console.log(data)
      var history = data.history
      var rentalproduct_slug = data.rentalproduct_slug
      var itemIndex = this.product.rentalproducts.findIndex(rProduct => rProduct.slug == data.rentalproduct_slug)

      // console.log(itemIndex)
      if(itemIndex>-1){
        this.product.rentalproducts[itemIndex].histories.push(history)
        this.prepare_rentalCalendar()
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