<template>
  <div>
<!--     <div class="row">
      <div class="col-12">
        <div class="box box-inverse box-dark">
            <div class="box-header with-border">
              <h3 class="box-title">{{$t("m.my_order_list")}}</h3>
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
                    <a href="javascript:void(0)" style="width:95px;" class="btn b-1" v-bind:class="{'border-success':scope.row.status=='new','border-danger':scope.row.status=='Matching'}">{{scope.row.status}}</a>
                  </template>
                </el-table-column>
                <el-table-column
                  label="Offers"
                  align="center"
                  min-width="70">
                  <template slot-scope="scope">
                    <span style="width:30px;" class="badge badge-pill badge-warning" v-if="scope.row.offers.length">{{scope.row.offers.length}}</span>
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
    </div>  -->
    {{tableData}}
  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import { Table,TableColumn,Pagination,Form,FormItem } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';


  export default {
    name: 'app',
    components:{
      elTable: Table,
      elTableColumn: TableColumn,
      elPagination:Pagination,
      elForm:Form,
      elFormItem:FormItem
    },
    inject:["reload"],
    data () {
      return {
        ME:null,
        tableData: [],
        order_summaries:{},
        total:0,
        pagesize:10,
        currentPage:1,
      }
    },
    computed:{
    },
    mounted() {
      this.load_orderlist()
    },
    methods: {

      SelectOrder(row, event, column){
        this.$router.push({ name: 'singleorder', params: { slug: row.slug }})
      },
      load_orderlist(){

        this.$store.dispatch("lotteryshop/getMyOrderList").then(resolve=>{
            this.tableData= resolve.orders
            this.total=this.tableData.length;
            var json_cart=this.tableData[0]._cart

            console.log(json_cart)
            this.reload()

        },reject=>{});

      },
      current_change:function(currentPage){
          this.currentPage = currentPage;
      },
      format_due_at(row, column, cellValue, index){
        var date_strs=cellValue.split("T")
        return date_strs[0]
      }
    },
    watch:{
      '$route' (to, from) {
        console.log(to)
        console.log(from)
        if(to !=from){
          this.load_orderlist()
        }
      }
    }
};

</script>

<style lang="scss">
.title{
  display:inline-block;
  width:50px;
}
</style>