<template>
        <div class=" nobottommargin">
            <section data-v-5790ee72="" id="page-title" class="page-title-pattern bottommargin-sm">
                <div data-v-5790ee72="" class="container clearfix">
                    <h1 data-v-5790ee72="">产品清单</h1>
                    <span data-v-5790ee72="">All Products</span>
                </div>
            </section>

            <div style="margin-top: 15px;">
                <div class="col_half">
                    <el-input placeholder="请输入产品部分名称" v-model="searchKeyWord" class="pull-left">
                        <el-button slot="append" icon="el-icon-search" @click="loadCatalogueProducts('keyword')"></el-button>
                    </el-input>
                </div>
                <div class="col_half col_last">
                    <el-cascader class="pull-right"
                                 :options="selectCatalogueOptions"
                                 v-model="loadCatalogue"
                                 @change="loadCatalogueProducts('catalogue')">
                    </el-cascader>
                </div>
            </div>
            <el-table
                    ref="filterTable"
                    :data="tableData"
                    style="width: 100%"
                    :default-sort="{prop: 'id', order: 'descending'}">
                <!--<el-table-column-->
                        <!--label="ID" sortable width="70"-->
                        <!--prop="id">-->
                    <!--<template slot-scope="props">-->
                        <!--<a :href="'/product/'+props.row.id">-->
                            <!--<span class="inline-block center">#{{props.row.id}}</span>-->
                        <!--</a>-->
                    <!--</template>-->
                <!--</el-table-column>-->
                <el-table-column>
                    <template slot-scope="props">
                        <img :src="'/'+props.row.thumbImage" style="height:60px" class="h-120 rounded">
                    </template>
                </el-table-column>
                <el-table-column width="260"
                        label="Name" >
                    <template slot-scope="props">
                        <div>{{props.row.name}}</div>
                        <span class="d-block">{{props.row.name_jp}}</span>
                        <span class="d-block">#{{props.row.product_code}}</span>
                    </template>
                </el-table-column>

                <el-table-column
                        label="Price">
                    <template slot-scope="props">
                        <div>{{props.row.o_price|currency_rmb}}</div>
                    </template>
                </el-table-column>
                <el-table-column align="center"
                                 label="Catalogue">
                    <template slot-scope="props">
                        <span class="d-block">{{props.row.catalogue.name}}</span>
                        <span class="d-block">{{props.row.subcatalogue.name}}</span>

                    </template>
                </el-table-column>
                <el-table-column align="center"
                                 label="">
                    <template slot-scope="props">
                        <a :href="'/#/subcatalogue/'+props.row.catalogue.id+'/'+props.row.subcatalogue.id">
                            <i class="i-medium i-circled i-bordered icon-cart nomargin bg-success"></i>
                        </a>
                    </template>
                </el-table-column>
<!--                <el-table-column-->
<!--                        label="Active">-->
<!--                    <template slot-scope="props">-->
<!--                        <a href="#" class="social-icon si-light si-forrst" title="Forrst" v-if="props.row.active=='1'">-->
<!--                            <i class="icon-check-sign" style="background-color: #1ABC9C;color: whitesmoke;" ></i>-->
<!--                        </a>-->
<!--                        <a href="#" class="social-icon si-light si-forrst" title="Forrst" v-if="props.row.active !='1'">-->
<!--                            <i class="icon-line-square-cross" style="background-color: darkred;color: whitesmoke;" ></i>-->
<!--                        </a>-->
<!--                    </template>-->
<!--                </el-table-column>-->
            </el-table>

        </div>
</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import Swal from 'sweetalert2'

    export default {
        name: "member_products",
        components:{
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
                searchKeyWord:"",
                selectCatalogue:[],
                loadCatalogue:[],
            }
        },
        mounted(){
            this.loadCatalogue=[3,2];
            this.loadCatalogueProducts("catalogue");
        },
        computed:{
            selectCatalogueOptions(){
                return this.$store.state.system.catalogues;
            },
            ME(){
                return this.$store.state.system.ME
            }
        },
        methods:{
            loadCatalogueProducts(type){
                var _params={};
                if(type == "catalogue"){
                     _params={
                        catalogue_id:this.loadCatalogue[0],
                        subcatalogue_id:this.loadCatalogue[1],
                        type:"catalogue"
                    }
                }else{
                     _params={
                        keyworld:this.searchKeyWord,
                        type:"keyword"
                    }
                }

                const url="/product/ofSubcatalogue";
                console.log(_params)

                axios.post(url,_params)
                    .then(response => response.data)
                    .then(data => {
                        if(data.result=='OK')
                            {
                                if(data.products.length){

                                    const _products=data.products.filter(product =>product.active=="1");
                                    this.tableData = _products;
                                    this.total = _products.length;
                                }
                            }
                    })
                    .catch((err) => {
                            console.log(err)
                        })
            },

            resetSearch(){
                this.tableData=this.allproducts;
                this.select="";
            },

            // handleCatalogueChange(product){
            //
            //     if(this.selectCatalogue !=null){
            //         const params={
            //             productid:product.id,
            //             type:'catalogue',
            //             catalogue_id:this.selectCatalogue[0],
            //             subcatalogue_id:this.selectCatalogue[1]
            //         };
            //         console.log(params);
            //         const url="/admin/products/updateProductInfo"
            //
            //         this.sync_update_product("更新产品分类信息","",params,url);
            //     }
            // },

            current_change:function(currentPage){
                this.currentPage = currentPage;
            },
        }
    }
</script>

<style scoped>
    .i-bordered{
        background-color:#1ABC9C !important;
        color:white;
        border-color: #1ABC9C !important;
    }
    .el-cascader{
        width:250px !important;
    }
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
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        border: 2px dotted grey;
        font-size: 28px;
        color: #8c939d;
        width: 120px;
        height: 120px;
        line-height: 120px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>