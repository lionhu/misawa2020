<template>
  <div>

    <div class="row">
      <div class="col-md-6 col-sm-12" v-for="summary in order_summaries">
        <div class="info-box pull-up">
          <span class="info-box-icon">
            <span class="flag-icon flag-icon-jp" v-if="summary.from_currency=='jpy'"></span>
              <span class="flag-icon flag-icon-cn" v-if="summary.from_currency=='rmb'"></span>
          </span>

          <div class="info-box-content">
            <span class="info-box-number pull-left text-right">{{summary.sum | currency}}<small>
              {{summary.from_currency=='rmb'?"元":"万円" }}
            </small>
            <span class="info-box-text"> 
              {{summary.count}} orders
            </span>
            </span>
            <span class="info-box-number pull-right text-left"  style="font-size:1em!important;">
              <span class="info-box-text text-danger">
                <i class="fas fa-sort-up"></i>{{summary.max_rate}}
              </span>
              <span class="info-box-text text-success"> 
                <i class="fas fa-sort-down"></i>{{summary.min_rate}}
              </span>
            </span>
          </div>
        <!-- /.info-box-content -->
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="box box-inverse box-dark">
            <div class="box-header with-border">
              <h3 class="box-title">Recent Transactions</h3>
            </div>
            <div class="box-body">
              <el-table
                @row-click="SelectOrder"
                :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
                style="width: 100%">
                <el-table-column
                  sortable
                  prop="from_currency"
                  min-width='50'
                  align="right">
                  <template slot-scope="scope">
                      <span class="flag-icon flag-icon-jp" v-if="scope.row.from_currency=='jpy'"></span>
                      <span class="flag-icon flag-icon-cn" v-if="scope.row.from_currency=='rmb'"></span>
                  </template>
                </el-table-column>
                <el-table-column
                  sortable
                  prop="amount"
                  label="Amount"
                  min-width='150'
                  align="right">
                  <template slot-scope="scope">
                    {{scope.row.amount|currency}}{{scope.row.from_currency =="jpy"? "万円":"元"}}
                  </template>
                </el-table-column>
                <el-table-column
                  sortable
                  prop="rate"
                  label="Rate"
                  align="right">
                </el-table-column>
                <el-table-column
                  sortable
                  prop="status"
                  label="Status"
                  align="center"
                  min-width="120">
                  <template slot-scope="scope">
                    <a href="javascript:void(0)" style="width:110px;" class="btn b-1" v-bind:class="{'border-success':scope.row.status=='new','border-danger':scope.row.status=='Matching'}">
                    {{scope.row.status}}
                    <i class="fa fa-user pull-right" v-if="scope.row.user.id==ME.id"></i>
                  </a>
                  </template>
                </el-table-column>
                <el-table-column
                    sortable
                    prop="user.username"
                    label="User"
                    min-width="120">
                    <template slot-scope="scope">
                      {{ scope.row.user.username |filterUsername}}
                  </template>
                  </el-table-column>
                <el-table-column
                    sortable
                    label="Offers"
                    min-width="100">
                    <template slot-scope="scope">
                      <span class="badge badge-pill badge-warning" style="width:50px;" v-if="scope.row.offers.length">{{scope.row.offers.length}}</span>
                  </template>
                  </el-table-column>
                <el-table-column
                    sortable
                    prop="due_at"
                    label="Due"
                    min-width="120"
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
      </div>
    </div>
  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import { Table,TableColumn,Pagination,Form,FormItem } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';


  export default {
    name: 'app',
    inject:["reload"],
    components:{
      elTable: Table,
      elTableColumn: TableColumn,
      elPagination:Pagination,
      elForm:Form,
      elFormItem:FormItem
    },
    data () {
      return {
        ME:{},
        tableData: [],
        order_summaries:{},
        total:0,
        pagesize:10,
        currentPage:1,
      }
    },
    computed:{
      // myprofile(){
      //     return this.$store.state.users.profile;
      // },
    },
    created() {
      this.load_orderlist()
    },
    methods: {
      SelectOrder(row, event, column){
        this.$router.push({ name: 'singleorder', params: { slug: row.slug }})
      },
      load_orderlist(){

        this.$store.dispatch("orders/get_mailExchange_orders").then(
          resolve=>{
              this.tableData= resolve.orders
              this.ME= this.$store.state.users.profile.user;
              this.order_summaries= resolve.summary
              this.total=this.tableData.length;
              this.reload()
          },reject=>{});

        // window.location.reload()
      },
      current_change:function(currentPage){
          console.log(currentPage)
          this.currentPage = currentPage;
      },
      format_due_at(row, column, cellValue, index){
        var date_strs=cellValue.split("T")
        return date_strs[0]
      }
    },
     watch:{
      '$route':"reload"
    }
  //   watch: {
  //     $route(to,from) {
  //         console.log(to)
  //         console.log(from)
  //     }
  // }
};

</script>

<style lang="scss">
</style>