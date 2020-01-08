<template>
<div class="container clearfix">

  <div class="postcontent nobottommargin clearfix col_last">

    <div class="single-product">

      <div class="product">

        <div class="col_half">

          <!-- Product Single - Gallery
          ============================================= -->
          <div class="product-image">
            <Gallery :images="product.medias" v-if="product.medias !=undefined && product.medias.length"></Gallery>
            <div class="productimage text-center">
                <img :src="product.avatar" v-if="product.medias !=undefined && product.medias.length ==0">
            </div>
            <div class="sale-flash">Sale!</div>
          </div><!-- Product Single - Gallery End -->

        </div>

        <div class="col_half col_last product-desc">

          <!-- Product Single - Price
          ============================================= -->
          <div class="product-price"><ins>{{product.price | currency_jpy}}</ins></div><!-- Product Single - Price End -->

          <!-- Product Single - Rating
          ============================================= -->
          <div class="product-rating">
                    <el-rate v-model="product.ranks" disabled text-color="#ff9900" ></el-rate>
          </div><!-- Product Single - Rating End -->

          <div class="clear"></div>
          <div class="line"></div>

          <!-- Product Single - Quantity & Cart Button
          ============================================= -->
          <div class="cart nobottommargin clearfix" >
<!--             <div class="quantity clearfix">
              <a href="javascript:void(0)" class="button minus norightmargin nobgcolor" @click="num >=1 ? num--:0">-</a>
              <a href="javascript:void(0)" class="button qty norightmargin noleftmargin nobgcolor" v-model="num"> {{num}}</a>
              <a href="javascript:void(0)" class="button plus norightmargin nobgcolor" @click="num++">+</a>
            </div> -->
            <a class="add-to-cart button nomargin text-white" @click="addProductToCart(product.slug)" >Add to cart</a>
          </div><!-- Product Single - Quantity & Cart Button End -->

          <div class="clear"></div>
          <div class="line"></div>

          <!-- Product Single - Short Description
          ============================================= -->
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero velit id eaque ex quae laboriosam nulla optio doloribus! Perspiciatis, libero, neque, perferendis at nisi optio dolor!</p>
          <p>Perspiciatis ad eveniet ea quasi debitis quos laborum eum reprehenderit eaque explicabo assumenda rem modi.</p>
          <ul class="iconlist">
            <li><i class="icon-caret-right"></i> Dynamic Color Options</li>
            <li><i class="icon-caret-right"></i> Lots of Size Options</li>
            <li><i class="icon-caret-right"></i> 30-Day Return Policy</li>
          </ul><!-- Product Single - Short Description End -->

          <!-- Product Single - Meta
          ============================================= -->
          <div class="card product-meta">
            <div class="card-body">
              <span itemprop="productID" class="sku_wrapper">SKU: <span class="sku color">{{product.sku}}</span></span> <br>
              <span class="posted_in">Manufacturer: <span class="sku color">{{product.manufacturer}}</span>.</span>
            </div>
          </div><!-- Product Single - Meta End -->
        </div>

        <div class="col_full nobottommargin">

          <el-tabs type="border-card">
            <el-tab-pane>
              <span slot="label"><i class="el-icon-date"></i> 我的行程</span>
              我的行程
            </el-tab-pane>
            <el-tab-pane label="消息中心">消息中心</el-tab-pane>
            <el-tab-pane label="角色管理">角色管理</el-tab-pane>
            <el-tab-pane label="定时任务补偿">定时任务补偿</el-tab-pane>
          </el-tabs>

        </div>

      </div>

    </div>

    <div class="clear"></div><div class="line"></div>

  </div>

  <div class="sidebar nobottommargin clearfix">
    <div class="sidebar-widgets-wrap">

      <div class="widget widget_links clearfix">

        <h4>Shop Categories</h4>
        <ul>
          <li v-for=" subcatalogue in currentSubcatalogues">
              <router-link :to="{name:'catalogue',params:{'catalogue_id':subcatalogue.id}}">{{subcatalogue.name}}</router-link>
          </li>
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

import { Radio,RadioGroup,RadioButton,Rate,Tabs,TabPane } from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

import Gallery from "./MoaGallery.vue"
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import 'bootstrap'; 
import 'bootstrap/dist/css/bootstrap.min.css';
import {StandardDate,showNotification,FetchAddressByPostcode,utf16to8,setToken,getToken} from "../../../lib/util.js"

export default {
  name: "ProductArticle",
  components: {
    Gallery,
    VueCtkDateTimePicker,
    RentalProductAlarm,
    elRadio:Radio,
    elRate:Rate,
    elRadioButton:RadioButton,
    elRadioGroup:RadioGroup,
    elTabs:Tabs,
    elTabPane:TabPane
  },
  data() {
    return {
      product:{},
      num:0,
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
    currentSubcatalogues(){

      return this.$store.state.lotteryshop.catalogue_now.subcatalogues;

    },
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
   },
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