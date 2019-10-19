<template>

    <div class="sidebar nobottommargin col_last visible-md">
        <div class="sidebar-widgets-wrap">
            <div class="widget widget_links clearfix">
            <div v-for="catalogue in catalogues" style="padding-top:20px!important;margin-top:20px!important" class="widget widget_links clearfix text-success">
                <h4 style="margin-top: 20px;font-weight: 700;">{{catalogue.label}}</h4>
                <ul>
                    <li v-for="subcatalogue in catalogue.children">
                        <a href="javascript:void(0);" @click="SwitchCatalogue(catalogue.value,subcatalogue.value)">
                            {{subcatalogue.label}}
                            <span class="badge  float-right"
                                :class="{'badge-secondary':subcatalogue.value == current_SubCatalogue_id}"
                                style="margin-left: 10px;">{{subcatalogue.products_count}}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
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
            }
        },
        methods: {
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
            console.log(this.catalogues)
        },
        computed:{
            ...mapState({
                catalogues: state =>state.system.catalogues,
                current_Catalogue_id: state=>state.system.current_Catalogue_id,
                current_SubCatalogue_id: state=>state.system.current_SubCatalogue_id
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