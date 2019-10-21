<template>
  <section>
    <div class="box">
      <div class="box-header flexbox flex-justified ">
        <div class="text-left">
          <h6 class="mb-0"  v-if="order.user.id==ME.user.id">
            <i class="fa fa-user text-success mr-5"></i>{{order.user.username}}
          </h6>
          <h6 class="mb-0"  v-if="order.user.id !=ME.user.id">
            <i class="fa fa-user text-success mr-5" ></i>{{order.user.username | filterUsername}}
          </h6>
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
            <small>Bid(売り)</small>
            <div class="font-size-20">{{order.amount|currency}}
            {{order.from_currency=="jpy"?"万円":"元"}}</div>
            <small>
              <span class="flag-icon flag-icon-jp fa-2x" v-if="order.from_currency=='jpy'"></span>
              <span class="flag-icon flag-icon-cn fa-2x" v-if="order.from_currency=='rmb'"></span>
            </small>
          </li>

          <li class="br-1">
            <small>
              <i class="fas fa-exchange-alt"></i>
            </small>
            <div class="font-size-20 text-pink">{{order.rate}}</div>
            <small>Rate</small>
          </li>

          <li class="bg-warning">
            <small>Ask(買い)</small>
            <div class="font-size-20 text-white">{{ order.price |currency}}
            {{order.from_currency=="rmb"?"円":"元"}}
            </div>
            <small>
              <span class="flag-icon flag-icon-jp fa-2x" v-if="order.from_currency=='rmb'"></span>
              <span class="flag-icon flag-icon-cn fa-2x" v-if="order.from_currency=='jpy'"></span>Price</small>
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

      <div class="box-body center" v-if="order.status!=='Matching'">
            <flip-countdown :deadline="deadline"></flip-countdown>
      </div>
      <div class="box-footer" v-if="!isOrderOwner && order.status=='new'">
        <button class="btn btn-lg btn-success pull-right" @click="buyOrder">Buy</button>
<!--         <button class="btn btn-lg btn-danger pull-left" @click="deleteOffer">Delete My Offer</button> -->
      </div>
    </div>
    <div class="box box-inverse box-dark">
          <div class="box-header with-border">
            <div class="ribbon ribbon-right bg-warning">{{offers.length}}</div>
            <h3 class="box-title">Offers</h3>
            <h6 class="text-warning"><i class="fab fa-first-order fa-spin"></i> {{order.slug}} </h6>
          </div>
          <div class="box-body">
            <el-table
              @row-click="SelectOfferRow"
              :data="offers.slice((currentPage-1)*pagesize,currentPage*pagesize)"
              style="width: 100%">
<!--               <el-table-column
                  sortable
                  prop="from_currency"
                  label="Type"
                  width="80">
                  <template slot-scope="props">
                    <router-link :to="{ name: 'singleorder', params: { slug: props.row.slug }}">
                        <span class="flag-icon flag-icon-jp" v-if="props.row.from_currency=='jpy'"></span>
                        <span class="flag-icon flag-icon-cn" v-if="props.row.from_currency=='rmb'"></span>
                    </router-link>
                  </template>
              </el-table-column> -->
              <el-table-column
                sortable
                prop="price"
                label="Price"
                align="right"
                min-width="120">
                <template slot-scope="scope">
                  <i class="fa fa-scroll" v-if="order.status=='new' && isOrderOwner"></i>
                  <i class="fas fa-comments-dollar" v-if="scope.row.status=='Matching'"></i>
                  
                  <span :class="scope.row.price>=order.price?'text-danger':'text-success'">
                      {{scope.row.price|currency}}{{order.from_currency=="rmb"?"円":"元"}}
                  </span>
                </template>
              </el-table-column>
              <el-table-column
                sortable
                prop="follower.username"
                label="User">

                <template slot-scope="scope">
                  <span v-if="scope.row.follower.id==ME.user.id">{{scope.row.follower.username}}</span>
                  <span v-if="scope.row.follower.id!=ME.user.id">{{scope.row.follower.username|filterUsername}}</span>
                </template>

              </el-table-column>
              <el-table-column
                  sortable
                  prop="due_at"
                  label="Due"
                  min-width="100"
                  :formatter="format_due_at">
                </el-table-column>
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
    name: 'neworder',
    components:{      
      elTable: Table,
      elTableColumn: TableColumn,
      elPagination:Pagination,
      FlipCountdown
    },
    inject:["reload"],
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
    },
    mounted(){
      this.$store.dispatch("orders/get_singleorder",this.$route.params.slug).then(res=>{
        // console.log("SingleOrder res")
        this.order=res.order;
        this.offers=res.offers;
        this.transaction=res.transaction;
        this.total=res.offers.length
        this.isOrderOwner=res.isOrderOwner
        var offerindex=this.offers.findIndex(offer => offer.follower.id == this.ME.user.id)
        this.hasOffered= offerindex>-1?true:false
        if(this.hasOffered){
            this.hasOffer_index=offerindex
            var off=this.offers[offerindex]
            this.hasOffer_id=off.id
        }
        this.deadline=this.order.due_at.replace("T"," ")
        this.prepare_offers_summary()
        this.reload()
      },reject=>{})
    },
    created() {

    },
    methods: {
      SelectOfferRow(row, event, column){
        console.log(this.order.status)
        if(this.order.status=='new' && this.isOrderOwner){
            this.SelectOffer(row)
        }
      },
      prepare_offers_summary(){
        console.log("prepare_offers_summary")
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
          title: '再次确认想要交易的金额?',
          text: "交易金额: "+ offer.price,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'OK，没有问题！',
          preConfirm: (result) => {
            console.log("proConfirm: "+result)
            if(result){
              var params={
                "status": "new",
                "order_id":this.order.id,
                "offer_id":offer.id
              }
              this.$store.dispatch("orders/post_createTransaction",params)
              .then(resolve=>{
                if(resolve.result){
                  this.order.status="Matching"
                  this.transaction.offer_id=offer.id
                  this.transaction.order_id=this.order.id
                  return true
                }else{
                  return false
                }
              },rejecte=>{
                return false
              })
            }
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            console.log("catch: "+result)
          if(result){
            Swal.fire({
              title: '成功发起交易邀请!',
              text: '扫描二维码，联系平台。',
              imageUrl: '/static/images/nichiei.jpg',
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
        })

          // Swal.fire({
          //   title: '再次确认想要交易的金额?',
          //   text: "交易金额: "+ offer.price,
          //   type: 'warning',
          //   showCancelButton: true,
          //   confirmButtonColor: '#3085d6',
          //   cancelButtonColor: '#d33',
          //   confirmButtonText: 'OK，没有问题！',
          // }).then((result) => {
          //   if (result.value) {
          //     var params={
          //       "status": "new",
          //       "order_id":this.order.id,
          //       "offer_id":offer.id
          //     }

          //     this.$store.dispatch("orders/post_createTransaction",params)
          //     .then(resolve=>{
          //       if(resolve.result){
          //         this.order.status="Matching"
          //         this.transaction.offer_id=offer.id
          //         this.transaction.order_id=this.order.id
          //         Swal.fire({
          //           title: '成功发起交易邀请!',
          //           text: '扫描二维码，联系平台。',
          //           imageUrl: '/static/images/nichiei.jpg',
          //           imageWidth: 260,
          //           imageHeight: 260,
          //           imageAlt: 'Custom image',
          //           animation: false
          //         })
          //       }else{
          //         Swal.fire(
          //           '失败!',
          //           '本次交易申请失败，请联系平台！',
          //           'error'
          //         )
          //       }
          //     },rejecte=>{})
          //   }
          // })
      },

      async deleteOffer(){
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

            this.$store.dispatch("orders/post_deleteOffer",this.hasOffer_id).then(
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
        Swal.fire({
          title: '请输入您的出价金额?',
          input: 'text',
          inputAttributes: {
            autocapitalize: 'off'
          },
          inputValue:this.order.price,
          showCancelButton: true,
          confirmButtonText: 'Start',
          showLoaderOnConfirm: true,
          preConfirm: (price) => {
              var min = parseInt(this.order.price*0.7)
              var max = parseInt(this.order.price*1.3)
              if(price>=min && price<max){
                  var params={
                    "price":parseInt(price),
                    "offer_id":parseInt(this.hasOffer_id),
                    "follower_id":parseInt(this.ME.user.id),
                    "currency":this.order.to_currency,
                    "status":"new",
                    "order_id":parseInt(this.order.id)
                  }

                  if(this.hasOffered){

                      return this.$store.dispatch("orders/post_updateoffer",params).then(
                        res=>{
                            if(res.result){
                              Swal.fire({
                                  "type":"success",
                                  "title":"Success",
                                  "text":"成功更新！"
                                })
                              var newoffer={
                                "price":res.offer.price,
                                "follower":res.offer.follower,
                                "due_at":res.offer.due_at
                              }
                            // console.log(newoffer)
                            this.offers.splice(this.hasOffer_index,1,newoffer)
                            this.prepare_offers_summary()
                            return true
                          }
                        },reject=>{
                          Swal.showValidationMessage(
                            `Request failed: ${error}`
                          )
                          return false
                        })
                  }else{
                      return this.$store.dispatch("orders/post_createoffer",params).then(
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
                            var offerindex=this.offers.findIndex(offer => offer.follower.id == this.ME.user.id)
                            this.hasOffer_index=offerindex
                            this.hasOffer_id=res.id

                            this.prepare_offers_summary()
                            return true

                          }
                        },reject=>{
                          Swal.showValidationMessage(
                            `Request failed: ${error}`
                          )
                          return false
                        })
                  }
              }else{
                  return "请输入有效的数值！"
              }

          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
          if (result) {
              Swal.fire('成功!','本次操作成功！','success')
          }else{
              Swal.fire('失败!','本次交易申请失败，请联系平台！','error')
          }
        })
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
      format_due_at(row, column, cellValue, index){
        var date_strs=cellValue.split("T")
        return date_strs[0]
      }
    },
};

</script>

<style lang="scss">
</style>