<template>
  <div>
    <div class="row">
      <div class="col-12">
        <div class="box box-inverse box-dark">
            <div class="box-header with-border">
              <h3 class="box-title">Recent Transactions</h3>
            </div>
            <div class="box-body">
              <el-table
                :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
                style="width: 100%">
<!--                 <el-table-column
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
                </el-table-column> -->
                <el-table-column
                    sortable
                    prop="username"
                    label="User"
                    min-width="120">
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

  import {setToken,getToken} from "../../lib/util.js"

  export default {
    name: 'admin_home',
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
        tableData:[],
        total:0,
        pagesize:10,
        currentPage:1,
      }
    },
    computed:{
    },
    created() {
      this.loadUserList()
    },
    methods: {
      loadUserList(){
        this.$store.dispatch("users/getUserList").then(
          resolve=>{
            this.tableData=resolve
            this.total=this.tableData.length;
          },reject=>{})
      },
      current_change:function(currentPage){
          this.currentPage = currentPage;
      },
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