<template>
  <section>
    <div class="box">
      <div class="box-header flexbox flex-justified ">
        <div class="text-left">
          <h4 class="mb-0">
            <i class="fa fa-user text-success mr-5"></i>{{order.user}} </h4>
          <small class="text-warning">
            <i class="fas fa-stopwatch"></i> {{deadline}}
          </small>
        </div>
        <div class="text-right">
          <a class="btn text-success">
            <i class="fab fa-rocketchat" v-if="order.status=='Matching'"></i>
            {{order.status}}
          </a>
        </div>
      </div>
      <div class="box-body">
        <ul class="flexbox flex-justified text-center mt-30">
          <li class="br-1">            
            <small>
              <span class="flag-icon flag-icon-jp fa-2x" v-if="order.from_currency=='jpy'"></span>
              <span class="flag-icon flag-icon-cn fa-2x" v-if="order.from_currency=='rmb'"></span>
            </small>
            <small>Bid(売り)</small>
            <div class="font-size-20">{{order.amount|currency}}
            {{order.from_currency=="jpy"?"万円":"元"}}</div>

          </li>

          <li class="br-1">
            <small>
              <i class="fas fa-exchange-alt"></i>Rate
            </small>
            <div class="font-size-20 text-pink">{{order.rate}}</div>
            <div class="font-size-20 text-pink">{{order.rate}}+{{order.rate_alpha}}</div>
          </li>

          <li class="bg-warning" style="padding:5px;">
            <small>
              <span class="flag-icon flag-icon-jp fa-2x" v-if="order.from_currency=='rmb'"></span>
              <span class="flag-icon flag-icon-cn fa-2x" v-if="order.from_currency=='jpy'"></span>Price
            </small>
            <small>Ask(買い)</small>
            <div class="font-size-20 text-white">{{ order_price |currency}}
            {{order.from_currency=="rmb"?"円":"元"}} <br>
            {{ order.price_alpha |currency}}
            {{order.from_currency=="rmb"?"円":"元"}} 
            </div>

          </li>
        </ul>
      </div>
      <div class="box-body">
        <ul class="flexbox flex-justified align-items-center">
          <li class="text-right">
            <div class="font-size-20 text-success">{{offers_summary.belowrate}}%</div>
            <small class="text-uppercase">below</small>
          </li>

          <li class="text-center px-2">
            <div class="easypie" :data-percent="offers_summary.overrate">
              <span class="percent">{{offers_summary.overrate}}</span>
            <canvas height="220" width="220" style="height: 110px; width: 110px;"></canvas></div>
    
          </li>

          <li class="text-left">
            <div class="font-size-20 text-warning">{{offers_summary.overrate}}%</div>
            <small class="text-uppercase">over</small>
          </li>
        </ul>
      </div>

      <div class="box-body center" v-if="order.status !=='Matching'">
            <flip-countdown :deadline="deadline"></flip-countdown>
      </div>
      <div class="box-footer" v-if="!isOrderOwner && order.status=='new'">
        <button class="btn btn-lg btn-success pull-right" @click="buyOrder">Buy</button>
        <button class="btn btn-lg btn-danger pull-left" @click="deleteOffer">Delete My Offer</button>
      </div>
    </div>
    <div class="box box-inverse box-dark">
          <div class="box-header with-border">
            <h3 class="box-title">Recent Transactions</h3>
            <h6 class="text-warning"><i class="fab fa-first-order fa-spin"></i> {{order.slug}} </h6>
          </div>
          <div class="box-body">
            <el-table
              :data="offers.slice((currentPage-1)*pagesize,currentPage*pagesize)"
              style="width: 100%">
              <el-table-column
                sortable
                prop="price"
                label="Ask Price"
                align="right"
                width="120">
                <template slot-scope="scope">
                  <a href="javascript:void(0)" @click="SelectOffer(scope.row)"  v-if="order.status=='new' && isOrderOwner">
                    <i class="fa fa-scroll"></i>
                  </a>
                  <i class="fas fa-comments-dollar" v-if="scope.row.status=='Matching'"></i>
                  
                  <span :class="scope.row.price>=order.price?'text-danger':'text-success'">
                      {{scope.row.price|currency}}{{order.from_currency=="rmb"?"円":"元"}}
                  </span>
                </template>
              </el-table-column>
              <el-table-column
                sortable
                prop="follower"
                label="User">
              </el-table-column>
              <el-table-column
                  sortable
                  prop="created"
                  label="Created"
                  width="100"
                  :formatter="format_created">
                </el-table-column>
              <el-table-column
                  label="Created"
                  width="100">
                <template slot-scope="scope">
                  <a href="javascript:void(0)" @click="deleteOffer(scope.row)">
                    <i class="far fa-trash-alt"></i>
                  </a>
                </template>

                </el-table-column>
            </el-table>
            </el-table>
            <el-pagination
              small
              layout="prev, pager, next"
              :total="total"
              @current-change="current_change">
            </el-pagination>
          </div>
    </div>
  </section>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import { Table,TableColumn,Pagination } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';
  import FlipCountdown from 'vue2-flip-countdown'


  export default {
    name: 'AdminSingleAuctionOrder',
    components:{      
      elTable: Table,
      elTableColumn: TableColumn,
      elPagination:Pagination,
      FlipCountdown
    },
    data () {
      return {
        pagesize:10,
        currentPage:1,
        total:0,
        isOrderOwner:false,
        hasOffered:false,
        hasOffer_id:0,
        transaction:{},
        hasOffer_index:0,
        todayrate:{},
        order:{
          user:{
            username:""
          }
        },
        offers:[],
        offers_summary:{
          total:0,
          below:0,
          over:0,
          overrate:0,
          belowrate:0
        },
        deadline:"2019-12-31 23:59:59"
      }
    },
    computed:{
      ME(){
          return this.$store.state.users.profile
      },
      order_price(){
          if(this.order.from_currency=="jpy"){
            return parseInt(this.order.amount)*100*parseFloat(this.order.rate)
          }else{
            return parseInt(this.order.amount)/parseFloat(this.order.rate)*100
          }
      },
    },
    mounted(){
      console.log(this.$route.params.slug)
      this.$store.dispatch("orders/getAdminAuctionSingleOrder",this.$route.params.slug).then(res=>{
        console.log("getAdminAuctionSingleOrder res")
        console.log(res)
        this.order=res.admin_order;
        this.offers=res.admin_offers;
        this.total=res.admin_offers.length
        this.isOrderOwner=res.isOrderOwner
        var offerindex=this.offers.findIndex(offer => offer.follower.id == this.ME.id)
        this.hasOffered= offerindex>-1?true:false
        if(this.hasOffered){
            this.hasOffer_index=offerindex
            var off=this.offers[offerindex]
            this.hasOffer_id=off.id
        }
        this.deadline=this.order.due_at.replace("T"," ")
        this.prepare_offers_summary()
      },reject=>{})
    },
    created() {

    },
    methods: {
      prepare_offers_summary(){
          var orderprice=this.order.price
          if(this.offers.length){
              var flattened = this.offers.reduce(
                function(accumulator, currentValue) {
                   accumulator[0] += 1
                   accumulator[1] += currentValue.price>=orderprice?1:0
                   return accumulator
                },[0,0]);
              this.offers_summary.total= flattened[0]
              this.offers_summary.over= flattened[1]
              this.offers_summary.below= this.offers_summary.total-this.offers_summary.over
              this.offers_summary.overrate= this.offers_summary.over==0?0:parseInt(this.offers_summary.over/this.offers_summary.total*100)
              this.offers_summary.belowrate= this.offers_summary.below==0?0:parseInt(this.offers_summary.below/this.offers_summary.total*100)
          }

      },
      async SelectOffer(offer){
          Swal.fire({
            title: 'Are you sure?',
            text: "trade with price: "+ offer.price,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, I do!'
          }).then((result) => {
            if (result.value) {
              var params={
                "status": "new",
                "order_id":this.order.id,
                "offer_id":offer.id
              }
              console.log(params)

              this.$store.dispatch("orders/post_createTransaction",params)
              .then(resolve=>{
                if(resolve.result){
                  this.order.status="Matching"
                  this.transaction.offer_id=offer.id
                  this.transaction.order_id=this.order.id
                  Swal.fire({
                    title: '成功!',
                    text: '您已经成功发起交易邀请，请稍后！扫描二维码，联系平台。',
                    imageUrl: 'https://unsplash.it/400/200',
                    imageWidth: 260,
                    imageHeight: 260,
                    imageAlt: 'Custom image',
                    animation: false
                  })
                }else{
                  Swal.fire(
                    '失败!',
                    '本次交易申请失败，请联系平台！',
                    'error'
                  )
                }
              },rejecte=>{})


            }
          })
      },

      async deleteOffer(offer){
        console.log(offer)
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {

            axios.post("/api/auction_offer/AdminDeleteOrder/",{"offer":offer}).then(
              res=>{
                  Swal.fire({
                      "type":"success",
                      "title":"Success",
                      "text":"成功删除下单！"
                    })
                  this.offers.splice(this.hasOffer_index,1)
                  this.hasOffered=false
                  this.hasOffer_id=0
                  this.hasOffer_index=0
                
              },reject=>{})
          }
        })
      },
      async buyOrder(){
          const { value: offerprice } = await Swal.fire({
            title: '请输入您的出价金额?',
            type: 'question',
            input: 'text',
            inputValue:this.order.from_currency=="jpy"? 6000:10000,
            inputValidator:(result)=>{
              var ret = this.order.from_currency=="jpy"? 6000:10000
              if(result>=ret && result<10000000){
                  var params={
                    "price":parseInt(result),
                    "offer_id":parseInt(this.hasOffer_id),
                    "follower_id":parseInt(this.ME.id),
                    "status":"new",
                    "order_id":parseInt(this.order.id)
                  }

                  this.place_offer(params)
              }else{
                return "请输入有效的数值！"
              }
            }
          })
      },
      place_offer(params){
        if (this.hasOffered){
           console.log("update offer")
            this.$store.dispatch("orders/post_updateoffer",params).then(
              res=>{
                  console.log(res)
                if(res.id>0){
                  Swal.fire({
                      "type":"success",
                      "title":"Success",
                      "text":"成功更新！"
                    })
                  var newoffer={
                    "price":res.price,
                    "follower":res.follower,
                    "due_at":res.due_at
                  }
                  console.log(newoffer)
                  this.offers.splice(this.hasOffer_index,1,newoffer)
                }
              },reject=>{

              })
        }else{
           console.log("create offer")
            this.$store.dispatch("orders/post_createoffer",params).then(
              res=>{
                if(res.id>0){
                  Swal.fire({
                      "type":"success",
                      "title":"Success",
                      "text":"成功下单！"
                    })
                  var newoffer={
                    "price":res.price,
                    "follower":res.follower,
                    "due_at":res.due_at
                  }
                  this.offers.unshift(newoffer)
                  this.hasOffered=true
                  var offerindex=this.offers.findIndex(offer => offer.follower.id == this.ME.id)
                  this.hasOffer_index=offerindex
                  this.hasOffer_id=res.id
                }
              },reject=>{

              })
        }
      },
      caculate_price(){
        if (this.order.from_currency =="jpy"){
            this.order.price =  parseInt(Math.round(this.order.amount*this.order.rate*100000)/1000)
        }else{
            this.order.price = Math.round(this.order.amount/this.order.rate*100)
        }
      },
      current_change:function(currentPage){
          this.currentPage = currentPage;
      },
      format_created(row, column, cellValue, index){
        var date_strs=cellValue.split("T")
        return date_strs[0]
      }
    },
    watch: {
      '$route' (to, from) {
        console.log(to)
    }
  }
};

</script>

<style lang="scss">
</style>