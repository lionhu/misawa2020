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
              <h3 class="box-title">{{$t("m.my_order_list")}}</h3>
            </div>
            <div class="box-body">
              <el-table 
              :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)" 
              @row-click="SelectOrder"
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
                <el-table-column sortable prop="user" label="User" min-width='100' align="center">
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
                    <a href="javascript:void(0)" style="width:95px;" class="btn b-1" v-bind:class="{'border-success':scope.row.status=='new','border-danger':scope.row.status=='Matching'}" @click="SelectOrder(scope.row)">{{scope.row.status}}</a>
                  </template>
                </el-table-column>
                <el-table-column
                    sortable
                    prop="due_at"
                    label="Due"
                    min-width="120"
                    :formatter="format_due_at">
                  </el-table-column>                
                  <el-table-column
                  label="Operations"
                  align="center"
                  min-width="100">
                  <template slot-scope="scope">
                    <a href="javascript:void(0);" v-if="scope.row.offers_num ==0" @click="DeleteOrder(scope.row)"><i class="far fa-trash-alt"></i></a>
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

  import {setToken,getToken} from "../../../lib/util.js"

  export default {
    name: 'DirectOrders',
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
        tableData: [],
        order_summaries:{},
        total:0,
        pagesize:10,
        currentPage:1,
      }
    },
    computed:{
    },
    created() {
    },
    mounted(){
      this.checkIsAdmin()
      this.load_orderlist()

    },
    methods: {
      OrderUpdate(order,update_type,value){
        const url="/api/auction_order/AdminSingleOrderUpdate/";
        const order_slug = order.slug;
        const order_privacy = order.privacy=='public'?'private':'public';
        var params={};
        console.log("update "+value)
        if (update_type =="privacy"){
          params={
            "update_type":"privacy",
            "privacy":order_privacy,
            "slug":order_slug
          }
        }
        axios.post(url,params).then(
          res=>{
            if(res.data.update_type=='privacy'){
              const orderIndex=this.tableData.findIndex(order => order.slug==order_slug)

              if(orderIndex >-1){
                this.tableData[orderIndex].privacy=order_privacy
              }
            }
          },reject=>{
            console.log(reject)
          })
      },
      SelectOrder(row, event, column){
        this.$router.push({ name: 'dsorder', params: { slug: row.slug }})
      },
      DeleteOrder(row){
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
                axios.post("/api/auction_order/deleteOrderBySlug/",{
                  "slug":row.slug
                }).then(res=>{
                    if(res.data.result){
                      console.log(res)
                      const orderIndex=this.tableData.findIndex(order => order.slug ==res.data.order_slug)

                      console.log(orderIndex)
                      if(orderIndex > -1){
                        this.tableData.splice(orderIndex,1)
                      }
                      swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                    }else{
                      swalWithBootstrapButtons.fire(
                        'ERROR!',
                        res.data.message,
                        'danger'
                      )
                    }
                })
          } 
        })
      },
      checkIsAdmin(){
        const membership=this.$store.state.users.profile.membership

        if(membership !="ADMIN"){
          window.location.href="/exrate"
        }
      },
      load_orderlist(){

        this.$store.dispatch("orders/getAdminDirectOrderList");
        this.tableData= this.$store.state.orders.DSOrders
        this.order_summaries= this.$store.state.orders.DSOrderSummary

        this.total=this.tableData.length;

      },
      current_change:function(currentPage){
          this.currentPage = currentPage;
      },
      format_due_at(row, column, cellValue, index){
        var date_strs=cellValue.split("T")
        return date_strs[0]
      }
      
    },
    watch: {
    '$route' (to, from) {
        console.log(to)
        console.log(from)
    }
  }
  };
</script>

<style lang="scss">

</style>