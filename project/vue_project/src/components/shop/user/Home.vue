<template>
<div class="container clearfix">


  <SideMenu></SideMenu>
  <div class="postcontent nobottommargin col_last">
  Hello
  </div>
</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'

  import SideMenu from "./parts/SideMenu.vue"

  export default {
    name: 'UserOrderDetail',
    components:{
      SideMenu
    },
    data () {
      return {
        ME:null,
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
      // this.loadOrderDetail()
    },
    methods: {
      // loadOrderDetail(){
      //   const slug=this.$route.params.slug;
      //   var vm = this;
      //   this.$store.dispatch("orders/getOrderBySlug",slug).then(resolve=>{
      //       this.order=resolve.order;
      //   },reject=>{
      //       window.location.href="/shop/#/user/orderlist"
      //   })
      // },
    },
    watch: {
      '$route' (to, from) {
          // const to_id=to.params.slug
          // const from_id =from.params.slug
          // if(from_id !== to_id){
          //   this.loadOrderDetail(to_id)
          // }
      }
  }
};
</script>

<style lang="scss">
abbr strong {
  display: inline-block;
  width: 80px;
  text-align: right;
  margin-right: 10px;
}
abbr{
  font-size:16px;
}
</style>