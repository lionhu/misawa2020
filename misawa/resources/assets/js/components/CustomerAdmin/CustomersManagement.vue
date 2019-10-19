<template>
        <div class=" nobottommargin">
            <section data-v-5790ee72="" id="page-title" class="page-title-pattern bottommargin-sm">
                <div data-v-5790ee72="" class="container clearfix">
                    <h1 data-v-5790ee72="">客户管理</h1>
                    <span data-v-5790ee72="">My Customers</span>
                </div>
            </section>

            <div>
                <el-select v-model="pagesize" size="mini" style="width:80px;" placeholder="请选择" class="pull-left">
                    <el-option
                            v-for="item in pagesize_options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>

                <el-autocomplete
                        class="inline-input pull-right"
                        v-model="select"
                        :fetch-suggestions="querySearchAsync"
                        placeholder="请输入客户名称部分内容"
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
                                <span><strong>邮编:</strong>{{ props.row.postcode }}</span>
                                <span><strong>地址:</strong>{{ props.row.address1 }}</span>
                                <span><strong></strong>{{ props.row.address2 }}</span>
                                <span><strong>联系电话:</strong>{{ props.row.phone }}</span>
                                <span><strong>Email:</strong>{{ props.row.email }}</span>
                            </div>
                        <div class="col_one_fourth  title-block d-block">
                            <a href="javascript:void(0);" class="btn btn-info text-danger d-block my-10" @click="SetUserBasicInfo(props.row)">设置基本信息</a>
                            <!--<a href="javascript:void(0);" class="btn btn-danger text-white d-block my-10" @click="RemoveUser(props.row.id)">Remove</a>-->
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
                                客户 {{basicinfo.name}}基本信息
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="col_half hidden-xs" data-height-xl="456" data-height-lg="456" data-height-md="456"
                                 data-height-sm="0" data-height-xs="0"
                                 style="background-image: url(/images/parallax/4.jpg); background-size: cover; height: 456px;"></div>
                            <div class="col_half col_last">
                                <form action="#" class="clearfix" style="max-width: 300px;">

                                    <div class="col_full">
                                        <label for="form-postcode" class="capitalize t600">邮编:</label>
                                        <input type="text" id="form-postcode" name="form-postcode" v-model="basicinfo.postcode" class="sm-form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="form-address1" class="capitalize t600">地址1:</label>
                                        <input type="text" id="form-address1" name="form-address1" v-model="basicinfo.address1" class="sm-form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="form-address2" class="capitalize t600">地址2:</label>
                                        <input type="text" id="form-address2" name="form-address2" v-model="basicinfo.address2" class="sm-form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="form-phone" class="capitalize t600">联系电话:</label>
                                        <input type="text" id="form-phone" name="form-phone"  v-model="basicinfo.phone" class="sm-form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="form-email" class="capitalize t600">邮箱:</label>
                                        <input type="email" id="form-email" name="form-email" v-model="basicinfo.email"  class="sm-form-control" />
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
        name: "customeradmin_customer_management",
        data() {
            return {
                total:0,
                pagesize:10,
                pagesize_options: [
                    {value: '10', label: '10'},
                    {value: '50', label: '50'},
                    {value: '100', label: '100'}],
                currentPage:1,
                tableData:[],
                currentCustomer:{},
                basicinfo:{
                    customerid:0,
                    phone:'',
                    email:'',
                    postcode:"",
                    address1:'',
                    address2:""
                },
                select:""
            }
        },
        mounted(){
            this.$store.dispatch("customers/get_customeradmin_customers");

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
                var allcustomers = this.$store.state.customers.all;
                console.log("querySearchAsync");
                var results = queryString? allcustomers.filter(function (customer) {
                    return customer.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0;
                }):allcustomers;

                this.tableData=results;
                this.total=results.length;
                cb(results);
            },

            current_change:function(currentPage){
                this.currentPage = currentPage;
            },
            update_user_info(){
                var vm=this;
                Swal.fire({
                    title: '确认更改客户的信息吗',
                    confirmButtonText: '确认',
                    text: '注意',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return axios.post('/customerAdmin/customer/update',this.basicinfo)
                            .then(response => response.data)
                        .then(data => {
                                vm.$store.commit("customers/update_customer_info",data.customer)

                                const customerIndex=vm.tableData.findIndex(customer => customer.id==data.customer.id);

                                if(customerIndex > -1){
                                    vm.tableData.splice(customerIndex,1,data.customer);
                                    vm.total=vm.tableData.length;
                                }
                                $("#myModal").modal("hide");
                        })
                        .catch((err) => {
                                console.log(err)
                        })
                    }})
            },
            SetUserBasicInfo(customer){
                this.currentCustomer=customer;
                this.basicinfo.customerid=customer.id;
                this.basicinfo.phone=customer.phone;
                this.basicinfo.email=customer.email;
                this.basicinfo.postcode=customer.postcode;
                this.basicinfo.address1=customer.address1;
                this.basicinfo.address2=customer.address2;
                $("#myModal").modal("show");
            },
        },
        watch:{
            pagesize(from,to){
                console.log(this.pagesize);
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