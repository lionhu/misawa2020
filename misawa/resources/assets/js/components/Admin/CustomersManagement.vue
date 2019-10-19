<template>
        <div class=" nobottommargin">

            <section data-v-5790ee72="" id="page-title" class="page-title-pattern bottommargin-sm">
                <div data-v-5790ee72="" class="container clearfix">
                    <h1 data-v-5790ee72="">客户管理</h1>
                    <span data-v-5790ee72="">My Dear Customers</span>
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
                                <span> <strong class="title">所属渠道:</strong> {{ props.row.user.name }}</span>
                                <span><strong class="title">PostCode:</strong>{{ props.row.postcode }}</span>
                                <span><strong class="title">Address:</strong>{{ props.row.address1 }}</span>
                                <span><strong class="title"> </strong>{{ props.row.address2 }}</span>
                                <span><strong class="title">Phone:</strong>{{ props.row.phone }}</span>
                                <span><strong class="title">Email:</strong>{{ props.row.email }}</span>
                            </div>
                        <div class="col_one_fourth  title-block d-block">
                            <a href="javascript:void(0);" class="btn btn-info text-danger d-block my-10" @click="SetUserBasicInfo(props.row)">设置基本信息</a>
                            <a href="javascript:void(0);" class="btn btn-danger text-white d-block my-10" @click="RemoveUser(props.row.id)">Remove</a>
                        </div>
                        <div class="col_one_fourth col_last">
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="ID" sortable
                        prop="id">
                </el-table-column>
                <el-table-column
                        label="姓名" sortable
                        prop="name">
                    <template slot-scope="props">
                        {{props.row.sex}}{{props.row.name}}
                    </template>
                </el-table-column>
                <el-table-column
                        label="订单">
                    <template slot-scope="props">
                        <el-button type="success" round v-if="props.row.pos.length>0">{{props.row.pos.length}}</el-button>
                        <el-button type="danger" round v-if="props.row.pos.length==0">{{props.row.pos.length}}</el-button>

                    </template>
                </el-table-column>
                <!--<el-table-column-->
                        <!--label="类型" sortable-->
                        <!--prop="flag_vendor">-->

                    <!--<template slot-scope="props">-->
                        <!--<span v-if="props.row.flag_vendor =='1'"><i class="fa fa-university"></i></span>-->
                        <!--<span v-if="props.row.roles[0].name=='distributor' " class="text-success">-->
                            <!--<i class="fa fa-universal-access"></i>Distributor ({{props.row.rate*100}}%)</span>-->
                        <!--<span v-if="props.row.roles[0].name=='customerAdmin'" class="text-danger">-->
                             <!--<i class="fa fa-users"></i>DisAdmin ({{props.row.rate*100}}%)-->
                        <!--</span>-->
                        <!--<span v-if="props.row.roles[0].name=='customer'" class="text-success">-->
                             <!--<i class="fa fa-shopping-basket"></i>Customer-->
                        <!--</span>-->
                    <!--</template>-->
                <!--</el-table-column>-->
                <!--<el-table-column-->
                        <!--label="团体" sortable-->
                        <!--prop="client.name">-->
                <!--</el-table-column>-->
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
        name: "admin_customer_management",
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
            this.$store.dispatch("customers/get_all_customers");
            // this.$store.dispatch("users/load_management_info");
            this.tableData=this.allcustomers;
            this.total=this.allcustomers.length;
        },
        computed:{
            allcustomers(){
              return this.$store.state.customers.all;
            },
            ...mapGetters({
                // clientlist:"users/selectClientList",
                // rolelist:"users/selectUserRoleList"
            })
        },
        methods:{

            resetSearch(){

                this.tableData=this.allcustomers;
                this.select="";
            },
            querySearchAsync(queryString, cb) {
                var customers = this.$store.state.customers.all;
                console.log("querySearchAsync");
                var results = queryString? customers.filter(function (customer) {
                    return customer.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0;
                }):customers;

                this.tableData=results;
                this.total=results.length;
                cb(results);
            },
            current_change:function(currentPage){
                this.currentPage = currentPage;
            },
            update_customer_info(params){
                Swal.fire({
                    title: '确认更改客户的信息吗',
                    confirmButtonText: '确认',
                    text: '注意',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return axios.post('/admin/customer/updateCustomerInfo',params)
                            .then(response => response.data)
                        .then(data => {
                                this.$store.commit("customers/update_customer_info",data.customer)

                                const customerIndex=this.tableData.findIndex(customer => customer.id==params.customerid);

                                if(customerIndex > -1){
                                    this.tableData.splice(customerIndex,1,data.customer);
                                }
                        })
                        .catch((err) => {
                                console.log(err)
                        })
                    }})
            },
            async SetUserBasicInfo(customer){

                const {value: formValues} = await Swal.fire({
                    title: '会员信息',
                    html:
                    '名称: <input id="swal-name" class="swal2-input" placeholder="'+customer.name+'" value="'+customer.name+'">' +
                    '性别: <input id="swal-sex" class="swal2-input" placeholder="'+customer.sex+'" value="'+customer.sex+'">' +
                    '邮编: <input id="swal-postcode" class="swal2-input" placeholder="'+customer.postcode+'" value="'+customer.postcode+'">' +
                    '地址1:<input id="swal-address1" class="swal2-input" placeholder="'+customer.address1+'" value="'+customer.address1+'">' +
                    '地址2:<input id="swal-address2" class="swal2-input" placeholder="'+customer.address2+'" value="'+customer.address2+'">' +
                    'Email:<input id="swal-email" class="swal2-input" placeholder="'+customer.email+'" value="'+customer.email+'">' +
                    '电话:<input id="swal-phone" class="swal2-input" placeholder="'+customer.phone+'" value="'+customer.phone+'">',
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            document.getElementById('swal-name').value,
                            document.getElementById('swal-postcode').value,
                            document.getElementById('swal-address1').value,
                            document.getElementById('swal-address2').value,
                            document.getElementById('swal-email').value,
                            document.getElementById('swal-phone').value,
                            document.getElementById('swal-sex').value,
                        ]
                    }
                })

                if(formValues !=undefined){
                    const params={
                        customerid:customer.id,
                        type:'basic',
                        name:formValues[0],
                        postcode:formValues[1],
                        address1:formValues[2],
                        address2:formValues[3],
                        email:formValues[4],
                        phone:formValues[5],
                        sex:formValues[6]
                    };
                    this.update_customer_info(params);

                }
            },
            // async SetUserClient(userid){
            //
            //     const {value: client_id} = await Swal.fire({
            //         title: '选择团队',
            //         input: 'select',
            //         inputOptions:this.clientlist,
            //         inputPlaceholder: '选择团队',
            //         showCancelButton: true,
            //     })
            //
            //     if (client_id>0) {
            //
            //         Swal.fire({
            //             title: '确认更改用户的团队吗',
            //             confirmButtonText: '确认',
            //             text: '注意',
            //             showLoaderOnConfirm: true,
            //             preConfirm: () => {
            //             const params={
            //                 userid:userid,
            //                 clientid:client_id,
            //                 type:'client'
            //             }
            //
            //             return axios.post('/admin/user/updateUserInfo',params)
            //                 .then(response => response.data)
            //             .then(data => {
            //             this.$store.commit("users/update_user_info",data.user)
            //     })
            //     .catch((err) => {
            //             console.log(err)
            //     })
            //     }})
            //     }
            // },
            // async SetUserRole(userid){
            //
            //     const {value: role_id} = await Swal.fire({
            //         title: '选择角色',
            //         input: 'select',
            //         inputOptions:this.rolelist,
            //         inputPlaceholder: '选择角色',
            //         showCancelButton: true,
            //     })
            //
            //     if (role_id>0) {
            //         Swal.fire({
            //             title: '确认更改用户的角色吗',
            //             confirmButtonText: '确认',
            //             text: '注意',
            //             showLoaderOnConfirm: true,
            //             preConfirm: () => {
            //             const params={
            //                 userid:userid,
            //                 roleid:role_id,
            //                 type:'role'
            //             }
            //
            //             return axios.post('/admin/user/updateUserInfo',params)
            //                 .then(response => response.data)
            //             .then(data => {
            //                     this.$store.commit("users/update_user_info",data.user)
            //             })
            //             .catch((err) => {
            //                     console.log(err)
            //                 })
            //             }})
            //     }
            // },
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