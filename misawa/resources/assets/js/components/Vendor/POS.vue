<template>
        <div class=" nobottommargin">
            <section data-v-5790ee72="" id="page-title" class="page-title-pattern bottommargin-sm">
                <div data-v-5790ee72="" class="container clearfix">
                    <h1 data-v-5790ee72="">注文一覧</h1>
                    <span data-v-5790ee72="">All POS</span>
                    <button class="button button-amber pull-right">未払金額合計：{{unpaid_vendor|currency_jpy}}</button>
                </div>
            </section>
            <div style="margin-top: 15px;" class="container">
                <div class="col_full">
                    <el-alert
                            title="ダウンロードデータ情報"
                            type="success"
                            :description="type_filter+' Record total:'+total"
                            v-if="showme"
                            show-icon>
                    </el-alert>
                </div>
                <div class="col_half">
                    <button class="button button-amber pull-left" @click="Unpaid_POS">未払注文一覧</button>
                </div>
                <div class="col_half col_last pull-right ">
                    <el-select v-model="type_filter" placeholder="ステータス" @click="loadPOsOfType">
                        <el-option
                                v-for="item in type_filters"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
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

                        <h4 class="nobottommargin"> ステータス:
                            <a href="javascript:void(0);" class="button button-mini">
                                <span class="" style="display:inline-block;width:80px;margin-left:10px;">{{props.row.status}}</span>
                            </a>
                        </h4>

                        <p class="nobottommargin">
                            <span class="title">日付:</span>{{props.row.created_at}}
                        </p>
                        <p class="nobottommargin">
                            <span class="title">顧客:</span>{{props.row.customer.name}}
                        </p>
                        <p class="nobottommargin" v-if="props.row.status !=='new'">
                            <span class="title">EMS:</span>
                            <a href="javascript:void(0);" @click="ChangeDeliveryNo(props.row)"
                               class="button button-3d button-mini button-rounded button-aqua">
                            <i class="icon-truck"></i>{{props.row.delivery_no}}
                        </a>
                        </p>
                        <table class="table cart visible-xs">
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
                        <table class="table cart hidden-xs">
                            <thead>
                            <tr>
                                <th class="cart-product-thumbnail"></th>
                                <th class="cart-product-name">製品</th>
                                <th class="cart-product-price ">単価</th>
                                <th class="cart-product-quantity ">数量</th>
                                <th class="cart-product-subtotal ">小計</th>
                            </tr>
                            </thead>
                            <tbody>
                                <cartitem v-for="item in props.row.cartitems" :key="item.id+'_'+item.product.id" device="md" :cartitem="item"></cartitem>
                            </tbody>

                        </table>
                        <div class="col_half title-block d-block">
                            <span><strong>数量:</strong>{{ props.row.cart_Qty }}</span>
                            <span> <strong>総額:</strong> {{ props.row.cart_R_Price |currency_jpy}}</span>

                        </div>
                        <div class="col_one_fourth  title-block d-block">
                            <a :href="'/vendor/pos/printPO/'+props.row.id" class="btn btn-info text-danger d-block my-10">
                                <i class="icon-file-pdf"></i>注文印刷
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
                        #{{props.row.id}}
                    </template>
                </el-table-column>
                <el-table-column
                        label="注文日" sortable
                        prop="created_at">
                </el-table-column>
                <el-table-column
                        label="顧客" sortable
                        prop="customer.name">
                </el-table-column>
                <el-table-column
                                 label="金額">
                    <template slot-scope="props">
                        {{props.row.cart_R_Price|currency_jpy}}
                    </template>
                </el-table-column>

                <el-table-column width="150"
                        label="支払い" class="visible-xs">
                    <template slot-scope="props">
                            <a href="javascript:void(0);" class="btn "
                               :class="{'btn-success':props.row.paid_vendor=='1','btn-secondary':props.row.paid_vendor!=='1'}">
                                <i class="icon-line-command"></i>
                            </a>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Status" sortable fixed="right" prop="status">
                    <template slot-scope="props">

                        <a href="javascript:void(0);" class="btn button-red text-white"
                           v-if="props.row.status=='new'"><i class="icon-line-paper-clip"></i></a>
                        <a href="javascript:void(0);" class="btn button-amber text-white" @click="ChangeDeliveryNo(props.row)"
                           v-if="props.row.status=='processing'"><i class="icon-time"></i></a>

                        <a href="javascript:void(0);" @click="ChangeDeliveryNo(props.row)"
                           class="button button-3d button-mini button-rounded button-aqua" v-if="props.row.status=='Delivering'">
                            <i class="icon-truck"></i>{{props.row.delivery_no}}</a>
                        <a href="javascript:void(0);" class="btn button-green text-white" @click="checkEMS(props.row.delivery_no)"
                           v-if="props.row.status=='completed'"><i class="icon-checkmark"></i>{{props.row.delivery_no}}</a>
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
                type_filters: [
                    {value: 'processing', label: '処理中'},
                    {value: 'Delivering', label: '輸送中'},
                    {value: 'completed', label: '完了'},
                    {value: 'all', label: '全部'}],
                multiselected:[],
                type_filter:"processing",
                showme:false
            }
        },
        mounted(){
            this.tableData=[];
            this.total= 0;
            this.loadPOsOfType()

            // this.$store.dispatch("pos/get_vendor_allpos");
            // this.tableData=this.allpos;
            // this.pagesize= this.tableData.length;
            // this.total= this.tableData.length;

        },
        computed:{
            // allpos(){
            //   return this.$store.state.pos.all;
            // },
            unpaid_vendor(){
                if(this.tableData!==null && this.tableData.length){
                    return this.tableData.reduce(function (result, currentValue) {
                        var unpaid=currentValue.paid_vendor=='1'?false:true;
                        return result +=unpaid?parseInt(currentValue.cart_R_Price):0;
                    },0)
                }else{
                    return 0;
                }

            },
            unpaid_vendor_selected(){

                if(this.multiselected!==null && this.multiselected.length){
                    return this.multiselected.reduce(function (result, currentValue) {
                        var unpaid=currentValue.paid_vendor=='1'?false:true;
                        return result +=unpaid?parseInt(currentValue.cart_R_Price):0;
                    },0)
                }else{
                    return 0;
                }


            }
        },
        methods:{
            loadPOsOfType(){
                console.log(this.type_filter)
                axios.post('/vendor/pos/ofStatus',{
                    status:this.type_filter
                }).then(({ data }) => {

                    if(data.pos !=null || data.pos !=undefined){
                        this.tableData=data.pos;
                        this.total= this.tableData.length;
                        this.showme=true;
                    }else{
                        this.tableData=[];
                        this.total= 0;
                        this.showme=false;
                    }

                })
            },
            Unpaid_POS(){
                axios.post('/vendor/pos/ofStatus',{
                    status:"unpaid"
                }).then(({ data }) => {

                    this.tableData=data.pos;
                this.total= this.tableData.length;
                this.showme=true;
            })
            },
            SelectionChange(val){
                this.multiselected=val;
                functions.ShowMessage("info","未払い金額合計："+this.unpaid_vendor_selected)

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

            async ChangeDeliveryNo(po){
                var href= '<a href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1='+po.delivery_no+'&x=18&y=11" class="button button-3d button-mini button-rounded button-aqua"><strong>物流の確認</strong></a>'
                var htmlstr=po.delivery_no !==""?href:"";

                const {value: _delivery_no} = await Swal.fire({
                    title: '注文 (#'+po.id+')のEMS番号',
                    input: 'text',
                    html:htmlstr,
                    inputValue: po.delivery_no,
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (value<0) {
                            return 'You need to write something!'
                        }
                    }
                })

                if (_delivery_no !==''&& _delivery_no !=undefined ) {

                    const params={
                        poid:po.id,
                        delivery_no:_delivery_no,
                        type:"delivery_no"
                    }

                    const url='/vendor/pos/setEMScode';
                    this.sync_update_po("(#"+po.id+") EMS情報を更新しますか？","新しいEMS番号："+_delivery_no,params,url)

                }
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
                        // this.$store.commit("pos/update_po",data.po)
                        this.sync_lastest_po(data.po);
                    })
                    .catch((err) => {
                            console.log(err)
                        })
                    }})
            },
            sync_lastest_po(updated_po){
                var updatePOIndex=this.tableData.findIndex(po=>po.id ==updated_po.id);
                if(updatePOIndex >-1){
                    console.log("update this po:"+updated_po.id+" index: "+updatePOIndex);
                    this.tableData.splice(updatePOIndex,1,updated_po)
                    this.total=this.tableData.length;
                }
                this.$forceUpdate();
            },

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
.swal2-input.lionhu_checkbox{
    display: inline-block;
    width: 50px;
}
    p.title{
        display: inline-block;
        width: 100px;
        margin-right: 10px;
    }
</style>