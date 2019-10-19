<template>
        <div class=" nobottommargin">
            <section data-v-5790ee72="" id="page-title" class="page-title-pattern bottommargin-sm">
                <div data-v-5790ee72="" class="container clearfix">
                    <h1 data-v-5790ee72="">本尊订单</h1>
                    <span data-v-5790ee72="">Power of Mine</span>
                </div>
            </section>
            <div>
                <el-select v-model="select_type" size="mini" style="width:100px;" placeholder="请选择" @change="selectType()" class="pull-right">
                    <el-option
                            v-for="item in type_options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
                <el-select v-model="pagesize" size="mini" style="width:80px;" placeholder="请选择" @change="selectPagesize()" class="pull-left">
                    <el-option
                            v-for="item in pagesize_options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <el-table
                    :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
                    style="width: 100%"
                    :default-sort="{prop: 'id', order: 'descending'}">
                <el-table-column type="expand">
                    <template slot-scope="props">

                        <!--<h4 class="nobottommargin"> 当前状态:<span style="display:inline-block;width:80px;margin-left:10px;">{{props.row.status}}</span></h4>-->
                        <!--<p class="nobottommargin" v-if="props.row.delivery_no !==''">-->
                            <!--快递单号:-->

                            <!--<a :href="props.row.delivery_no|deliveryURL" class="button button-3d button-mini button-rounded button-aqua"><i class="icon-truck"></i>{{props.row.delivery_no}}</a>-->
                        <!--</p>-->

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
                                {{props.row.customer.name}} <br>
                                {{props.row.customer.postcode}} <br>
                                {{props.row.customer.phone}} <br>
                                {{props.row.customer.address1}} <br>
                                {{props.row.customer.address2}} <br>
                                {{props.row.customer.email}}
                            </p>

                        </div>

                        <div class="clear"></div>
                        <div class="col_full">

                            <table class="table  visible-xs">
                                <thead>
                                <tr>
                                    <th class="cart-product-thumbnail"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <cartitem v-for="item in props.row.cartitems" :key="item.id+'_'+item.product.id" device="xs"
                                          :cartitem="item"></cartitem>
                                </tbody>

                            </table>
                            <table class="table  hidden-xs">
                                <thead>
                                <tr>
                                    <th class="cart-product-thumbnail"></th>
                                    <th class="cart-product-name">产品</th>
                                    <th class="cart-product-price ">单价</th>
                                    <th class="cart-product-quantity ">数量</th>
                                    <th class="cart-product-subtotal ">总计</th>
                                </tr>
                                </thead>
                                <tbody>
                                <cartitem v-for="item in props.row.cartitems" :key="item.id+'_'+item.product.id" device="md" :cartitem="item"></cartitem>
                                </tbody>

                            </table>
                        </div>


                        <div class="col_half title-block d-block">
                            <span><strong>总数量:</strong>{{ props.row.cart_Qty }}</span>
                            <span><strong>市场总价:</strong>{{ props.row.cart_O_Price |currency_rmb}}</span>
                            <span> <strong>代理商总价:</strong> {{ props.row.cart_Dis_Price |currency_rmb}}</span>

                        </div>
                        <div class="col_one_fourth  title-block d-block">
                            <a href="javascript:void(0);" class="btn btn-danger text-white d-block my-10"
                               @click="RemovePO(props.row.id)" v-if="props.row.status=='new' && props.row.user_id ==ME.id">
                                <i class="icon-trash-alt"></i>删除</a>
                            <a :href="'/po/print/open/'+props.row.id" target="_blank" class="btn btn-info text-danger d-block my-10">
                                <i class="icon-file-pdf"></i>打印客户订单
                            </a><a :href="'/po/print/dis/'+props.row.id" target="_blank" class="btn btn-info text-danger d-block my-10">
                            <i class="icon-file-pdf"></i>打印代理订单
                        </a>
                        </div>

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
                        label="顾客/用户" sortable
                        prop="customer.name" class="visible-xs">
                    <template slot-scope="props">
                        {{props.row.customer.name}} <br>
                        (<i class="icon-line2-user color" v-if="ME.id==props.row.user.id"></i>
                        {{props.row.user.name}})
                    </template>
                </el-table-column>
                <el-table-column
                        label="Status" sortable
                        prop="status">
                    <template slot-scope="props">

                        <a href="javascript:void(0);" class="button button-3d button-mini button-rounded button-red"
                           v-if="props.row.status=='new'"><i class="icon-line-paper-clip"></i></a>
                        <a href="javascript:void(0);" class="button button-3d button-mini button-rounded button-amber"
                           v-if="props.row.status=='processing'"><i class="icon-time"></i></a>
                        <a :href="props.row.delivery_no|deliveryURL" class="button button-3d button-mini button-rounded button-aqua"
                           v-if="props.row.status=='Delivering'"><i class="icon-truck"></i></a>
                        <a href="javascript:void(0);" class="button button-3d button-mini button-rounded button-green"
                           v-if="props.row.status=='completed'"><i class="icon-checkmark"></i></a>
                    </template>
                </el-table-column>
            </el-table>
            <div style="text-align: center;margin-top: 30px;" v-if="select_type !=='all'">
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
    import cartitem from "./parts/CartItem_readonly"

    export default {
        name: "customeradmin_my_pos",
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
                basicinfo:{
                    userid:0,
                    phone:'',
                    email:'',
                    rate:0,
                    introcode:'',
                    type:"basic"
                },
                type_options: [
                    {value: 'new', label: '新订单'},
                    {value: 'processing', label: '药房处理中'},
                    {value: 'Delivering', label: '快递中'},
                    {value: 'completed', label: '完成'},
                    {value: 'all', label: '全部'}],
                select_type: 'new'
            }
        },
        mounted(){
            this.$store.dispatch("pos/get_customeradmin_mypos");
            this.selectType(this.select_type);

        },
        computed:{
            mypos(){
              return this.$store.state.pos.mypos;
            },
            ME(){
                return this.$store.state.system.ME
            },

            ...mapGetters({
                // clientlist:"users/selectClientList",
                // rolelist:"users/selectUserRoleList"
            })
        },
        methods:{
            selectType(){
                if(this.select_type !=="all"){
                    this.tableData=this.mypos.filter(po =>po.status==this.select_type);
                }else{
                    this.tableData=this.mypos;
                    this.pagesize= this.tableData.length;
                }
                this.total= this.tableData.length;

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
                    return axios.post('/customerAdmin/pos/delete',{poid:poid})
                        .then(response => response.data)
                        .then(data => {
                            this.$store.commit("pos/set_remove_mypo",poid)
                            const removeIndex=this.tableData.findIndex(po =>po.id==poid);
                            if(removeIndex > -1){
                                this.tableData.splice(removeIndex,1);
                                this.total=this.tableData.length;
                            }
                        })
                        .catch((err) => {
                                console.log(err)
                        })
                }})
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
        width: 150px;
    }
</style>