<template>
<div class="container clearfix">
  <SideMenu></SideMenu>
  <div class="postcontent nobottommargin col_last">
            <div id="portfolio" class="portfolio grid-container portfolio-nomargin portfolio-full portfolio-masonry mixed-masonry grid-container clearfix">

          <article class="portfolio-item pf-media pf-icons wide" v-for="item in tableData">
            <div class="portfolio-image">
              <a href="portfolio-single.html">
                <img :src="item.avatar" :alt="item.name">
              </a>
              <div class="portfolio-overlay">
                <a href="javascript:void(0);" class="left-icon" @click="DeleteMyFavoriate(item.slug)"><i class="far fa-trash-alt" style="margin-top:24%;"></i></a>
                <router-link :to="{name:'product_article',params:{slug:item.slug}}" class="right-icon"><i class="icon-line-ellipsis"></i></router-link>
              </div>
            </div>
          </article>

        </div><!-- #portfolio end -->
  </div>
</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import { Table,TableColumn,Pagination,Form,FormItem } from 'element-ui';
  import {setToken,getToken,showNotification} from "../../../lib/util.js"
  import 'element-ui/lib/theme-chalk/index.css';
  import SideMenu from "./parts/SideMenu.vue"

  export default {
    name: 'UserOrderList',
    components:{
      elTable: Table,
      elTableColumn: TableColumn,
      elPagination:Pagination,
      elForm:Form,
      elFormItem:FormItem,
      SideMenu
    },
    data () {
      return {
        ME:null,
        // orders:[],
        tableData: [],
        order_summaries:{},
        total:0,
        pagesize:10,
        currentPage:1,
      }
    },
  computed: {
    // catalogue_products:function(){
    //   return this.$store.state.lotteryshop.catalogue_products
    // },
    // subcatalogues_now:function(){
    //   const catalogue = this.$store.state.lotteryshop.catalogue_now
    //   return catalogue.subcatalogues
    // },
  },
    mounted() {
      this.loadMyFavorites()
    },
    methods: {
      current_change:function(currentPage){
          console.log(currentPage)
          this.currentPage = currentPage;
      },
      loadMyFavorites(){
        this.$store.dispatch("lotteryshop/getMyFavoriates").then(resolve=>{
          if(resolve.result){
            console.log(resolve.favorites)
            this.tableData= resolve.favorites
            // this.ME= this.$store.state.users.profile.user;
            // this.order_summaries= resolve.summary
            this.total=this.tableData.length;
          }
        })
      },
      DeleteMyFavoriate(slug){
        var vm = this;
        this.$store.dispatch("lotteryshop/DeleteMyFavoriate",slug).then(resolve=>{
          if(resolve.result){
            console.log(resolve.favorites)
            showNotification('<i class="far fa-trash-alt"></i>',"success")
            const itemIndex = vm.tableData.findIndex(product=>product.slug==slug);

            if (itemIndex > -1){
              vm.tableData.splice(itemIndex,1)
            }
          }
        })
      },
      SelectOrder(row, event, column){
        this.$router.push({ name: 'orderdetail', params: { slug: row.slug }})
      },
    },
    watch: {
      '$route' (to, from) {
          // console.log("watch route222")
          // const to_id=to.params.catalogue_id
          // const from_id =from.params.catalogue_id
          // if(from_id !== to_id){
          //   this.loadCatalogueProducts(to_id)
          // }
      }
  }
};
</script>

<style lang="scss">
.el-table th, .el-table tr {
  background-color:#FFF;
}
.el-table thead {
    color: #909399!important;
}
table {
  margin-bottom :0 !important;
}
.right-corner{
  position:absolute;
  top:5px;
  right:30px;
}
.delivery_status{
  position:absolute!important;
  top: 5px!important;
}
</style>