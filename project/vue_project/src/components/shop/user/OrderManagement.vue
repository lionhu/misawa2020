<template>
<div class="container clearfix">

  <div class="sidebar nobottommargin">
    <div class="sidebar-widgets-wrap">

      <div class="widget widget-filter-links clearfix">

        <h4>Select Category</h4>
        <ul class="custom-filter" data-container="#shop" data-active-class="active-filter">
          <li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
          <li>
            <router-link :to="{name:'orderlist'}">{{$t("m.shop_orderlist")}}</router-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="postcontent nobottommargin col_last">
      <el-table
        @row-click="SelectOrder"
        :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
        style="width: 100%">
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
          min-width='150'
          align="right">
          <template slot-scope="scope">
            <span class="amount">{{scope.row.total|currency}}</span>
            <span class="badge badge-success" v-if="scope.row.discount >0">{{scope.row.discount|currency}}</span>
          </template>
        </el-table-column>
        <el-table-column label="Logistic" align="center" min-width="120">
          <template slot-scope="scope">
            <a href="" class="btn btn-info text-white">
              {{scope.row.logistic}} oooo<span class="badge badge-light">M</span>
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
  import { Table,TableColumn,Pagination,Form,FormItem } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index_shop.css';

  export default {
    name: 'UserOrderList',
    components:{
      elTable: Table,
      elTableColumn: TableColumn,
      elPagination:Pagination,
      elForm:Form,
      elFormItem:FormItem
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
</style>