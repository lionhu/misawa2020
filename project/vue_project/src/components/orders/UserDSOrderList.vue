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
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="box box-inverse box-dark">
            <div class="box-header with-border">
              <h3 class="box-title">My Fixed rate Order List</h3>
            </div>
            <div class="box-body">
              <el-table
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
                    sortable
                    prop="due_at"
                    label="Due"
                    min-width="120"
                    :formatter="format_due_at">
                  </el-table-column>
                <el-table-column>
                  <template slot-scope="scope">
                    <a href="javascript:void(0);" @click="handleDSOrderDelete(scope.row.slug)" v-if="scope.row.status=='new'"><i class="fa fa-trash text-danger"></i></a>
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
    name: 'dsorderlist',
    components:{
      elTable: Table,
      elTableColumn: TableColumn,
      elPagination:Pagination,
      elForm:Form,
      elFormItem:FormItem,
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
       handleDSOrderDelete(slug){
        Swal.fire({
          title: 'Are you sure?',
          text: "Cancell your order?!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true,
          allowOutsideClick:false,
          showLoaderOnConfirm: true,
          preConfirm: () => {
            this.$store.dispatch("orders/delete_dsorder",slug).then(
              resolve=>{
                return {"value":true}
              },reject=>{})
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
          if (result.value) {
            this.tableData= this.$store.state.orders.MyDSOrderList
            this.total=this.tableData.length;
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            })
            Toast.fire({
              type: 'success',
              title: 'deleted successfully'
            })
          }
        })

      },
      load_orderlist(){
        this.$store.dispatch("orders/get_my_dsorderlist").then(resolve=>{
            this.tableData= this.$store.state.orders.MyDSOrderList
            this.order_summaries= this.$store.state.orders.MyDSOrder_summary
            this.total=this.tableData.length;
            this.reload()
        },reject=>{

        });


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
      $route:{
        handler(to,from){
          // console.log(to.params.product_slug)
          if(to !==from){

          console.log(to)
          console.log(from)
          }

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