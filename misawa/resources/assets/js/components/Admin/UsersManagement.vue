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
                        placeholder="请输入内容"
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
                                <span> <strong class="title">父亲:</strong> {{ props.row.parent.name }}</span>
                                <span><strong>Email:</strong>{{ props.row.email }}</span>
                                <span> <strong>介绍码:</strong> {{ props.row.introcode }}</span>

                                <a href="javascript:void(0);" class="btn btn-info text-danger d-block my-10" @click="SetUserBasicInfo(props.row)">设置基本信息</a>
                                <a href="javascript:void(0);" class="btn btn-danger text-white d-block my-10" @click="RemoveUser(props.row.id)">Remove</a>
                            </div>
                        <div class="col_one_fourth  title-block d-block">
                            <a href="javascript:void(0);" class=" text-danger d-block my-10" @click="SetUserClient(props.row.id)">设置团体</a>
                            <a href="javascript:void(0);" class="text-danger d-block my-10" @click="SetUserRole(props.row.id)">设置角色</a>
                        </div>
                        <div class="col_one_fourth col_last">
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
                        <span v-if="props.row.flag_vendor =='1'"><i class="fa fa-university"></i></span>
                        <span v-if="props.row.roles[0].name=='distributor' " class="text-success">
                            <i class="fa fa-universal-access"></i>Distributor ({{props.row.rate*100}}%)</span>
                        <span v-if="props.row.roles[0].name=='customerAdmin'" class="text-danger">
                             <i class="fa fa-users"></i>DisAdmin ({{props.row.rate*100}}%)
                        </span>
                        <span v-if="props.row.roles[0].name=='customer'" class="text-success">
                             <i class="fa fa-shopping-basket"></i>Customer
                        </span>
                    </template>
                </el-table-column>
                <el-table-column
                        label="团体" sortable
                        prop="client.name">
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
        </div>


</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import Swal from 'sweetalert2'

    export default {
        name: "admin_user_management",
        data() {
            return {
                total:0,
                pagesize:10,
                currentPage:1,
                tableData:[],
                select:""
            }
        },
        mounted(){
            this.$store.dispatch("users/get_all_users");
            this.$store.dispatch("users/load_management_info");
            this.tableData=this.allusers;
            this.total=this.allusers.length;
        },
        computed:{
            allusers(){
              return this.$store.state.users.all;
            },
            ...mapGetters({
                clientlist:"users/selectClientList",
                rolelist:"users/selectUserRoleList"
            })
        },
        methods:{
            resetSearch(){

                this.tableData=this.allusers;
            },
            querySearchAsync(queryString, cb) {
                var users = this.$store.state.users.all;
                console.log("querySearchAsync");
                var results = queryString? users.filter(function (user) {
                    return user.email.toLowerCase().indexOf(queryString.toLowerCase()) === 0 || user.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0;
                }):users;

                this.tableData=results;
                this.total=results.length;
                cb(results);
            },

            current_change:function(currentPage){
                this.currentPage = currentPage;
            },
            replaceUser(_user){
                const userIndex=this.tableData.findIndex(user => user.id==_user.id);

                if(userIndex > -1){
                    this.tableData.splice(userIndex,1,_user);
                    this.total=this.tableData.length;
                }
            },
            update_user_info(params){
                Swal.fire({
                    title: '确认更改用户的信息吗',
                    confirmButtonText: '确认',
                    text: '注意',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return axios.post('/admin/user/updateUserInfo',params)
                            .then(response => response.data)
                        .then(data => {
                                this.$store.commit("users/update_user_info",data.user)
                                this.replaceUser(data.user);
                        })
                        .catch((err) => {
                                console.log(err)
                        })
                    }})
            },
            async SetUserBasicInfo(user){

                const {value: formValues} = await Swal.fire({
                    title: '会员信息',
                    html:
                    '邀请码: <input id="swal-introcode" class="swal2-input" placeholder="'+user.introcode+'" value="'+user.introcode+'">' +
                    '提成比例:<input id="swal-rate" class="swal2-input" placeholder="'+user.introcode+'" value="'+user.rate+'">' +
                    'Email:<input id="swal-email" class="swal2-input" placeholder="'+user.introcode+'" value="'+user.email+'">' +
                    '电话:<input id="swal-phone" class="swal2-input" placeholder="'+user.introcode+'" value="'+user.phone+'">',
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            document.getElementById('swal-introcode').value,
                            document.getElementById('swal-rate').value,
                            document.getElementById('swal-email').value,
                            document.getElementById('swal-phone').value
                        ]
                    }
                });
                console.log(formValues);
                if(formValues !=undefined){
                    const params={
                        userid:user.id,
                        type:'basic',
                        introcode:formValues[0],
                        rate:formValues[1],
                        email:formValues[2],
                        phone:formValues[3],
                    };
                    this.update_user_info(params);

                }
            },
            async SetUserClient(userid){

                const {value: client_id} = await Swal.fire({
                    title: '选择团队',
                    input: 'select',
                    inputOptions:this.clientlist,
                    inputPlaceholder: '选择团队',
                    showCancelButton: true,
                })

                if (client_id>0) {

                    Swal.fire({
                        title: '确认更改用户的团队吗',
                        confirmButtonText: '确认',
                        text: '注意',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                        const params={
                            userid:userid,
                            clientid:client_id,
                            type:'client'
                        }

                        return axios.post('/admin/user/updateUserInfo',params)
                            .then(response => response.data)
                        .then(data => {
                                this.$store.commit("users/update_user_info",data.user)
                                this.replaceUser(data.user);
                        })
                        .catch((err) => {
                                console.log(err)
                        })
                        }})
                }
            },
            async SetUserRole(userid){

                const {value: role_id} = await Swal.fire({
                    title: '选择角色',
                    input: 'select',
                    inputOptions:this.rolelist,
                    inputPlaceholder: '选择角色',
                    showCancelButton: true,
                })

                if (role_id>0) {
                    Swal.fire({
                        title: '确认更改用户的角色吗',
                        confirmButtonText: '确认',
                        text: '注意',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                        const params={
                            userid:userid,
                            roleid:role_id,
                            type:'role'
                        }
                        console.log(params);
                        return axios.post('/admin/user/updateUserInfo',params)
                            .then(response => response.data)
                        .then(data => {
                                this.$store.commit("users/update_user_info",data.user)
                                this.replaceUser(data.user);
                        })
                        .catch((err) => {
                                console.log(err)
                            })
                        }})
                }
            },
            RemoveUser(userid){
                Swal.fire({
                    title: '确定删除会员吗',
                    showCancelButton: true,
                    confirmButtonText: '删除',
                    // showLoaderOnConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        this.$store.dispatch("users/remove_user",userid);
                    }
                })
            }
        }
    }
</script>

<style scoped>
strong .title{
    display:inline-block;
    width:100px;
}
</style>