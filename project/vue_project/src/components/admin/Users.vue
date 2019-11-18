<template>
  <div>

    <RealtimeAlert visible="true" v-on:userstatus="userstatus_nofitication"></RealtimeAlert>
    <div class="row">
      <div class="col-lg-6 col-sm-12">
        <div class="box box-inverse box-dark">
            <div class="box-header with-border">
              <h3 class="box-title">Admin User Lists</h3>
            </div>
            <div class="box-body">
              <el-table
                :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
                style="width: 100%">
                <el-table-column
                    sortable
                    prop="username"
                    label="User"
                    min-width="120">
                </el-table-column>
                <el-table-column
                    sortable
                    label="Statue"
                    min-width="100">
                    <template slot-scope="scope">                    
                        <span class="badge badge-pill" :class="{'badge-danger': !scope.row.profile.online,'badge-success':scope.row.profile.online}" style="width:50px;"  @click="chatwith(scope.row)">{{scope.row.profile.online}}</span>
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
      <div class="col-lg-6 col-sm-12">
        <ChatUser :user="chatwithuser"></ChatUser>
      </div>
    </div>
  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import { Table,TableColumn,Pagination,Form,FormItem } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';
  import RealtimeAlert from "../parts/RealtimeAlert.vue"
  import ChatUser from "./parts/Chat.vue"

  import {setToken,getToken} from "../../lib/util.js"

  export default {
    name: 'admin_home',
    inject:["reload"],
    components:{
      elTable: Table,
      elTableColumn: TableColumn,
      elPagination:Pagination,
      elForm:Form,
      elFormItem:FormItem,
      RealtimeAlert,
      ChatUser
    },
    data () {
      return {
        // tableData:[],
        total:0,
        pagesize:10,
        currentPage:1,
        chatwithuser:""
      }
    },
    computed:{
      tableData(){
        return this.$store.state.users.userlist
      }
    },
    created() {
      this.loadUserList()
      // let users=this.$store.state.users.userlist
      // this.tableData=users
    },
    methods: {
      loadUserList(){
        this.$store.dispatch("users/getUserList")
      },
      current_change:function(currentPage){
          this.currentPage = currentPage;
      },
      userstatus_nofitication(data){
        console.log("userstatus_nofitication")
        this.$store.commit("users/setUserStatus",data)
        // var users= this.tableData
        // const userIndex=users.findIndex(user =>user.id ==data.user_id)

        // if(userIndex>-1){
        //   var user=users[userIndex]
        //   user.profile.online=data.status

        //   users.splice(userIndex,1,user)
        // }
        // this.$set(this.tableData,users)
      },
      chatwith(user){
        console.log(user)
        this.chatwithuser=user
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