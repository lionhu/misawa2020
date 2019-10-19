<script src="../../store/member/system.js"></script>
<template>
        <div class=" nobottommargin">
            <section  id="page-title" class="page-title-pattern bottommargin-sm">
                <div  class="container clearfix">
                    <h1>注文一覧</h1>
                    <span>All POS</span>
                </div>
            </section>
            <el-table
                    ref="filterTable"
                    :data="tableData"
                    style="width: 100%"
                    :default-sort="{prop: 'id', order: 'descending'}">
                <el-table-column type="expand">
                    <template slot-scope="props">

                        <div class="col_half title-block d-block">
                            <h4 class="nobottommargin"> ステータス:
                                <a href="javascript:void(0);" class="button button-mini">
                                    <span class="" style="display:inline-block;width:80px;margin-left:10px;">{{props.row.status}}</span>
                                </a>
                            </h4>

                            <p class="nobottommargin">
                                <span class="title">日付:</span>{{props.row.created_at}}
                            </p>
                            <p class="nobottommargin">
                            </p>
                            <p class="nobottommargin" v-if="props.row.status !=='new'">
                                <span class="title">EMS:</span>
                                <a href="javascript:void(0);" @click="checkEMS(props.row.delivery_no)"
                                   class="button button-3d button-mini button-rounded button-aqua">
                                    <i class="icon-truck"></i>{{props.row.delivery_no}}
                                </a>
                            </p>
                        </div>
                        <div class="col_half title-block col_last">

                            <p style="margin:15px">
                                <span class="title">顧客:</span>{{props.row.customer.name}} <br>
                                <span class="title">邮编:</span>{{props.row.customer.postcode}} <br>
                                <span class="title">电话:</span>{{props.row.customer.phone}} <br>
                                <span class="title">地址1:</span>{{props.row.customer.address1}} <br>
                                <span class="title">地址2:</span>{{props.row.customer.address2}} <br>
                                <span class="title">邮箱:</span>{{props.row.customer.email}}
                            </p>

                        </div>


                        <table class="table visible-xs" v-if="!props.row.locked ||props.row.status=='new'">
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
                        <table class="table hidden-xs" v-if="!props.row.locked ||props.row.status=='new'">
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
                                <cartitem v-for="item in props.row.cart" :key="item.id+'_'+item.product.id" device="md" :cartitem="item"></cartitem>
                            </tbody>

                        </table>
                        <div class="col_half title-block d-block">
                            <span><strong>数量:</strong>{{ props.row.cart_Qty }}</span>
                            <span :class="{'text-danger':props.row.P_Adjust =='1'}"> <strong>総額:</strong> {{ props.row.cart_Dis_Price |currency_rmb}}</span>

                        </div>
                        <div class="col_one_fourth  title-block d-block" target="_blank" v-if="!props.row.locked ||props.row.status=='new'">
                            <a :href="'/po/printOpenPO/'+props.row.id" class="btn btn-info text-danger d-block my-10">
                                <i class="icon-file-pdf"></i>市场价订单印刷
                            </a>
                            <a :href="'/po/printMyPO/'+props.row.id" target="_blank" class="btn btn-info text-danger d-block my-10">
                                <i class="icon-file-pdf"></i>我的订单印刷
                            </a>
                            <button class="btn btn-danger text-white d-block my-10" @click="RemovePO(props.row.id)" v-if="props.row.status=='new'">
                                <i class="icon-trash-alt"></i>订单删除</button>

                        </div>

                        <el-alert
                                title="订单被锁住"
                                type="error"
                                description="订单详细信息已经被锁住，请联系系统管理员解锁。"
                                show-icon v-if="props.row.locked && props.row.status !='new'">
                        </el-alert>
                    </template>
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

                <el-table-column width="150"
                        label="Payment" class="visible-xs">
                    <template slot-scope="props">
                            <a href="javascript:void(0);" class="btn "
                               :class="{'btn-success':props.row.paid_vendor=='1','btn-secondary':props.row.paid_vendor!=='1'}">
                                <i class="icon-line-command"></i>
                            </a>
                    </template>
                </el-table-column>

                <el-table-column
                        label="金额">
                    <template slot-scope="props">
                            <span class="badge " :class="{'badge-danger':props.row.P_Adjust=='1','badge-success':props.row.P_Adjust!='1'}">
                            {{props.row.cart_Dis_Price|currency}}
                            </span>

                    </template>
                </el-table-column>
                <el-table-column
                        label="Status" sortable fixed="right" :filters="type_filters" :filter-method="filterHandler"
                        prop="status">
                    <template slot-scope="props">

                        <a href="javascript:void(0);" class="btn button-red text-white"
                           v-if="props.row.status=='new'"><i class="icon-line-paper-clip"></i></a>
                        <a href="javascript:void(0);" class="btn button-amber text-white" @click="checkEMS(props.row.delivery_no)"
                           v-if="props.row.status=='processing'"><i class="icon-time"></i></a>

                        <a href="javascript:void(0);" @click="checkEMS(props.row.delivery_no)"
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
    import cartitem from "./parts/CartItem_readonly"

    export default {
        name: "member_pos",
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
                    {value: 'new', text: '新注文'},
                    {value: 'processing', text: '処理中'},
                    {value: 'Delivering', text: '輸送中'},
                    {value: 'completed', text: '完了'}],
            }
        },
        mounted(){
            this.$store.dispatch("pos/get_all_mypos");
            this.tableData=this.allpos;
            this.pagesize= this.tableData.length;
            this.total= this.tableData.length;

        },
        computed:{
            allpos(){
              return this.$store.state.pos.all;
            },
        },
        methods:{

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
                    return axios.post('/po/deleteMyPO',{poid:poid})
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
        },
        watch:{
            $route(to,from){
                console.log(to.params.name)
                console.log(from.params.name)
                if(to.params.name !=from.params.name){
                    this.loadCatalogueProducts(to.params.id);
                    // this.getContentHeight();
                    window.location.reload()
                }
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
        display: inline-block!important;
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
    p .title{
        display: inline-block;
        width: 60px;
        margin-right: 10px;
    }
</style>