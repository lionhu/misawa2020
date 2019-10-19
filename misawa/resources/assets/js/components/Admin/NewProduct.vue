<template>
        <div class=" nobottommargin">
            <!--<section data-v-5790ee72="" id="page-title" class="page-title-pattern bottommargin-sm">-->
                <!--<div data-v-5790ee72="" class="container clearfix">-->
                    <!--<h1 data-v-5790ee72="">产品清单</h1>-->
                    <!--<span data-v-5790ee72="">All Products</span>-->
                <!--</div>-->
            <!--</section>-->
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10">


                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4 class="mb-0">产品登录</h4>
                        </div>
                        <div class="card-body">

                                <div class="col_full bottommargin-sm">
                                    <el-checkbox v-model="product.active">产品有效</el-checkbox>
                                </div>

                                <div class="col_half col_last bottommargin-sm">
                                    变更类别：
                                    <el-cascader
                                            :options="selectCatalogueOptions"
                                            v-model="selectCatalogue"
                                            @change="handleCatalogueChange">
                                    </el-cascader>
                                </div>

                                <div class="col_half col_last bottommargin-sm">
                                    <label>供应商:</label>
                                    <el-select v-model="product.vendor_id" placeholder="请选择">
                                        <el-option
                                                v-for="item in vendorlist"
                                                :key="item.id"
                                                :label="item.name"
                                                :value="item.id">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div class="col_half bottommargin-sm">
                                    <label for="product_name_manufactory">厂家<small class="text-danger">*</small></label>
                                    <input type="text" id="product_name_manufactory" name="product_name_manufactory" v-model="product.manufactory" class="form-control required"
                                           placeholder="Enter your Full Name" />
                                </div>
                                <div class="col_half col_last bottommargin-sm">
                                    <label for="product_name_code">产品SKU<small class="text-danger">*</small></label>
                                    <input type="text" id="product_name_code" name="product_name_code" v-model="product.product_code" class="form-control required"
                                           placeholder="Enter your Full Name" />
                                </div>

                                <div class="col_full bottommargin-sm">
                                            <label for="product_name">产品名称<small class="text-danger">*</small></label>
                                            <input type="text" id="product_name" name="product_name" v-model="product.name" class="form-control required"
                                                   placeholder="Enter your Full Name" />
                                        </div>

                                <div class="col_full bottommargin-sm">
                                    <label for="product_name_jp">产品名称(jp)<small class="text-danger">*</small></label>
                                    <input type="text" id="product_name_jp" name="product_name_jp" v-model="product.name_jp" class="form-control required"
                                           placeholder="Enter your Full Name" />
                                </div>

                                <div class="col_one_third bottommargin-sm">
                                    <label for="product_r_price">R_Price<small class="text-danger">*</small></label>
                                    <input type="text" id="product_r_price" name="product_r_price" v-model="product.r_price"
                                           class="form-control required" placeholder="Enter your Full Name" />
                                </div>
                                <div class="col_one_third bottommargin-sm">
                                    <label for="product_b_price">B_Price<small class="text-danger">*</small></label>
                                    <input type="text" id="product_b_price" name="product_b_price" v-model="product.b_price"
                                           class="form-control required" placeholder="Enter your Full Name" />
                                </div>
                                <div class="col_one_third col_last bottommargin-sm">
                                    <label for="product_o_price">O_Price<small class="text-danger">*</small></label>
                                    <input type="text" id="product_o_price" name="product_o_price" v-model="product.o_price"
                                           class="form-control required" placeholder="Enter your Full Name" />
                                </div>

                                <div class="col_full bottommargin-sm">
                                    <label for="product_effecay">产品介绍:<small class="text-danger">*</small></label>
                                    <textarea class="required form-control textarea-message" v-model="product.efficacy" id="product_effecay" name="product_efficacy"
                                              rows="6" cols="30"></textarea>
                                </div>
                                <div class="col_full bottommargin-sm">
                                    <label for="product_effecay">服用方法:<small class="text-danger">*</small></label>
                                    <textarea class="required form-control textarea-message" v-model="product.description" id="product_description" name="product_description"
                                              rows="6" cols="30"></textarea>
                                </div>
                                <div class="col_full bottommargin-sm">
                                    <label for="product_ingredient">成分:<small class="text-danger">*</small></label>
                                    <textarea class="required form-control textarea-message" v-model="product.ingredient" id="product_ingredient" name="product_ingredient"
                                              rows="6" cols="30"></textarea>
                                </div>
                                <div class="col_full bottommargin-sm">
                                    <label for="product_effecay">其他信息:<small class="text-danger">*</small></label>
                                    <textarea class="required form-control textarea-message" v-model="product.website" id="product_website" name="product_website"
                                              rows="6" cols="30"></textarea>
                                </div>


                                        <div class="col_full">
                                            <button type="submit" name="template-contactform-submit"  @click="RegisterProduct"
                                                    class="btn btn-success btn-block btn-lg">Send</button>
                                        </div>

                            <div v-if="product.id">
                                <div class="col_one_third">
                                    <el-upload
                                            class="avatar-uploader"
                                            action="/admin/products/UpdateProductPostImage"
                                            :show-file-list="false"
                                            :on-success="handleAvatarSuccess"
                                            :headers="{'X-CSRF-TOKEN':csrftoken}"
                                            :data="{productid:product.id,type:'postimage'}"
                                            :before-upload="beforeAvatarUpload">
                                        <img v-if="product.thumbImage" :src="product.thumbImage" class="avatar">
                                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                    </el-upload>
                                </div>
                                <div class="col_one_third">
                                    <el-upload
                                            class="avatar-uploader inline-block"
                                            action="/admin/products/UpdateProductImage"
                                            :show-file-list="false"
                                            :on-success="handleAvatarSuccess"
                                            :headers="{'X-CSRF-TOKEN':csrftoken}"
                                            :data="{productid:product.id,no:1,type:'image'}"
                                            :before-upload="beforeAvatarUpload">
                                        <img v-if="product.images[1] !=undefined" :src="product.images[1].path_image" class="avatar">
                                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                    </el-upload>
                                    <button class="pull-right inline-block" v-if="product.images[1] !=undefined" @click="RemoveProductImage(product,1,product.images[1].path_image)"><i class="icon-trash"></i></button>
                                </div>
                                <div class="col_one_third col_last" >
                                    <el-upload
                                            class="avatar-uploader  inline-block"
                                            action="/admin/products/UpdateProductImage"
                                            :show-file-list="false"
                                            :on-success="handleAvatarSuccess"
                                            :headers="{'X-CSRF-TOKEN':csrftoken}"
                                            :data="{productid:product.id,no:2,type:'image'}"
                                            :before-upload="beforeAvatarUpload">
                                        <img v-if="product.images[2]!=undefined" :src="product.images[2].path_image" class="avatar">
                                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                    </el-upload>
                                    <button class="pull-right inline-block" v-if="product.images[2]!=undefined"  @click="RemoveProductImage(product,2,product.images[2].path_image)"><i class="icon-trash"></i></button>
                                </div>
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

    export default {
        name: "superadmin_addproduct",
        components:{
        },
        data() {
            return {
                csrftoken:'',
                selectCatalogue:[],
                product:{
                    id:0,
                    name:"proname",
                    name_jp:"product name/jo",
                    product_code:"123fdsa",
                    r_price:1,
                    b_price:2,
                    o_price:3,
                    postimage:"/images/products/empty.jpg",
                    thumbImage:"/images/products/empty.jpg",
                    ingredient:"ingredient",
                    manufactory:"manufactory",
                    efficacy:"efficacy",
                    description:"description",
                    website:"website",
                    images:[
                        {path_image:'/images/products/empty.jpg',id:0},
                        {path_image:'/images/products/empty.jpg',id:0},
                        {path_image:'/images/products/empty.jpg',id:0}
                    ],

                    catalogue_id:3,
                    subcatalogue_id:2,

                    active:false,
                    flag_suggest:1,
                    rate:3,
                    vendor_id:2
                }
            }
        },
        mounted(){
            this.csrftoken=$('meta[name="csrf-token"]').attr('content');
            this.$store.dispatch("system/load_management_info");

        },
        computed:{
            selectCatalogueOptions(){
                return this.$store.state.system.catalogues;
            },
            vendorlist(){
                return this.$store.state.system.vendorlist;
            },
        },
        methods:{
            RegisterProduct(){
                console.log(this.product)

                        const url="/admin/products/addNewProduct"

                        this.sync_update_product("更新产品信息","",this.product,url);
            },

            // UpdateEditProduct(){
            //     if (this.editProduct !=undefined){
            //         const params={
            //             productid:this.editProduct.id,
            //             efficacy:this.editProduct.efficacy,
            //             description:this.editProduct.description,
            //             website:this.editProduct.website,
            //             type:"details",
            //         }
            //
            //         const url="/admin/products/updateProductInfo"
            //
            //         this.sync_update_product("更新产品信息","",params,url);
            //     }
            //
            //     $("#modal_product_details").modal("hide");
            // },
            // ShowEditProduct(product){
            //   this.editProduct=product;
            //   $("#modal_product_details").modal("show");
            //
            // },
            handleAvatarSuccess(res, file) {
                // this.imageUrl = URL.createObjectURL(file.raw);
                if(res.result=='OK'){
                    console.log(res)
                    this.product.images[res.no].path_image=res.path_image;
                    this.product.postimage="/"+res.product.postimage;
                    this.product.thumbImage="/"+res.product.thumbImage;

                    // this.sync_lastest_product(res.product);
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

            // loadCatalogueProducts(type){
            //     console.log(type)
            //     var _params={};
            //     if(type == "catalogue"){
            //          _params={
            //             catalogue_id:this.loadCatalogue[0],
            //             subcatalogue_id:this.loadCatalogue[1],
            //             type:"catalogue"
            //         }
            //     }else{
            //          _params={
            //             keyworld:this.searchKeyWord,
            //             type:"keyword"
            //         }
            //     }
            //
            //     const url="/admin/products/ofSubcatalogue";
            //     console.log(_params)
            //
            //     axios.post(url,_params)
            //         .then(response => response.data)
            //         .then(data => {
            //             if(data.result=='OK')
            //                 {
            //                     data.products.map(function(product){
            //                         if(product.images[0] == undefined){
            //                             product.images.push({id:0,path_image:"images/products/empty.jpg"})
            //                         }
            //                         if(product.images[1] == undefined){
            //                             product.images.push({id:0,path_image:"images/products/empty.jpg"})
            //                         }
            //                         if(product.images[2] == undefined){
            //                             product.images.push({id:0,path_image:"images/products/empty.jpg"})
            //                         }
            //                     });
            //                     this.tableData = data.products;
            //
            //                     this.total = data.products.length;
            //                 }
            //         })
            //         .catch((err) => {
            //                 console.log(err)
            //             })
            // },

            // resetSearch(){
            //     this.tableData=this.allproducts;
            //     this.select="";
            // },

            handleCatalogueChange(){
                console.log(this.selectCatalogue)
                this.product.catalogue_id=this.selectCatalogue[0];
                this.product.subcatalogue_id=this.selectCatalogue[1]
            },
             RemoveProductImage(product,no,old_name){
                    const params={
                        productid:product.id,
                        type:'removeProductImage',
                        no:old_name
                    };
                    const url="/admin/products/updateProductInfo"

                    console.log(params)
                    this.sync_update_product("删除产品照片？","",params,url);
                    this.product.images[no].path_image=""
            },


            // async UpdateProductActive(product){
            //     const checkedStr=product.active=='1'?'checked':'';
            //     const htmlstr='产品有效激活：<input id="swal-active" ' + checkedStr + ' type="checkbox" class="swal2-input">'
            //
            //     const {value: active_status} = await Swal.fire({
            //             title: '激活产品',
            //             html:htmlstr,
            //             focusConfirm: false,
            //             preConfirm: () => {
            //                 return [
            //                     document.getElementById('swal-active').checked
            //                 ]
            //             }
            //     })
            //
            //     console.log(active_status);
            //     if(active_status !=undefined){
            //         const params={
            //             productid:product.id,
            //             type:'active',
            //             active:active_status[0],
            //         };
            //         const url="/admin/products/updateProductInfo"
            //
            //         this.sync_update_product("更新基本信息","",params,url);
            //     }
            // },
            // async UpdateProductBasicInfo(product){
            //     const {value: formValues} = await Swal.fire({
            //         title: '产品信息',
            //         html:
            //         '中文名称: <input id="swal-name" class="swal2-input" placeholder="'+product.name+'" value="'+product.name+'">' +
            //         '日文名称:<input id="swal-name_jp" class="swal2-input" placeholder="'+product.name_jp+'" value="'+product.name_jp+'">' +
            //         '产品编号:<input id="swal-product_code" class="swal2-input" placeholder="'+product.product_code+'" value="'+product.product_code+'">' +
            //         '厂家:<input id="swal-manufactory" class="swal2-input" placeholder="'+product.manufactory+'" value="'+product.manufactory+'">',
            //         focusConfirm: false,
            //         preConfirm: () => {
            //         return [
            //             document.getElementById('swal-name').value,
            //             document.getElementById('swal-name_jp').value,
            //             document.getElementById('swal-product_code').value,
            //             document.getElementById('swal-manufactory').value
            //         ]
            //     }
            // });
            //
            //     console.log(formValues);
            //     if(formValues !=undefined){
            //         const params={
            //             productid:product.id,
            //             type:'basic',
            //             name:formValues[0],
            //             name_jp:formValues[1],
            //             product_code:formValues[2],
            //             manufactory:formValues[3]
            //         };
            //         const url="/admin/products/updateProductInfo"
            //
            //         this.sync_update_product("更新基本信息","",params,url);
            //     }
            // },
            // async UpdateProductPrice(product){
            //     const {value: formValues} = await Swal.fire({
            //         title: '价格信息',
            //         html:
            //         'O_Price: <input id="swal-o_price" class="swal2-input" placeholder="'+product.o_price+'" value="'+product.o_price+'">' +
            //         'B_Price:<input id="swal-b_price" class="swal2-input" placeholder="'+product.b_price+'" value="'+product.b_price+'">' +
            //         'R_Price:<input id="swal-r_price" class="swal2-input" placeholder="'+product.r_price+'" value="'+product.r_price+'">',
            //         focusConfirm: false,
            //         preConfirm: () => {
            //                 return [
            //                     document.getElementById('swal-o_price').value,
            //                     document.getElementById('swal-b_price').value,
            //                     document.getElementById('swal-r_price').value
            //                 ]
            //             }
            //         })
            //
            //         console.log(formValues);
            //         if(formValues !=undefined){
            //             const params={
            //                 productid:product.id,
            //                 type:'price',
            //                 o_price:formValues[0],
            //                 b_price:formValues[1],
            //                 r_price:formValues[2]
            //             };
            //             const url="/admin/products/updateProductInfo"
            //
            //             this.sync_update_product("更新价格信息","",params,url);
            //         }
            // },
            // current_change:function(currentPage){
            //     this.currentPage = currentPage;
            // },
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
                            console.log(data)
                            if(data.result=='OK'){
                                this.product.id=data.product.id
                                Swal.fire({
                                    title:"插入数据成功",
                                    type:"success",
                                    text:"新插入输入的ID："+this.product.id
                                })

                            }
                            // this.$store.commit("products/update_product_info",data.product)
                            // this.sync_lastest_product(data.product);
                        })
                        .catch((err) => {
                                console.log(err)
                            })
                        }})
            },
            // sync_lastest_product(_product){
            //     var updateProductIndex=this.tableData.findIndex(product=>product.id ==_product.id);
            //     if(updateProductIndex >-1){
            //         console.log("update this po:"+_product.id+" index: "+updateProductIndex);
            //         this.tableData.splice(updateProductIndex,1,_product)
            //     }
            // }
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