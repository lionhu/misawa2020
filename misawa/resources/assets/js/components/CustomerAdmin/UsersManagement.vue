<template>
        <div class=" nobottommargin">

            <section data-v-5790ee72="" id="page-title" class="page-title-pattern bottommargin-sm">
                <div data-v-5790ee72="" class="container clearfix">
                    <h1 data-v-5790ee72="">团队管理</h1>
                    <span data-v-5790ee72="">My Team Members</span>
                </div>
            </section>
            <div style="margin-top: 15px;">
                <el-autocomplete
                        class="inline-input pull-right"
                        v-model="select"
                        :fetch-suggestions="querySearchAsync"
                        placeholder="请输入用户名称部分内容"
                        :trigger-on-focus="false"
                >
                    <el-button slot="append"  @click="resetSearch">Reset</el-button>
                </el-autocomplete>
            </div>

            <el-table
                    :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
                    style="width: 100%">
                <el-table-column type="expand">
                    <template slot-scope="props">
                            <div class="col_half title-block d-block">
                                <span><strong>Email:</strong>{{ props.row.email }}</span>
                                <span> <strong>介绍码:</strong> {{ props.row.introcode }}</span>

                                </div>
                        <div class="col_one_fourth  title-block d-block">
                            <a href="javascript:void(0);" class="btn btn-info text-danger d-block my-10" @click="SetUserBasicInfo(props.row)">设置基本信息</a>
                            <!--<a href="javascript:void(0);" class="btn btn-danger text-white d-block my-10" @click="RemoveUser(props.row.id)">Remove</a>-->
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="姓名" sortable
                        prop="id">
                    <template slot-scope="props">
                        {{props.row.name}}(#{{props.row.id}})
                    </template>
                </el-table-column>
                <el-table-column
                        label="类型" sortable
                        prop="flag_vendor">

                    <template slot-scope="props">
                        <span v-if="props.row.roles && props.row.roles[0].name=='distributor' " class="text-success">
                            <i class="fa fa-universal-access"></i>Distributor ({{props.row.rate*100}}%)</span>
                        <span v-if="props.row.roles && props.row.roles[0].name=='customerAdmin'" class="text-danger">
                             <i class="fa fa-users"></i>DisAdmin ({{props.row.rate*100}}%)
                        </span>
                        <span v-if="props.row.roles && props.row.roles[0].name=='customer'" class="text-success">
                             <i class="fa fa-shopping-basket"></i>Customer
                        </span>
                    </template>
                </el-table-column>
            </el-table>
            <div style="text-align: center;margin-top: 30px;">
                <el-pagination
                        background
                        layout="prev, pager, next"
                        :total="total"
                        @current-change="current_change">
                </el-pagination>
            </div>

            <!-- 模态框（Modal） -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">×
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                会员 {{basicinfo.name}}基本信息
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="col_half hidden-xs" data-height-xl="456" data-height-lg="456" data-height-md="456"
                                 data-height-sm="0" data-height-xs="0"
                                 style="background-image: url(/images/parallax/4.jpg); background-size: cover; height: 456px;"></div>
                            <div class="col_half col_last">
                                <form action="#" class="clearfix" style="max-width: 300px;">
                                    <div class="col_full">
                                        <label for="form-email" class="capitalize t600">邮箱:</label>
                                        <input type="email" id="form-email" name="form-email" v-model="basicinfo.email" readonly class="sm-form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="form-phone" class="capitalize t600">联系电话:</label>
                                        <input type="text" id="form-phone" name="form-phone"  v-model="basicinfo.phone" class="sm-form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="form-introcode" class="capitalize t600">邀请码:</label>
                                        <input type="text" id="form-introcode" name="form-introcode" v-model="basicinfo.introcode" class="sm-form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="form-rate" class="capitalize t600">提成比例:</label>
                                        <input type="text" id="form-rate" name="form-rate" v-model="basicinfo.rate" class="sm-form-control" />
                                    </div>
                                </form>
                            </div>
                            <!--<p class="nobottommargin"><small class="t300"><em>* No Credit Card Required</em></small></p>-->
                        </div>
                        <div class="modal-footer" style="border:0px;">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">关闭
                            </button>
                            <button type="button" class="btn btn-primary" @click="update_user_info">
                                提交更改
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div>
</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import Swal from 'sweetalert2'

    export default {
        name: "customeradmin_user_management",
        data() {
            return {
                total:0,
                pagesize:10,
                currentPage:1,
                tableData:[],
                currentUser:{},
                basicinfo:{
                    userid:0,
                    phone:'',
                    email:'',
                    rate:0,
                    introcode:'',
                    type:"basic"
                },
                select:""
            }
        },
        mounted(){
            this.$store.dispatch("system/load_management_info");
            this.$store.dispatch("users/get_customeradmin_users");

            this.tableData=this.allusers;
            this.total=this.allusers.length;

        },
        computed:{
            allusers(){
              return this.$store.state.users.all;
            },
            ...mapGetters({
                // clientlist:"users/selectClientList",
                // rolelist:"users/selectUserRoleList"
            })
        },
        methods:{

            resetSearch(){
                this.tableData=this.allusers;
                this.total=this.tableData.length;
                this.select="";
            },
            querySearchAsync(queryString, cb) {
                var allusers = this.$store.state.users.all;
                console.log("querySearchAsync");
                var results = queryString? allusers.filter(function (user) {
                    return user.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0;
                }):allusers;

                this.tableData=results;
                this.total=results.length;
                cb(results);
            },

            current_change:function(currentPage){
                this.currentPage = currentPage;
            },
            toast_message(message){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                Toast.fire({
                    type: 'success',
                    title: 'Signed in successfully'
                })
            },
            update_user_info(){
                Swal.fire({
                    title: '确认更改用户的信息吗',
                    confirmButtonText: '确认',
                    text: '注意',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return axios.post('/customerAdmin/user/updateUserInfo',this.basicinfo)
                            .then(response => response.data)
                        .then(data => {
                                this.$store.commit("users/update_user_info",data.user)
                                const userIndex=this.tableData.findIndex(user => user.id==data.user.id);

                                if(userIndex > -1){
                                    this.tableData.splice(userIndex,1,data.user);
                                    this.total=this.tableData.length;
                                    $("#myModal").modal("hide");
                                }
                        })
                        .catch((err) => {
                                console.log(err)
                        })
                    }})
            },
            SetUserBasicInfo(user){
                this.currentUser=user;
                this.basicinfo.userid=user.id;
                this.basicinfo.phone=user.phone;
                this.basicinfo.email=user.email;
                this.basicinfo.rate=user.rate;
                this.basicinfo.introcode=user.introcode;
                $("#myModal").modal("show");
            },
        }
    }
</script>

<style scoped>
strong .title{
    display:inline-block;
    width:100px;
}
</style>