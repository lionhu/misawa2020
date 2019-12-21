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
            <!-- <div class="font-size-20 text-pink">{{order.rate}}+{{order.rate_alpha}}</div> -->
          </li>

          <li class="bg-warning" style="padding:5px;">
            <small>
              <span class="flag-icon flag-icon-jp fa-2x" v-if="order.from_currency=='rmb'"></span>
              <span class="flag-icon flag-icon-cn fa-2x" v-if="order.from_currency=='jpy'"></span>Price
            </small>
            <small>Ask(買い)</small>
            <div class="font-size-20 text-white">{{ order_price |currency}}
            {{order.from_currency=="rmb"?"円":"元"}}
            </div>

          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  // import { Table,TableColumn,Pagination } from 'element-ui';
  // import 'element-ui/lib/theme-chalk/index.css';
  import FlipCountdown from 'vue2-flip-countdown'


  export default {
    name: 'AdminSingleDirectOrder',
    components:{      
      // elTable: Table,
      // elTableColumn: TableColumn,
      // elPagination:Pagination,
      FlipCountdown
    },
    data () {
      return {
        pagesize:10,
        currentPage:1,
        total:0,
        todayrate:{},
        deadline:"2019-12-31 23:59:59"
      }
    },
    computed:{
      ME(){
          return this.$store.state.users.profile
      },
      order(){
        return this.$store.state.orders.DSOrder
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
      if (this.$route.params.slug ==""){
          window.location.href="/superadmin/#/dsorders"
      }
      this.$store.dispatch("orders/getAdminDirectSingleOrder",this.$route.params.slug).then(
        resolve=>{
          console.log(resolve)
        },reject=>{
          window.location.href="/superadmin/#/dsorders"
        })
    },
    methods: {

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