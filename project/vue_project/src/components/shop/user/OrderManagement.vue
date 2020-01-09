<template>
<div class="container clearfix">

  <SideMenu></SideMenu>
  <div class="postcontent nobottommargin col_last">
        <el-table
          @row-click="SelectOrder"
          :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
          style="width: 100%">
          <el-table-column type="expand">
      <template slot-scope="props">
            <PayBill :order_slug="props.row.slug" :order_created_at="props.row.created_at" v-if="props.row.paystatus=='unpaid'"></PayBill>
            <div class="col_half left_quotation">
                  <p><span class="title">PayStatus: </span>{{props.row.paystatus}}</p>
                  <p><span class="title">Payment: </span>{{props.row.paymethod}}</p>
                  <p>@ {{props.row.paid_at}}</p>
            </div>
            <div class="col_half col_last left_quotation clearfix">
                  <p><span class="title">Tracking No: </span>{{props.row.tracking_no}}</p>
                  <p><span class="title">Logistic: </span>{{props.row.logistics}}</p>
                  <p>@ {{props.row.delivered_at}}</p>
            </div>

      </template>
    </el-table-column>

          <el-table-column
            min-width='100'
            label="Customer"
            align="right">
            <template slot-scope="scope">
              <span>{{scope.row.last_name}} {{scope.row.first_name}}</span>
            </template>
          </el-table-column>
          <el-table-column
            sortable
            prop="total"
            label="Amount"
            min-width='100'
            align="right">
            <template slot-scope="scope">
              <span class="amount">{{scope.row.total+scope.row.tax-scope.row.discount|currency}}</span>
              <span class="badge badge-success right-corner" v-if="scope.row.discount >0"><i class="fas fa-tags rightmargin-5"></i></span>              
<!--               <span class="badge badge-success right-corner" v-if="scope.row.discount >0"><i class="fas fa-tags rightmargin-5"></i>{{scope.row.discount|currency}}</span> -->
            </template>
          </el-table-column>
          <el-table-column label="Logistic" align="center" min-width="120">
            <template slot-scope="scope">
              <a class="btn btn-info text-white">
                {{scope.row.logistic}} oooo<span class="badge badge-light delivery_status">M</span>
              </a>
            </template>
          </el-table-column>
          <el-table-column sortable prop="created_at" label="Created" min-width="120">
              <template slot-scope="scope">
                <span class="" >{{scope.row.created_at|StandardDate}}</span>
            </template>
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
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import { Table,TableColumn,Pagination,Form,FormItem,Col,Card,Row } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';
  import SideMenu from "./parts/SideMenu.vue"
  import PayBill from "../../shop/parts/PayBill.vue"

  export default {
    name: 'UserOrderList',
    components:{
      elTable: Table,
      elTableColumn: TableColumn,
      elPagination:Pagination,
      elForm:Form,
      elFormItem:FormItem,
      elCol:Col,
      elRow:Row,
      elCard:Card,
      SideMenu,
      PayBill
    },
    data () {
      return {
        ME:null,
        // orders:[],
        tableData: [],
        order_summaries:{},
        total:0,
        pagesize:10,
        currentPage:1,
      }
    },
  computed: {
    // catalogue_products:function(){
    //   return this.$store.state.lotteryshop.catalogue_products
    // },
    // subcatalogues_now:function(){
    //   const catalogue = this.$store.state.lotteryshop.catalogue_now
    //   return catalogue.subcatalogues
    // },
  },
    mounted() {
      this.loadMyOrderlist()
    },
    methods: {
      current_change:function(currentPage){
          console.log(currentPage)
          this.currentPage = currentPage;
      },
      loadMyOrderlist(){
        this.$store.dispatch("orders/getMyOrderList").then(resolve=>{
          if(resolve.result){
            // this.orders=resolve.orders
            this.tableData= resolve.orders
            this.ME= this.$store.state.users.profile.user;
            this.order_summaries= resolve.summary
            this.total=this.tableData.length;
          }
        })
      },
      SelectOrder(row, event, column){
        this.$router.push({ name: 'orderdetail', params: { slug: row.slug }})
      },
    },
    watch: {
      '$route' (to, from) {
          // console.log("watch route222")
          // const to_id=to.params.catalogue_id
          // const from_id =from.params.catalogue_id
          // if(from_id !== to_id){
          //   this.loadCatalogueProducts(to_id)
          // }
      }
  }
};
</script>

<style lang="scss">
.el-table th, .el-table tr {
  background-color:#FFF;
}
.el-table thead {
    color: #909399!important;
}
table {
  margin-bottom :0 !important;
}
.right-corner{
  position:absolute;
  top:5px;
  right:30px;
}
.delivery_status{
  position:absolute!important;
  top: 5px!important;
}
.el-table, .el-table__expanded-cell {
  background-color: #FFF; 
}

.left_quotation{
  border-left: #058423b8 3px solid;
  padding-left: 10px;
}
</style>