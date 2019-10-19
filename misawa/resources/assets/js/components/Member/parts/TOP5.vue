<template>

    <div class="sidebar nobottommargin col_last hidden-xs">
        <div class="sidebar-widgets-wrap">
            <!--<div class="widget widget_links clearfix">-->
                <!--<div v-for="catalogue in catalogues" style="padding-top:20px!important;margin-top:20px!important" class="widget widget_links clearfix text-success">-->
                    <!--<h4 style="margin-top: 20px;font-weight: 700;">{{catalogue.label}}</h4>-->
                    <!--<ul>-->
                        <!--<li v-for="subcatalogue in catalogue.children">-->
                            <!--<a href="javascript:void(0);" @click="SwitchCatalogue(catalogue.value,subcatalogue.value)">-->
                                <!--{{subcatalogue.label}}-->
                                <!--<span class="badge  float-right"-->
                                    <!--:class="{'badge-secondary':subcatalogue.value == current_SubCatalogue_id}"-->
                                    <!--style="margin-left: 10px;">{{subcatalogue.products_count}}-->
                                <!--</span>-->
                            <!--</a>-->
                        <!--</li>-->
                    <!--</ul>-->
                <!--</div>-->

            <!--</div>-->

            <div class="widget clearfix">

                <h4>热销排行榜TOP5</h4>
                <div id="post-list-footer">

                    <div class="spost clearfix" v-for="product in top5">
                        <div class="entry-image">
                            <a :href="'/#/viewproduct/'+product.id"><img :src="'/'+product.thumbImage" :alt="product.name_cn"></a>
                        </div>
                        <div class="entry-c">
                            <div class="entry-title">
                                <h4><a :href="'/#/viewproduct/'+product.id" target="_blank">{{product.name_cn}}</a></h4>
                            </div>
                            <!--<ul class="entry-meta">-->
                            <!--<li class="color">$29.99</li>-->
                            <!--<li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star-half-full"></i></li>-->
                            <!--</ul>-->
                        </div>
                    </div>

                </div>

            </div>

            <div class="widget subscribe-widget clearfix">

                <h4>服务热线</h4>
                <h5>有任何问题，可以及时联系我们！</h5>
                <!--<form action="/contactUS" method="POST" class="notopmargin nobottommargin">-->
                    <div class="divcenter">
                        <textarea class="form-control" v-model="msg" rows="3"></textarea>
                        <!--<input type="text" class="form-control" placeholder="Enter your Email" required="">-->
                        <div class="input-group-append">
                            <button class="btn btn-success" @click="contactUS"><i class="icon-email2"></i></button>
                        </div>
                    </div>
                <!--</form>-->
            </div>

        </div>

    </div><!-- .sidebar end -->

</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import Swal from 'sweetalert2'

    export default {
        data: function () {
            return {
                msg:""
            }
        },
        methods: {
            contactUS(){
                Swal.fire({
                    title: "联系三澤药房",
                    confirmButtonText: '确认',
                    text: "我们将第一时间联系你！",
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                    return axios.post("/contactUS", {message:this.msg})
                        .then(response => response.data)
                        .then(data => {
                    })
                    }
                })
            },
            SwitchCatalogue(catid,subid){
                const currentCatalogue={
                    catalogueID:catid,
                    subcatalogueID:subid
                };
                this.$store.commit("system/set_current_subCatalogue_id",currentCatalogue);
                this.$router.push({name:'subcatalogue',params:{subid:subid,catid:catid}})
            }
        },
        mounted(){
            this.$store.dispatch("system/load_management_info");
        },
        computed:{
            ...mapState({
                catalogues: state =>state.system.catalogues,
                current_Catalogue_id: state=>state.system.current_Catalogue_id,
                current_SubCatalogue_id: state=>state.system.current_SubCatalogue_id,
                top5: state =>state.system.top5
            })
        }
    }
</script>

<style lang="css">
    .current_subcatalogue{
        border-bottom: solid 2px #1ABC9C;
    }
    .badge-secondary{
        background-color: #1ABC9C;
    }
</style>