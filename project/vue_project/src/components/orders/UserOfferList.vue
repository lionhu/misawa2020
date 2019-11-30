<template>
<div>
    <div class="row">
        <div class="col-12">
            <div class="box pull-up">
                <div class="box-body" v-for="summary in offer_summaries">
                    <div class="media align-items-center p-0">
                        <div class="text-center">
                            <a href="#"><span class="flag-icon fa-2x" :class="{'flag-icon-jp':summary.currency=='jpy','flag-icon-cn':summary.currency=='rmb'}"></span></a>
                        </div>
                        <div>
                            <h3 class="no-margin text-bold"> Summary</h3>
                        </div>
                    </div>
                    <div class="flexbox align-items-center mt-5">
                        <div>
                            <p class="no-margin font-weight-600"><span class="text-yellow mr-5 inline-block w-50 text-right">Count: </span>{{summary.count}}</p>
                            <p class="no-margin font-weight-600"><span class="text-yellow mr-5 inline-block w-50 text-right">Max: </span>{{summary.max|currency}}</p>
                        </div>
                        <div class="text-right">
                            <p class="no-margin font-weight-600"><span class="text-success mr-5 inline-block w-50 text-right">Total:</span>{{summary.sum|currency}}</p>
                            <p class="no-margin font-weight-600"><span class="text-success mr-5 inline-block w-50 text-right">Min:</span>{{summary.min|currency}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="box box-inverse box-dark">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$t("m.my_offer_list")}}</h3>
                </div>
                <div class="box-body">
                    <el-table 
                    :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)" 
                    style="width: 100%"
                    @row-click="SelectOrder">
                        <el-table-column sortable="" prop="currency" label="Currency" min-width="120" align="center">
                            <template slot-scope="scope">
                            <!--     <router-link :to="{ name: 'singleorder', params: { slug: scope.row.order.slug }}"> -->
                                    <span class="flag-icon flag-icon-jp" v-if="scope.row.currency=='jpy'"></span>
                                    <span class="flag-icon flag-icon-cn" v-if="scope.row.currency=='rmb'"></span> {{scope.row.price|currency}}
                                <!-- </router-link> -->
                            </template>
                        </el-table-column>
                        <el-table-column sortable="" prop="created" label="Created" align="right" min-width="120" :formatter="format_due_at">
                        </el-table-column>
                        <el-table-column sortable="" prop="status" label="Status" align="center" min-width="120">
                            <template slot-scope="scope">
                                <a href="javascript:void(0)" style="width:95px;" class="btn b-1" v-bind:class="{'border-success':scope.row.status=='new','border-danger':scope.row.status=='Matching'}">{{scope.row.status}}</a>
                            </template>
                        </el-table-column>
                    </el-table>
                    <el-pagination small="" layout="prev, pager, next" :total="total" @current-change="current_change">
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
        offer_summaries:{},
        total:0,
        pagesize:10,
        currentPage:1,
      }
    },
    computed:{
    },
    created() {
      this.my_offerlist()
    },
    methods: {
      SelectOrder(row, event, column){
        console.log(row)
        this.$router.push({ name: 'singleorder', params: { slug: row.order_slug }})
      },
      my_offerlist(){
        this.$store.dispatch("orders/get_my_offerlist").then(
          resolve=>{
            if(resolve.success){
                this.tableData= resolve.offers
                this.offer_summaries= resolve.offer_summary
                this.total=this.tableData.length;
                this.reload()
            }else{
              Swal.fire({
                type:"warning",
                text:"You have no offers yet!"
              })
              this.$router.push({name:"orderlist"})
            }

          },reject=>{});

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