<template>

    <div class="postcontent nobottommargin" :style="dynamicHeight">
        <div class="shop product-3 grid-container clearfix" data-layout="fitRows" >
            <Product v-for="product in CatalogueProducts" :key="product.id" :product="product"></Product>
        </div><!-- #shop end -->
    </div>

</template>

<script>
    import Product from "./parts/Product"

    export default {
        components:{
          Product
        },
        data: function () {
            return {
                CatalogueProducts:[],
                dynamicHeight:{
                    height:''
                }
            }
        },
        methods: {
            getContentHeight(){
                this.dynamicHeight.height=window.innerHeight+70+'px';
                console.log(this.dynamicHeight.height)
            },
            loadCatalogueProducts(){
                const currentCatID=this.$route.params.catid;
                const currentSubCatID=this.$route.params.subid;

                const _Cat=this.$store.state.system.catalogues.filter(catalogue =>catalogue.value==currentCatID);

                if(_Cat !=undefined && _Cat.length){
                    const _SubCat=_Cat[0].children.filter(subcatalogue =>subcatalogue.value==currentSubCatID);

                    if(_SubCat !=undefined && _SubCat.length){
                        this.CatalogueProducts=_SubCat[0].products;
                    }else{
                        this.$router.push({ name: 'subcatalogue', params: { catid: 3,subid:33 }})
                    }
                }else{
                    this.$router.push({ name: 'subcatalogue', params: { catid: 3,subid:33 }})
                }
                this.$forceUpdate();
            },
        },
        created(){
            window.addEventListener("resize",this.getContentHeight);
            this.getContentHeight();

        },
        destroyed(){
            window.removeEventListener("resize",this.getContentHeight);
        },
        mounted(){
            this.loadCatalogueProducts();
            const currentCatalogue={
                catalogueID:this.$route.params.catid,
                subcatalogueID:this.$route.params.subid,
            };
            this.$store.commit("system/set_current_subCatalogue_id",currentCatalogue);
        },
        computed:{
        },
        watch:{
            $route(to,from){
                this.loadCatalogueProducts(to.params.id);
                this.getContentHeight();
            }
        }
    }
</script>

<style lang="css">

</style>