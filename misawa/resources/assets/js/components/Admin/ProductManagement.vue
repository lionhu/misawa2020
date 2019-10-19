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
                <el-table-column type="expand">
                    <template slot-scope="props">
                        <div class="col_half">
                            变更类别：
                            <el-cascader
                                    :options="selectCatalogueOptions"
                                    v-model="selectCatalogue"
                                    @change="handleCatalogueChange(props.row)">
                            </el-cascader>
                            <div class="mt-10">
                                <button  class="button button-mini button-circle button-red d-block"  @click="UpdateProductPrice(props.row)">
                                    <i class="icon-money"></i>Price</button>
                                <button class="button button-mini button-circle button-aqua d-block"  @click="UpdateProductBasicInfo(props.row)">
                                    <i class="icon-info"></i>Info</button>
                                <button class="button button-mini button-circle button-pink d-block"  @click="UpdateProductActive(props.row)">
                                    <i class="icon-bookmark2"></i>Active</button>
                                <button class="btn btn-primary" @click="ShowEditProduct(props.row)" >Details</button>
                            </div>
                        </div>
                        <div class="col_half col_last">
                            <div>
                                <el-upload
                                        class="avatar-uploader"
                                        action="/admin/products/UpdateProductPostImage"
                                        :show-file-list="false"
                                        :on-success="handleAvatarSuccess"
                                        :headers="{'X-CSRF-TOKEN':csrftoken}"
                                        :data="{productid:props.row.id,type:'postimage'}"
                                        :before-upload="beforeAvatarUpload">
                                    <img v-if="props.row.thumbImage" :src="props.row.thumbImage" class="avatar">
                                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                </el-upload>
                            </div>
                            <div>
                                <el-upload
                                        class="avatar-uploader inline-block"
                                        action="/admin/products/UpdateProductImage"
                                        :show-file-list="false"
                                        :on-success="handleAvatarSuccess"
                                        :headers="{'X-CSRF-TOKEN':csrftoken}"
                                        :data="{productid:props.row.id,no:1,type:'image'}"
                                        :before-upload="beforeAvatarUpload">
                                    <img v-if="props.row.images[1] !=undefined" :src="props.row.images[1].path_image" class="avatar">
                                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                </el-upload>
                                <button class="pull-right inline-block" v-if="props.row.images[1] !=undefined" @click="RemoveProductImage(props.row,props.row.images[1].path_image)"><i class="icon-trash"></i></button>
                            </div>
                            <div>
                                <el-upload
                                        class="avatar-uploader  inline-block"
                                        action="/admin/products/UpdateProductImage"
                                        :show-file-list="false"
                                        :on-success="handleAvatarSuccess"
                                        :headers="{'X-CSRF-TOKEN':csrftoken}"
                                        :data="{productid:props.row.id,no:2,type:'image'}"
                                        :before-upload="beforeAvatarUpload">
                                    <img v-if="props.row.images[2]!=undefined" :src="props.row.images[2].path_image" class="avatar">
                                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                </el-upload>
                                <button class="pull-right inline-block" v-if="props.row.images[2]!=undefined"  @click="RemoveProductImage(props.row,props.row.images[2].path_image)"><i class="icon-trash"></i></button>
                            </div>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="ID" sortable width="70"
                        prop="id">
                    <template slot-scope="props">
                        <a :href="'/product/'+props.row.id">
                            <span class="inline-block center">#{{props.row.id}}</span>
                        </a>
                    </template>
                </el-table-column>
                <el-table-column>
                    <template slot-scope="props">
                        <img :src="'/'+props.row.thumbImage" style="height:60px" class="h-120 rounded">
                    </template>
                </el-table-column>
                <el-table-column width="260"
                        label="Name" >
                    <template slot-scope="props" >
                        <div :class="{'text-success':props.row.active=='1','bg-danger':props.row.active=='0'}">{{props.row.name}}</div>
                        <span class="d-block">{{props.row.name_jp}}</span>
                        <span class="d-block">#{{props.row.product_code}}</span>
                    </template>
                </el-table-column>

                <el-table-column
                        label="Price">
                    <template slot-scope="props">
                        <div>{{props.row.o_price|currency_rmb}}</div>
                        <span class="d-block">{{props.row.b_price|currency_rmb}}</span>
                        <a href="javascript:void(0);"><span class="d-block">{{props.row.r_price|currency_jpy}}</span></a>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Catalogue">
                    <template slot-scope="props">
                        <a href="javascript:void(0);" @click="ChangeCatalogue(props.row)">
                            <span class="d-block">{{props.row.catalogue.name}}</span>
                            <span class="d-block">{{props.row.subcatalogue.name}}</span>
                        </a>

                    </template>
                </el-table-column>
                <el-table-column
                        label="Active">
                    <template slot-scope="props">
                        <a href="#" class="social-icon si-light si-forrst" title="Forrst" v-if="props.row.active=='1'">
                            <i class="icon-forrst" style="background-color: #1ABC9C;color: whitesmoke;"></i>
                        </a>
                    </template>
                </el-table-column>
            </el-table>

            <div class="modal fade " id="modal_product_details" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-body">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">{{editProduct.name}}(#{{editProduct.id}})</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">介绍</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" v-model="editProduct.efficacy" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">服用方法</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea2" v-model="editProduct.description" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">其他</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea3"  v-model="editProduct.website"rows="3"></textarea>
                                </div>

                                <button class="btn btn-primary" @click="UpdateEditProduct()" >Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import Swal from 'sweetalert2'
    import cartitem from "./parts/CartItem_readonly"

    export default {
        name: "superadmin_products",
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
                searchKeyWord:"",
                selectCatalogue:[],
                loadCatalogue:[3,2],
                imageUrl: '',
                csrftoken:'',
                editProduct:{}
            }
        },
        mounted(){
            // this.$store.dispatch("products/get_all_products");
            this.loadCatalogueProducts("catalogue");
            this.csrftoken=$('meta[name="csrf-token"]').attr('content');

        },
        computed:{
            allproducts(){
              return this.$store.state.products.all;
            },
            selectCatalogueOptions(){
                return this.$store.state.system.catalogues;
            },
        },
        methods:{
            UpdateEditProduct(){
                if (this.editProduct !=undefined){
                    const params={
                        productid:this.editProduct.id,
                        efficacy:this.editProduct.efficacy,
                        description:this.editProduct.description,
                        website:this.editProduct.website,
                        type:"details",
                    }

                    const url="/admin/products/updateProductInfo"

                    this.sync_update_product("更新产品信息","",params,url);
                }

                $("#modal_product_details").modal("hide");
            },
            ShowEditProduct(product){
              this.editProduct=product;
              $("#modal_product_details").modal("show");

            },
            handleAvatarSuccess(res, file) {
                // this.imageUrl = URL.createObjectURL(file.raw);
                if(res.result=='OK'){
                    this.sync_lastest_product(res.product);
                    // this.imageUrl=''
                }
            },
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG) {
                    this.$message.error('上传头像图片只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            },

            loadCatalogueProducts(type){
                console.log(type)
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

                const url="/admin/products/ofSubcatalogue";
                console.log(_params)

                axios.post(url,_params)
                    .then(response => response.data)
                    .then(data => {
                        if(data.result=='OK')
                            {
                                data.products.map(function(product){
                                    if(product.images[0] == undefined){
                                        product.images.push({id:0,path_image:"images/products/empty.jpg"})
                                    }
                                    if(product.images[1] == undefined){
                                        product.images.push({id:0,path_image:"images/products/empty.jpg"})
                                    }
                                    if(product.images[2] == undefined){
                                        product.images.push({id:0,path_image:"images/products/empty.jpg"})
                                    }
                                });
                                this.tableData = data.products;

                                this.total = data.products.length;
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

            handleCatalogueChange(product){

                if(this.selectCatalogue !=null){
                    const params={
                        productid:product.id,
                        type:'catalogue',
                        catalogue_id:this.selectCatalogue[0],
                        subcatalogue_id:this.selectCatalogue[1]
                    };
                    console.log(params);
                    const url="/admin/products/updateProductInfo"

                    this.sync_update_product("更新产品分类信息","",params,url);
                }
            },
             RemoveProductImage(product,no){
                    const params={
                        productid:product.id,
                        type:'removeProductImage',
                        no:no
                    };
                    const url="/admin/products/updateProductInfo"

                    console.log(params)
                    this.sync_update_product("删除产品照片？","",params,url);
            },


            async UpdateProductActive(product){
                const checkedStr=product.active=='1'?'checked':'';
                // const htmlstr='产品有效激活：<input id="swal-active" ' + checkedStr + ' type="checkbox" class="swal2-input">'

                var htmlstr='<div class="checkbox"><input type="checkbox" '+ checkedStr +' id="swal-active" class="swal2-input">'+
                    '<label for="swal-active">产品有效激活：</label></div>';

                const {value: active_status} = await Swal.fire({
                        title: '激活产品',
                        html:htmlstr,
                        focusConfirm: false,
                        preConfirm: () => {
                            return [
                                document.getElementById('swal-active').checked
                            ]
                        }
                })

                console.log(active_status);
                if(active_status !=undefined){
                    const params={
                        productid:product.id,
                        type:'active',
                        active:active_status[0],
                    };
                    const url="/admin/products/updateProductInfo"

                    this.sync_update_product("更新基本信息","",params,url);
                }
            },
            async UpdateProductBasicInfo(product){
                const {value: formValues} = await Swal.fire({
                    title: '产品信息',
                    html:
                    '中文名称: <input id="swal-name" class="swal2-input" placeholder="'+product.name+'" value="'+product.name+'">' +
                    '日文名称:<input id="swal-name_jp" class="swal2-input" placeholder="'+product.name_jp+'" value="'+product.name_jp+'">' +
                    '产品编号:<input id="swal-product_code" class="swal2-input" placeholder="'+product.product_code+'" value="'+product.product_code+'">' +
                    '厂家:<input id="swal-manufactory" class="swal2-input" placeholder="'+product.manufactory+'" value="'+product.manufactory+'">',
                    focusConfirm: false,
                    preConfirm: () => {
                    return [
                        document.getElementById('swal-name').value,
                        document.getElementById('swal-name_jp').value,
                        document.getElementById('swal-product_code').value,
                        document.getElementById('swal-manufactory').value
                    ]
                }
            });

                console.log(formValues);
                if(formValues !=undefined){
                    const params={
                        productid:product.id,
                        type:'basic',
                        name:formValues[0],
                        name_jp:formValues[1],
                        product_code:formValues[2],
                        manufactory:formValues[3]
                    };
                    const url="/admin/products/updateProductInfo"

                    this.sync_update_product("更新基本信息","",params,url);
                }
            },
            async UpdateProductPrice(product){
                const {value: formValues} = await Swal.fire({
                    title: '价格信息',
                    html:
                    'O_Price: <input id="swal-o_price" class="swal2-input" placeholder="'+product.o_price+'" value="'+product.o_price+'">' +
                    'B_Price:<input id="swal-b_price" class="swal2-input" placeholder="'+product.b_price+'" value="'+product.b_price+'">' +
                    'R_Price:<input id="swal-r_price" class="swal2-input" placeholder="'+product.r_price+'" value="'+product.r_price+'">',
                    focusConfirm: false,
                    preConfirm: () => {
                            return [
                                document.getElementById('swal-o_price').value,
                                document.getElementById('swal-b_price').value,
                                document.getElementById('swal-r_price').value
                            ]
                        }
                    })

                    console.log(formValues);
                    if(formValues !=undefined){
                        const params={
                            productid:product.id,
                            type:'price',
                            o_price:formValues[0],
                            b_price:formValues[1],
                            r_price:formValues[2]
                        };
                        const url="/admin/products/updateProductInfo"

                        this.sync_update_product("更新价格信息","",params,url);
                    }
            },
            current_change:function(currentPage){
                this.currentPage = currentPage;
            },
            sync_update_product(msg,sub_msg,params,url){

                Swal.fire({
                    title: msg,
                    confirmButtonText: '确认',
                    text: sub_msg,
                    showLoaderOnConfirm: true,
                    preConfirm: () => {

                    return axios.post(url,params)
                        .then(response => response.data)
                        .then(data => {
                            this.$store.commit("products/update_product_info",data.product)
                            this.sync_lastest_product(data.product);
                        })
                        .catch((err) => {
                                console.log(err)
                            })
                        }})
            },
            sync_lastest_product(_product){
                var updateProductIndex=this.tableData.findIndex(product=>product.id ==_product.id);
                if(updateProductIndex >-1){
                    console.log("update this po:"+_product.id+" index: "+updateProductIndex);
                    this.tableData.splice(updateProductIndex,1,_product)
                }
            }
        }
    }
</script>

<style scoped>
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