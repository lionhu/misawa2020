<template>
        <div class=" nobottommargin">
            <section data-v-5790ee72="" id="page-title" class="page-title-pattern bottommargin-sm">
                <div data-v-5790ee72="" class="container clearfix">
                    <h1 data-v-5790ee72="">订单</h1>
                    <span data-v-5790ee72="">All POS</span>
                </div>
            </section>
            <div style="margin-top: 15px;" class="container">
                <div class="row">
                    <div class="col-6">
                        <a class="box box-link-pop text-center" href="javascript:void(0)">
                            <div class="box-body py-25 bg-light">
                                <p class="font-weight-600">{{type_filter}}</p>
                            </div>
                            <div class="box-body">
                                <p class="font-size-40">
                                    <strong>{{total}}</strong>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a class="box box-link-pop text-center" href="javascript:void(0)">
                            <div class="box-body py-25 bg-light">
                                <p class="font-weight-600">Unpaid</p>
                            </div>
                            <div class="box-body">
                                <p class="font-size-40">
                                    <strong>{{unpaid_vendor}}</strong>
                                </p>
                            </div>
                        </a>
                    </div>


                </div>
                <div class="row">
                    <div class="col-6">
                        <el-autocomplete
                                class="inline-input "
                                v-model="select"
                                :fetch-suggestions="querySearchAsync"
                                placeholder="请输入客人姓名"
                                :trigger-on-focus="false">
                            <el-button slot="append"  @click="resetSearch">Reset</el-button>
                        </el-autocomplete>
                    </div>
                    <div class="col-6 clearfix ">
                        <el-select v-model="type_filter" placeholder="请选择" @click="loadPOsOfType">
                            <el-option
                                    v-for="item in type_filters"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select></div>

                </div>
            </div>
            <el-table
                    ref="filterTable"
                    :data="tableData"
                    style="width: 100%"
                    @selection-change="SelectionChange"
                    :default-sort="{prop: 'id', order: 'descending'}">
                <el-table-column type="expand">
                    <template slot-scope="props">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="box bg-success-gradient">
                                    <div class="box-header with-border">
                                        <h4 class="box-title"><strong>Customer Information</strong></h4>
                                        <div class="box-tools pull-right">
                                            <ul class="box-controls">
                                                <li><a class="box-btn-close" href="#"></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <span class="title">日期:</span>{{props.row.created_at}} <br>
                                        <span class="title">顾客:</span>{{props.row.customer.name}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <div class="box bg-secondary-gradient">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <strong>当前状态:</strong>
                                            <a href="javascript:void(0);" class="btn  btn-success btn-xs" @click="ChangeStatus(props.row)">
                                                <span class="" style="display:inline-block;width:80px;margin-left:10px;">{{props.row.status}}</span>
                                            </a>
                                        </h4>
                                        <div class="box-tools pull-right">
                                            <ul class="box-controls">
                                                <li><a class="box-btn-close" href="#"></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <span class="title ">渠道商:</span><a href="javascript:void(0);"  class="btn  btn-success btn-xs"  @click="ChangeUser(props.row)"><strong>{{props.row.user.name}}</strong></a>
                                        <span class="title ">Vendor:</span><a href="javascript:void(0);"  class="btn  btn-primary btn-xs"  @click="ChangeVendor(props.row)"><strong>{{props.row.vendor.name}}</strong></a>

                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="col_half col_last clearfix">

                            <p class="nobottommargin" v-if="props.row.status !=='new'">
                                <span class="title">快递单号:</span><a href="javascript:void(0);" @click="ChangeDeliveryNo(props.row)" class="btn  btn-info btn-xs">
                                <i class="icon-truck"></i>{{props.row.delivery_no}}
                                </a>
                            </p>
                            <p> <span class="title">Memo:</span>{{props.row.memo}}</p>
                        </div>
                        <table class="table cart d-block d-sm-none">
                            <thead>
                            <tr>
                                <th class=""></th>
                            </tr>
                            </thead>
                            <tbody>
                            <cartitem v-for="item in props.row.cartitems" :key="item.id+'_'+item.product.id" device="xs"
                                      :cartitem="item"></cartitem>
                            </tbody>

                        </table>
                        <div class="table-responsive d-none d-sm-block">
                            <table class="table table-hover">
                                <tr>
                                    <th></th>
                                    <th>产品</th>
                                    <th>单价</th>
                                    <th>总计</th>
                                </tr>
                                <tr v-for="cartitem in props.row.cartitems">
                                    <td><a href="javascript:void(0)">
                                        <img width="64" height="64" :src="'/'+cartitem.product.thumbimage">
                                    </a></td>
                                    <td>
                                            {{cartitem.product.name}}(#{{cartitem.product.id}}) <br>
                                        <span class="badge bg-green">{{cartitem.qty}}</span>
                                    </td>
                                    <td>
                                        <span> <strong class="title">代理价：</strong>{{cartitem.dis_price | currency_rmb}}</span> <br>
                                        <span> <strong class="title">代理价：</strong>{{cartitem.dis_j_price | currency_rmb}}</span> <br>
                                        <span> <strong class="title">药房价：</strong>{{cartitem.r_price | currency_jpy}}</span>
                                    </td>
                                    <td>
                                        <span class="amount">{{cartitem.dis_price*cartitem.qty | currency_rmb}}</span><br>
                                        <span class="amount">{{cartitem.dis_j_price*cartitem.qty | currency_rmb}}</span><br>
                                        <span class="amount">{{cartitem.r_price*cartitem.qty | currency_jpy}}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="box clearfix">
                            <div class="row no-gutters py-2">

                                <div class="col-sm-6 col-lg-4">
                                    <div class="box-body br-1 border-light">
                                        <div class="flexbox mb-1">
                                              <span>
                                                <i class="ion-person font-size-26"></i><br>
                                                总数量
                                                </span>
                                            <span class="text-primary font-size-30">{{ props.row.cart_Qty }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="box-body br-1 border-light">
                                        <div class="flexbox mb-1">
                                              <span>
                                                <i class="ion-person font-size-26"></i><br>
                                                代理商总价(元)
                                                </span>
                                            <span class="text-primary font-size-30">{{ props.row.cart_Dis_Price |currency}}({{ props.row.cart_Dis_J_Price |currency}})</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="box-body br-1 border-light">
                                        <div class="flexbox mb-1">
                                              <span>
                                                <i class="ion-person font-size-26"></i><br>
                                                药房总价(円)
                                                </span>
                                            <span class="text-primary font-size-30">{{ props.row.cart_R_Price |currency}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <a href="javascript:void(0);" class="btn btn-danger text-white w-25 my-10" @click="RemovePO(props.row.id)" v-if="props.row.status=='new'">
                                <i class="icon-trash-alt"></i>删除</a>
                        </div>

                        <div class="row">
                            <a :href="'/admin/pos/print_VendorPO/'+props.row.id" class="btn btn-info text-white w-25 mr-10">
                                <i class="icon-file-pdf"></i>打印药房订单
                            </a>
                            <a :href="'/admin/pos/printPO/'+props.row.id" class="btn btn-info text-white w-25 mr-10">
                                <i class="icon-file-pdf"></i>打印客户订单
                            </a>
                            <a href="javascript:void(0);" class="btn btn-success text-white w-25 mr-10" @click="ResendNotification(props.row)">
                                <i class="icon-file-pdf"></i>发送邮件通知
                            </a>
                        </div>

                    </template>
                </el-table-column>
                <el-table-column
                        type="selection" width="50">
                </el-table-column>
                <el-table-column
                        label="ID" sortable
                        prop="id">
                    <template slot-scope="props">
                        <span class="inline-block center">#{{props.row.id}}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Vendor" sortable class="hidden-xs"
                        prop="vendor.name">
                    <template slot-scope="props">
                        <div class="center">{{props.row.customer.name}} <br> ({{props.row.user.name}})</div>
                        <span class="d-block center">{{props.row.vendor.name}}</span>
                    </template>
                </el-table-column>


                <el-table-column width="150"
                                 label="Payment" class="visible-xs">
                    <template slot-scope="props">
                        <div>
                            <a href="javascript:void(0);" class="btn " @click="updatePayment(props.row)"
                               :class="{'btn-success':props.row.paid_customer=='1','btn-secondary':props.row.paid_customer!=='1'}">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn " @click="updatePayment(props.row)"
                               :class="{'btn-success':props.row.paid_vendor=='1','btn-secondary':props.row.paid_vendor!=='1'}">
                                <i class="fa fa-institution" aria-hidden="true"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn " @click="updatePayment(props.row)"
                               :class="{'btn-success':props.row.paid_margin=='1','btn-secondary':props.row.paid_margin!=='1'}">
                                <i class="fa fa-fw fa-money"></i>
                            </a>
                        </div>
                        <p style="font-size:8px;">{{props.row.created_at}}</p>
                    </template>
                </el-table-column>
                <el-table-column
                        label="锁定">
                    <template slot-scope="props">
                        <a class="btn  bg-red" v-if="props.row.locked" @click="LockPO(props.row)">
                            <i class="icon-lock"></i>
                        </a>
                        <a class="btn  bg-teal" v-if="!props.row.locked" @click="LockPO(props.row)">
                            <i class="fa fa-unlock"></i>
                        </a>
                    </template>
                </el-table-column>

                <el-table-column
                        label="利润">
                    <template slot-scope="props">
                        <span class="d-block">{{props.row.cart_Dis_Price | currency_rmb}}</span>
                        <span class="d-block">{{props.row.cart_Dis_J_Price | currency_jpy}}</span>
                        <span class="d-block">{{props.row.cart_R_Price|currency_jpy}}</span>
                        <a href="javascript:void(0);" @click="ProfitAdjust(props.row)">
                            <span class="badge " :class="{'badge-danger':props.row.P_Adjust=='1','badge-success':props.row.P_Adjust!='1'}">
                            {{props.row.cart_Dis_J_Price-props.row.cart_R_Price|currency_jpy}}
                            </span>
                        </a>

                    </template>
                </el-table-column>
                <el-table-column
                        label="Status" sortable
                        prop="status">
                    <template slot-scope="props">

                        <button class="btn btn-block btn-social btn-foursquare" v-if="props.row.status=='new'">
                            <i class="fa fa-bullhorn"></i>
                            <span class="pull-right">N</span>
                        </button>

                        <button class="btn btn-block btn-social btn-soundcloud" @click="ChangeDeliveryNo(props.row)" v-if="props.row.status=='processing'">
                            <i class="fa fa-gear fa-spin"></i>
                            <span class="pull-right">P</span>
                        </button>

                        <button class="btn btn-block btn-social btn-dropbox" @click="ChangeDeliveryNo(props.row)" v-if="props.row.status=='Delivering'">
                            <i class="fa fa-truck"></i>
                            <span class="pull-right">D</span>
                        </button>

                        <button class="btn btn-block btn-social btn-yahoo" @click="checkEMS(props.row)" v-if="props.row.status=='completed'">
                            <i class="fa fa-flag"></i>
                            <span class="pull-right">F</span>
                        </button>


<!--                        <a href="javascript:void(0);" class="btn button-amber text-white"-->
<!--                           v-if="props.row.status=='processing'"><i class="icon-time"></i></a>-->

<!--                        <a href="javascript:void(0);" @click="ChangeDeliveryNo(props.row)"-->
<!--                           class="button button-3d button-mini button-rounded button-aqua" v-if="props.row.status=='Delivering'">-->
<!--                            <i class="icon-truck"></i>{{props.row.delivery_no}}</a>-->
<!--                        -->
<!--                        -->
<!--                        -->
<!--                        <a href="javascript:void(0);" class="btn button-green text-white"-->
<!--                           v-if="props.row.status=='completed'"><i class="icon-checkmark"></i>{{props.row.delivery_no}}</a>-->
                    </template>
                </el-table-column>
            </el-table>
        </div>
</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import Swal from 'sweetalert2'
    import functions from '../../api/functions'
    import cartitem from "./parts/CartItem_readonly"

    export default {
        name: "superadmin_pos",
        components:{
            cartitem
        },
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
                currentUser:{},
                editPO:{
                    id:0,
                  paid_customer:0,
                  paid_vendor:0,
                  paid_margin:0,

                },
                type_filters: [
                    {value: 'new', label: '新订单'},
                    {value: 'processing', label: '药房处理中'},
                    {value: 'Delivering', label: '快递中'},
                    {value: 'completed', label: '完成'},
                    {value: 'all', label: '全部'}],
                receiver:{
                    "superadmin":"超级管理员",
                    "customeradmin":"渠道管理员",
                    "distributor":"渠道经销商",
                    "customer":"最终用户",
                    "vendor":"药房"
                },
                messageType:{
                    "new":"新订单通知",
                    "Order2Vendor":"订单通知药房",
                    "OrderDeliverPackage":"订单快递通知",
                    "OrderCompleted":"订单完成"
                },
                select:"",
                multiselected:[],
                type_filter:"new",
                showme:false
            }
        },
        mounted(){
            this.loadPOsOfType()
            // this.$store.dispatch("pos/get_superadmin_allpos");
            this.$store.dispatch("system/load_management_info");


        },
        computed:{
            allpos(){
              return this.$store.state.pos.all;
            },
            jpyrate(){
                return this.$store.state.pos.rate;
            },
            unpaid_vendor(){
                if(this.multiselected !=null && this.multiselected !=undefined){
                    if(this.multiselected.length){
                        return this.multiselected.reduce(function (result, currentValue) {
                            var unpaid=currentValue.paid_vendor=='1'?false:true;
                            return result +=unpaid?parseInt(currentValue.cart_R_Price):0;
                        },0)
                    }
                }

                return 0;

            }
        },
        methods:{
            loadPOsOfType(){
                console.log(this.type_filter)
                    axios.post('/admin/pos/ofStatus',{
                        status:this.type_filter
                    }).then(({ data }) => {

                        if(data.pos!=null || data.pos !=undefined && data.pos.length>0){
                            data.pos.forEach(function(po){
                                po.locked= po.locked =='1'?true:false;
                            });

                            this.tableData=data.pos;
                            this.total= data.pos.length;
                            this.showme=true;
                        }else {
                            this.tableData=[];
                            this.total= 0;
                            this.showme=false;
                        }

                })
            },
            batchPayVendor(){
                console.log(this.multiselected)
              if (this.multiselected){
                  const params={
                      batchPayVendorPOS:this.multiselected,
                      type:"batchPayvendor"
                  }
                  const url='/admin/pos/updatePOInfo';
                  this.sync_update_po("批量支付药房订单款项吗？","",params,url)
              }
            },
            SelectionChange(val){
                this.multiselected=val;
                functions.ShowMessage("info","未支付药房金额："+this.unpaid_vendor)
            },
            toggleSelection(rows){
              if(rows){
                  rows.foreach(row=>{
                      this.$refs.filterTable.toggtoggleSelection(row)
                  })
              }  else{
                  this.$refs.filterTable.clearSelection();
              }
            },
            resetSearch(){

                this.tableData=this.allpos;
                this.select="";
            },
            querySearchAsync(queryString, cb) {
                var pos = this.$store.state.pos.all;
                console.log("querySearchAsync");
                var results = queryString? pos.filter(function (po) {
                    return po.customer.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0;
                }):pos;

                this.tableData=results;
                this.total=results.length;
                cb(results);
            },
            createStateFilter(queryString) {
                console.log(queryString);
                return (state) => {
                    console.log(state.customer.name)
                    return (state.customer.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
                };
            },
            filterHandler(value, row, column) {
                const property = column['property'];
                return row[property] === value;
            },
            checkEMS(value){

              var href= "https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1="+value+"&x=18&y=11";
                window.open(href,value);
              },
            current_change:function(currentPage){
                this.currentPage = currentPage;
            },
            RemovePO(poid){
                Swal.fire({
                    title: '确认删除订单吗？ID: '+ poid,
                    confirmButtonText: '确认',
                    text: '注意',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                    return axios.post('/admin/pos/delete',{poid:poid})
                        .then(response => response.data)
                        .then(data => {
                            console.log(data)
                            this.$store.commit("pos/set_remove_mypo",poid)
                            const removeIndex=this.tableData.findIndex(po =>po.id==poid);
                            if(removeIndex > -1){
                                this.tableData.splice(removeIndex,1);
                            }
                        })
                        .catch((err) => {
                                console.log(err)
                        })
                }})
            },

            async ChangeVendor(po){
                var arr = new Array();

                if(this.$store.state.system.vendorlist.length > 0){
                    var jsonData = {};
                    this.$store.state.system.vendorlist.forEach(function (vendor) {
                        var value=vendor.id;
                        jsonData[value]=vendor.name
                    });
                }
                console.log(jsonData);

                const {value: vendor_id} = await Swal.fire({
                    title: '选择订单 (#'+po.id+')的供货商',
                    input: 'select',
                    inputOptions:jsonData,
                    inputPlaceholder: '选择供货商',
                    showCancelButton: true,
                })

                const params={
                    poid:po.id,
                    vendorid:vendor_id,
                    type:"vendor"
                }
                console.log(params)
                const url='/admin/pos/updatePOInfo';
                this.sync_update_po("确认更改订单 (#"+po.id+") 的供货商吗","",params,url)
            },

            async ChangeStatus(po){
                const {value: _status} = await Swal.fire({
                    title: '选择订单(#'+po.id+')的状态',
                    input: 'select',
                    inputOptions:{
                        'new': '新订单',
                        'processing':'药房处理中',
                        'Delivering': '快递中',
                        'completed': '完成',
                        'all': '全部'
                    },
                    inputPlaceholder: '选择状态',
                    showCancelButton: true,
                });

                console.log(_status)
                if(_status !=undefined){
                    var params={
                        poid:po.id,
                        status:_status,
                        type:"status"
                    }

                    if(_status=="Delivering"){
                        const {value: _delivery_no} = await Swal.fire({
                            title: '输入订单 (#'+po.id+')的快递单号',
                            input: 'text',
                            inputValue: po.delivery_no?po.delivery_no:"",
                            showCancelButton: true,
                            inputValidator: (value) => {
                                if (value<0) {
                                return 'You need to write something!'
                            }
                        }
                        })
                        params.delivery_no=_delivery_no;
                    }

                    const url='/admin/pos/updatePOInfo';
                    console.log(params)
                    this.sync_update_po("确认更改订单 (#"+po.id+") 的状态吗","新状态为："+_status,params,url)
                }

            },

            async LockPO(po){

                const checked_str=po.locked?"checked":"";

                var htmlstr='<div class="checkbox"><input type="checkbox" '+ checked_str +' id="swal-input1" class="swal2-input">'+
                    '<label for="swal-input1">锁住订单</label></div>'

                const {value: accept} = await Swal.fire({
                    title: 'Locked?',
                    html:htmlstr,
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            document.getElementById('swal-input1').checked
                        ]
                    }
                })
                    console.log(accept[0])
                    const params={
                        poid:po.id,
                        locked:accept[0],
                        type:"locked"
                    }
                    const url='/admin/pos/updatePOInfo';
                    this.sync_update_po("确认更改订单 (#"+po.id+") 的锁住状态吗","",params,url)
            },

            async ChangeUser(po){
                console.log(po)
                this.editPO = po;

                const {value: user_id} = await
                Swal.fire({
                    title: '选择订单(#' + po.id + ')的用户',
                    input: 'text',
                    inputValue: po.user_id,
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if(value < 0){
                            return 'You need to write something!'
                        }
                    }
                })

                if (user_id > 0) {

                    const params = {
                        poid: po.id,
                        user_id: user_id,
                        type: "user"
                    }

                    const url = '/admin/pos/updatePOInfo';
                    this.sync_update_po("确认更改订单的用户吗", "新用户ID：" + user_id, params, url)

                }
            },

            async ChangeDeliveryNo(po){
                var href = '<a href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1=' + po.delivery_no + '&x=18&y=11" class="button button-3d button-mini button-rounded button-aqua"><strong>物流の確認</strong></a>'
                const {value: _delivery_no} = await
                Swal.fire({
                    title: '输入订单 (#' + po.id + ')的快递单号',
                    input: 'text',
                    html: href,
                    inputValue: po.delivery_no,
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if(value < 0){
                            return 'You need to write something!'
                        }
                    }
                })

                if (_delivery_no !== '' && _delivery_no != undefined) {

                    const params = {
                        poid: po.id,
                        delivery_no: _delivery_no,
                        type: "delivery_no"
                    }

                    const url = '/admin/pos/updatePOInfo';
                    this.sync_update_po("确认更改订单 (#" + po.id + ") 的快递单号吗", "新订单号为：" + _delivery_no, params, url)

                }
            },

            async updatePayment(po){
                var customer_paid=po.paid_customer=="1"?"checked":"";
                var vendor_paid=po.paid_vendor=="1"?"checked":"";
                var margin_paid=po.paid_margin=="1"?"checked":"";

                var htmlstr='<div class="checkbox"><input type="checkbox" '+ customer_paid +' id="swal-input1" class="swal2-input">'+
                    '<label for="swal-input1">Customer Paid</label></div>';
                 htmlstr +='<div class="checkbox"><input type="checkbox" '+ vendor_paid +' id="swal-input2" class="swal2-input">'+
                    '<label for="swal-input2">Vendor Paid</label></div>';
                 htmlstr +='<div class="checkbox"><input type="checkbox" '+ margin_paid +' id="swal-input3" class="swal2-input">'+
                    '<label for="swal-input3">Margin Paid</label></div>';

                            const {value: formValues} = await Swal.fire({
                                title: 'Payment',
                                html:htmlstr,
                                focusConfirm: false,
                                preConfirm: () => {
                                return [
                                    document.getElementById('swal-input1').checked,
                                    document.getElementById('swal-input2').checked,
                                    document.getElementById('swal-input3').checked
                                ]}
                            })

                            // console.log(this.editPO.id);
                            console.log(formValues);
                            const params={
                                poid:po.id,
                                paid_customer:formValues[0]?1:0,
                                paid_vendor:formValues[1]?1:0,
                                paid_margin:formValues[2]?1:0,
                                type:"payment"
                            }
                            const url='/admin/pos/updatePOInfo';
                            this.sync_update_po("确认更改订单 (#"+po.id+") 的支付状态吗","",params,url)

            },

            ResendNotification(po){
                Swal.mixin({
                    input: 'select',
                    confirmButtonText: 'Next &rarr;',
                    showCancelButton: true,
                    progressSteps: ['1', '2']
                }).queue([
                    {title: '通知接受者选择',
                        text: '选择介绍通知的人员',
                        inputOptions:this.receiver,
                        inputPlaceholder: '选择接受人员',
                    },
                    {title: '通知类型',
                        text: '选择需要发送的通知类型',
                        inputOptions: this.messageType,
                        inputPlaceholder: '选择通知类型',
                    }
                ]).then((result) => {
                    if (result.value) {
                    const params={
                        "poid":po.id,
                        "receiver":result.value[0],
                        "messageType":result.value[1]
                    };

                    axios.post("/admin/pos/resentMail",params)
                        .then(response => response.data)
                        .then(data => {
                                console.log(data);
                            if(data.result=="OK"){
                                Swal.fire({
                                    type: 'success',
                                    title: '成功发送通知邮件',
                                    text: '发送 '+result.value[1] +'通知给 '+result.value[0]
                                })
                            }
                        })
                        .catch((err) => {
                                console.log(err)
                        });
                        }
                    })
            },
            ProfitAdjust(po){
                Swal.mixin({
                    input: 'text',
                    confirmButtonText: 'Next &rarr;',
                    showCancelButton: true,
                    progressSteps: ['1', '2']
                }).queue([
                    {title: '渠道价格调整',
                        text: '请输入调整后的渠道价格',
                        inputPlaceholder: po.cart_B_Price,
                    },
                    {title: '调整理由',
                        text: '请输入价格调整理由',
                    }
                ]).then((result) => {
                    if (result.value) {
                    const params={
                        "poid":po.id,
                        "cart_Dis_Price":result.value[0],
                        "memo":result.value[1],
                        "type":"P_Adjust"
                    };

                    axios.post("/admin/pos/updatePOInfo",params)
                        .then(response => response.data)
                        .then(data => {
                                console.log(data);
                            if(data.result=="OK"){
                                this.$store.commit("pos/update_po",data.po)
                                this.sync_lastest_po(data.po);
                            }
                        })
                        .catch((err) => {
                                console.log(err)
                        });
                    }
                })
            },
            sync_update_po(msg,sub_msg,params,url){

                Swal.fire({
                    title: msg,
                    confirmButtonText: '确认',
                    text: sub_msg,
                    showLoaderOnConfirm: true,
                    preConfirm: () => {

                    return axios.post(url,params)
                        .then(response => response.data)
                    .then(data => {
                        if(params.type !="batchPayvendor"){
                            this.$store.commit("pos/update_po",data.po)
                            this.sync_lastest_po(data.po);

                        }else{
                                this.$store.commit("pos/set_all_pos",data);
                                this.tableData=data.pos;
                                this.total=this.tableData.length;

                        }
                    })
                    .catch((err) => {
                            console.log(err)
                        })
                    }})
            },
            sync_lastest_po(updated_po){
                var updatePOIndex=this.tableData.findIndex(po=>po.id ==updated_po.id);

                updated_po.locked= updated_po.locked =='1'?true:false;
                if(updatePOIndex >-1){
                    console.log("update this po:"+updated_po.id+" index: "+updatePOIndex);
                    this.tableData.splice(updatePOIndex,1,updated_po)
                }
            }
        },
        watch:{
            type_filter(){
                this.loadPOsOfType()
            }
        }
    }
</script>

<style scoped>
strong .title{
    display:inline-block;
    width:100px;
}
    .title-block span strong{
        display: inline-block;
        width: 110px;
    }
    .btn-secondary {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .btn{
        padding:3px 6px;
    }
.swal2-input.checkbox{
     opacity: 100;
}
    p.title{
        display: inline-block;
        width: 100px;
        margin-right: 10px;
    }



</style>