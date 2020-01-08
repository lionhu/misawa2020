<template>
  <div class="container clearfix">
    <div class="col_half col_last">
      <Gallery :images="product.medias" v-if="product.medias !=undefined && product.medias.length"></Gallery>
      <div class="productimage text-center">
          <img :src="product.avatar" v-if="product.medias !=undefined && product.medias.length ==0">
      </div>
      <section class="rental topmargin-lg" v-if="product.rentalproducts !=undefined && product.rentalproducts.length">
          <div class="fancy-title title-dotted-border title-center">
            <h3>レンタル </h3>
          </div>
          <div class="pricing-box pricing-extended bottommargin clearfix" >

            <div class="style-msg2 errormsg text-center"  v-if="!canRelease">
              <div class="msgtitle">Already Releasing:</div>
              <div class="sb-msg">
                <h4>Status: {{myrentalhistory.status}}</h4>
                <ul style="list-style-type:none;">
                  <li>Start At: {{myrentalhistory.start_at | StandardDate }}</li>
                  <li>End At: {{myrentalhistory.end_at | StandardDate}}</li>
                </ul>
              </div>
            </div>

              <div class="pricing-desc" v-if="rentalfee && canRelease">
                <div class="pricing-title">
                  <h5>送付先情報：</h5>
                </div>
                <div class="pricing-features topmargin-sm">
                  <div class="col_full">

                    <div class="col_full bottommargin-sm">
                      <input type="text" id="shipping-form-email" name="shipping-form-email" value="" class="sm-form-control bg-color text-white" data-vv-as="Email" v-validate="'required|email'" :class="{'input': true, 'form-danger': errors.has('shipping-form-email') }" :placeholder="$t('m.shop_email')" v-model="address.email" @blur="CheckExistedCustomer"/>
                      <div class="form-control-feedback" v-show="errors.has('shipping-form-email')">
                        <p class="alert alert-danger">{{ errors.first('shipping-form-email') }}</p>
                      </div>
                    </div>

                    <div class="col_half bottommargin-sm">
                      <input type="text" id="shipping-form-phone" name="shipping-form-phone" value="" class="sm-form-control bg-color text-white" data-vv-as="Phone" v-validate="'required|min:6'" :class="{'input': true, 'form-danger': errors.has('shipping-form-phone') }" :placeholder="$t('m.shop_phone')"  v-model="address.phone"  @blur="CheckExistedCustomer"/>
                      <div class="form-control-feedback" v-show="errors.has('shipping-form-phone')">
                        <p class="alert alert-danger">{{ errors.first('shipping-form-phone') }}</p>
                      </div>
                    </div>
                    <div class="clear"></div>

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
                        <p class="alert alert-danger">{{ errors.first('shipping-form-city') }}</p>
                      </div>
                    </div>
                    <div class="clear"></div>
                    <div class="col_full bottommargin-sm">
                      <input type="text" id="shipping-form-address1" name="shipping-form-address1" value="" class="sm-form-control" data-vv-as="Address" v-validate="'required|min:3'" :class="{'input': true, 'form-danger': errors.has('shipping-form-address1') }"   :placeholder="$t('m.shop_address')"   v-model="address.street_address1" />
                      <div class="form-control-feedback" v-show="errors.has('shipping-form-address1')">
                        <p class="alert alert-danger">{{ errors.first('shipping-form-address1') }}</p>
                      </div>
                    </div>
                    <div class="col_full bottommargin-sm">
                      <input type="text" id="shipping-form-address2" name="shipping-form-address2" class="sm-form-control"  data-vv-as="Address" v-model="address.street_address2"  v-validate="'required|min:3'" value="..." :placeholder="$t('m.shop_address2')" />
                      <div class="form-control-feedback" v-show="errors.has('shipping-form-address2')">
                        <p class="alert alert-danger">{{ errors.first('shipping-form-address2') }}</p>
                      </div>
                    </div>
                    <div class="col_full bottommargin-sm">
                      <label for="shipping-form-message">{{$t("m.note")}} <small>*</small></label>
                      <textarea class="sm-form-control" id="shipping-form-message" name="shipping-form-message" rows="6" cols="30" v-model="note"></textarea>
                    </div>

                    <div class="pricing-action">
                      <a href="javascript:void(0);" class="button button-3d button-xlarge btn-block nomargin text-white" @click="ProcessLease">Get Started</a>
                    </div>
                  </div>
                </div>
              </div>


              <div class="pricing-action-area"  v-if="canRelease" >
                <el-radio-group v-model="rentalproduct_sn" size="small" @change="SwitchRentalProduct">
                    <el-radio-button :label="'('+parseInt(i+1)+') '+rentalproduct.sn" v-for="rentalproduct,i in product.rentalproducts" :key="i"></el-radio-button>
                </el-radio-group>
                <VueCtkDateTimePicker @input="PickDate" class = "topmargin-sm" v-model="requestDate" :format="'YYYY-MM-DD'" formatted ="ll" color="#1ABC9C" no-label no-shortcuts range :disabled-dates="disabledDates" locale="ja_JP" :overlay="true">
                </VueCtkDateTimePicker>

                <div class="pricing-price color topmargin-sm">
                    <span class="price-unit">¥</span>{{rentalfee}}
                    <span class="price-tenure">rental Fee for <strong>{{rentalproduct_sn}}</strong></span>
                </div>
                <div class="pricing-features">
                    <ul class="clearfix">
                      <li><span>Days:</span>  {{duration}}</li>
                      <li><span>Rank:</span> {{selectedRentalProduct.rank.name}}</li>
                    </ul>
                </div>
              </div>
          </div>
      </section>
    </div>
    <div class="col_half">
      

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
import {StandardDate,showNotification,FetchAddressByPostcode,utf16to8} from "../../../lib/util.js"

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
        first_name:"HU",
        last_name:"Haiguang",
        postcode:"3360031",
        state:"埼玉県",
        city:"さいたま市",
        email:"huhaiguang@me.com",
        street_address1:"鹿手袋7−19−１７",
        street_address2:"...",
        phone:"13816321110"
      },
      existedAddress:false,
      existedAddressID:0,
      note:"",
      canRelease:false
    }
  },
  mounted(){
    if (this.$route.params.slug !="" || this.$route.params.slug !=undefined){
      this.loadProduct(this.$route.params.slug)
    }

  },
  computed:{
    // canRelease(){
    //   console.log(this.myrentalhistories != undefined)
    //   if (this.myrentalhistories != undefined){
    //     return false
    //   }
    //   var myrentalhistories = this.$store.state.users.ME.rentalhistories;
    //   var itemIndex = myrentalhistories.findIndex(rentalproduct => rentalproduct.product_slug == this.$route.params.slug)
    //   this.myrentalhistory = myrentalhistories[itemIndex]

    //   return itemIndex>-1?false:true;

    // },
    duration(){
      if (this.requestDate.start !=undefined && this.requestDate.end !=undefined){
          var start_date = moment(this.requestDate.start)
          var end_date = moment(this.requestDate.end)
          return  end_date.diff(start_date,"days")+1                                         
      }else{
        return 0;
      }

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
    CheckExistedCustomer(){
        if(this.address.phone !=="" && this.address.email){
            axios.post('/api/address/CheckExistedCustomer/',{
                phone:this.address.phone,
                email:this.address.email
            }).then((res)=>{
                if(res.data.result){
                    this.address = res.data.address;
                    this.existedAddress = true;
                    this.existedAddressID = res.data.address.id;
                }
            },reject=>{
                console.log("no existed address matched!")
            })
        }
    },
    ProcessLease(){
      this.$validator.validateAll().then((result)=>{
        if(result){
               const params={
                  address:this.address,
                  existedAddressID:this.existedAddress ? this.existedAddressID:0,
                  product_slug: this.product.slug,
                  rentalproduct_id: this.selectedRentalProduct.id,
                  requestDate:this.requestDate,
                  start_at: this.requestDate.start+"T00:00:00",
                  end_at: this.requestDate.end+"T23:59:59",
                  days: this.duration,
                  rentalfee: this.rentalfee,
                  memo: this.note
               }
               axios.post('/api/rental/',params).then((res)=>{
                               if(res.data.result){
                                  console.log(res.data)
                                  this.myrentalhistory={
                                    start_at: res.data.rentalhistory.start_at,
                                    end_at: res.data.rentalhistory.end_at,
                                    status: res.data.rentalhistory.status,
                                    product_slug: this.product.slug
                                  }
                                  this.canRelease = false;
                               }
                           },reject=>{
                                console.log(reject)
                            })
        }
      })
    },
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

                    var myrentalhistories = this.$store.state.users.ME.rentalhistories;
                    var itemIndex = myrentalhistories.findIndex(rentalproduct => rentalproduct.product_slug == this.$route.params.slug)
                    if(itemIndex > -1){
                        this.myrentalhistory = myrentalhistories[itemIndex]
                        this.canRelease = false;
                    }else{
                        this.myrentalhistory = {}
                        this.canRelease = true;
                    }

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
      var history = data.history
      var rentalproduct_slug = data.rentalproduct_slug
      var itemIndex = this.product.rentalproducts.findIndex(rProduct => rProduct.slug == data.rentalproduct_slug)

      if(itemIndex>-1){
        this.product.rentalproducts[itemIndex].histories.push(history)
        this.prepare_rentalCalendar()
        console.log(this.$store.state.users.ME)
        if (this.$store.state.users.ME.email == data.history.user_email){
            this.myrentalhistory={
                start_at: data.history.start_at,
                end_at: data.history.end_at,
                status: data.history.status,
                product_slug: data.product_slug
            }
            this.canRelease = false;
        }

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