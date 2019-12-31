<template>
  <div>
    <Gallery :images="product.medias" ></Gallery>
    <div class="fancy-title title-dotted-border title-center">
      <h3>Pricing Block</h3>
    </div>
    <div class="pricing-box pricing-extended bottommargin clearfix">

      <div class="pricing-desc" v-if="rentalfee">
        <div class="pricing-title">
          <h5>Select Rental Product & Period</h5>
        </div>
        <div class="pricing-features topmargin-sm">
          <div class="col_full">
            <div class="col_half bottommargin-sm">
              <input type="text" id="shipping-form-name" name="shipping-form-name" value="" class="sm-form-control" data-vv-as="First Name" v-validate="'required'" :class="{'input': true, 'form-danger': errors.has('shipping-form-name') }" :placeholder="$t('m.first_name')" v-model="address.first_name" />
              <div class="form-control-feedback" v-show="errors.has('shipping-form-name')">
                <p class="alert alert-danger">{{ errors.first('shipping-form-name') }}</p>
              </div>
            </div>

            <div class="col_half col_last bottommargin-sm">
              <input type="text" id="shipping-form-lname" name="shipping-form-lname" value="" class="sm-form-control" data-vv-as="Last Name" v-validate="'required'" :class="{'input': true, 'form-danger': errors.has('shipping-form-lname') }" :placeholder="$t('m.last_name')" v-model="address.last_name" />
              <div class="form-control-feedback" v-show="errors.has('shipping-form-lname')">
                <p class="alert alert-danger">{{ errors.first('shipping-form-lname') }}</p>
              </div>
            </div>

            <div class="clear"></div>
            <div class="col_full bottommargin-sm">
              <input type="text" id="shipping-form-email" name="shipping-form-email" value="" class="sm-form-control" data-vv-as="Email" v-validate="'required|email'" :class="{'input': true, 'form-danger': errors.has('shipping-form-email') }" :placeholder="$t('m.shop_email')" v-model="address.email" />
              <div class="form-control-feedback" v-show="errors.has('shipping-form-email')">
                <p class="alert alert-danger">{{ errors.first('shipping-form-email') }}</p>
              </div>
            </div>

            <div class="col_half bottommargin-sm">
              <input type="text" id="shipping-form-phone" name="shipping-form-phone" value="" class="sm-form-control" data-vv-as="Phone" v-validate="'required|min:6'" :class="{'input': true, 'form-danger': errors.has('shipping-form-phone') }" :placeholder="$t('m.shop_phone')"  v-model="address.phone" />
              <div class="form-control-feedback" v-show="errors.has('shipping-form-phone')">
                <p class="alert alert-danger">{{ errors.first('shipping-form-phone') }}</p>
              </div>
            </div>
            <div class="clear"></div>
            <div class="col_half bottommargin-sm">
              <input type="text" id="shipping-form-postcode" name="shipping-form-postcode" value="" class="sm-form-control" data-vv-as="PostCode" v-validate="'required|min:4'" :class="{'input': true, 'form-danger': errors.has('shipping-form-postcode') }" v-model="address.postcode" :placeholder="$t('m.shop_postcode')"   @blur="getAddressFromPostcode" />
              <div class="form-control-feedback" v-show="errors.has('shipping-form-postcode')">
                <p class="alert alert-danger">{{ errors.first('shipping-form-postcode') }}</p>
              </div>
            </div>
            <div class="clear"></div>
            <div class="col_half bottommargin-sm">
              <input type="text" id="shipping-form-state" name="shipping-form-state" value="" class="sm-form-control" data-vv-as="State / City" v-validate="'required|min:3'" :class="{'input': true, 'form-danger': errors.has('shipping-form-state') }"  :placeholder="$t('m.state')"  v-model="address.state" />
              <div class="form-control-feedback" v-show="errors.has('shipping-form-state')">
                <p class="alert alert-danger">{{ errors.first('shipping-form-state') }}</p>
              </div>
            </div>
            <div class="col_half col_last bottommargin-sm">
              <input type="text" id="shipping-form-city" name="shipping-form-city" value="" class="sm-form-control" data-vv-as="Town" v-validate="'required|min:3'" :class="{'input': true, 'form-danger': errors.has('shipping-form-city') }"   :placeholder="$t('m.town')"   v-model="address.city" />
              <div class="form-control-feedback" v-show="errors.has('shipping-form-city')">
                <p class="alert alert-danger">{{ errors.first('shipping-form-address') }}</p>
              </div>
            </div>
            <div class="clear"></div>
            <div class="col_full bottommargin-sm">
              <input type="text" id="shipping-form-address" name="shipping-form-address" value="" class="sm-form-control" data-vv-as="Address" v-validate="'required|min:3'" :class="{'input': true, 'form-danger': errors.has('shipping-form-address') }"   :placeholder="$t('m.shop_address')"   v-model="address.street_address1" />
              <div class="form-control-feedback" v-show="errors.has('shipping-form-address')">
                <p class="alert alert-danger">{{ errors.first('shipping-form-address') }}</p>
              </div>
            </div>
            <div class="col_full bottommargin-sm">
              <input type="text" id="shipping-form-address2" name="shipping-form-adress2" value="" class="sm-form-control" v-model="address.street_address2" :placeholder="$t('m.shop_address2')" />
            </div>
            <div class="col_full bottommargin-sm">
              <label for="shipping-form-message">{{$t("m.note")}} <small>*</small></label>
              <textarea class="sm-form-control" id="shipping-form-message" name="shipping-form-message" rows="6" cols="30" v-model="address.note"></textarea>
            </div>

            <div class="pricing-action">
              <a href="#" class="button button-3d button-xlarge btn-block nomargin">Get Started</a>
            </div>
          </div>

        </div>
      </div>


      <div class="pricing-action-area">
          <el-radio-group v-model="rentalproduct_sn" size="small" @change="SwitchRentalProduct">
            <el-radio-button :label="'('+parseInt(i+1)+') '+rentalproduct.sn" v-for="rentalproduct,i in product.rentalproducts" :key="i"></el-radio-button>
          </el-radio-group>
          <VueCtkDateTimePicker 
          @input="PickDate"
          class = "topmargin-sm"
          v-model="requestDate"
          :format="'YYYY-MM-DD'"
          formatted ="ll"
          color="#1ABC9C"
          no-label
          no-shortcuts
          range
          :disabled-dates="disabledDates"
          locale="ja_JP"
          :overlay="true" v-if="canRelease">
        </VueCtkDateTimePicker>
        <div class="style-msg2 errormsg"  v-if="!canRelease">
          <div class="msgtitle">Already Releasing:</div>
          <div class="sb-msg">
            <h4>Status: {{myrentalhistory.status}}</h4>
            <ul>
              <li>Start At: {{myrentalhistory.start_at}}</li>
              <li>End At: {{myrentalhistory.end_at}}</li>
            </ul>
          </div>
        </div>

<!--         <div style="text-align:center;margin-top:10px;">
          <a href="javascript:void(0);" class="button button-large button-rounded" style="border-radius: 23px;">{{rentalproduct_sn}}</a>
        </div> -->
        
      <!-- <div class="divider divider-rounded divider-center"><i class="icon-map-marker"></i></div> -->

      <div class="pricing-price color topmargin-sm">
        <span class="price-unit">¥</span>{{rentalfee}}<span class="price-tenure">rental Fee for {{rentalproduct_sn}}</span>
      </div>
      <div class="pricing-features">
        <ul class="clearfix">
          <li><span>Days:</span>  {{duration}}</li>
          <li><span>Rank:</span> {{selectedRentalProduct.rank.name}}</li>
        </ul>
      </div>

    </div>


  </div>
  <RentalProductAlarm :product_slug="product.slug" @rentalhistory="eventRentalHistory"></RentalProductAlarm>
</div>

</template>
  
<script>
import Moment from 'moment'
import { extendMoment } from 'moment-range';
const moment = extendMoment(Moment);

import RentalProductAlarm from "./websocks/RentalEvent.vue"

  import { Radio,RadioGroup,RadioButton } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';

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
    RentalProductAlarm,
    elRadio:Radio,
    elRadioButton:RadioButton,
    elRadioGroup:RadioGroup
  },
  data() {
    return {
      product:{},
      requestDate: {},
      disabledDates:[],
      rentalPeriods:[],
      rentalproduct_sn:"",
      selectedRentalProduct:{
        rank:{
          price:0
        }
      },
      myrentalhistory:{},
      address:{
        first_name:"",
        last_name:"",
        postcode:"",
        state:"",
        city:"",
        email:"",
        street_address1:"",
        street_address2:"",
        phone:"",
        note:""
      },
    }
  },
  mounted(){
    if (this.$route.params.slug !="" || this.$route.params.slug !=undefined){
      this.loadProduct(this.$route.params.slug)
    }
  },
  computed:{
    canRelease(){
      var myrentalhistories = this.$store.state.users.ME.rentalhistories;
      var itemIndex = myrentalhistories.findIndex(rentalproduct => rentalproduct.product_slug == this.$route.params.slug)
      this.myrentalhistory = myrentalhistories[itemIndex]

      return itemIndex>-1?false:true;

    },
    duration(){
      var start_date = moment(this.requestDate.start)
      var end_date = moment(this.requestDate.end)
      return  end_date.diff(start_date,"days")
    },
    rentalfee(){
      if (this.selectedRentalProduct !=undefined){
        return  this.selectedRentalProduct.rank.price * this.duration
      }else{
        return 0;
      }
    }
  },
  methods:{    
    SwitchRentalProduct(e){
      this.requestDate={}
      this.rentalproduct_sn=e.split(" ")[1];
      this.prepare_rentalCalendar()
    },
    PickDate(){
      if(this.requestDate.start !==null && this.requestDate.end !==null){
        const _range=moment.range(this.requestDate.start,this.requestDate.end)
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
      this.rentalPeriods = [];
      this.disabledDates = [];
      var vm = this;
      var rentalproductIndex = this.product.rentalproducts.findIndex(r_product => r_product.sn ==vm.rentalproduct_sn)

      if (rentalproductIndex > -1){
       this.selectedRentalProduct=this.product.rentalproducts[rentalproductIndex]
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
    },
    getAddressFromPostcode(){
      if(this.address.postcode.length>3){
        FetchAddressByPostcode(this.address.postcode).then(
          resolve=>{
              this.address.state=resolve.address.state
              this.address.city=resolve.address.city
              this.address.street_address1=resolve.address.street_address1
          },reject=>{
            showNotification(reject.message,"warning")
          })
      }
    },    
  }
};
</script> 
 
<style scoped>
#blueimp-gallery p .description{
  margin-top: 10px;
}

</style> 