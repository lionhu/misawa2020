<template>
<div class="container clearfix">

  <div class="sidebar nobottommargin">
    <div class="sidebar-widgets-wrap">

      <div class="widget widget-filter-links clearfix">

        <h4>Select Category</h4>
        <ul class="custom-filter" data-container="#shop" data-active-class="active-filter">
          <li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
          <li>
            <router-link :to="{name:'orderlist'}">{{$t("m.shop_orderlist")}}</router-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="postcontent nobottommargin col_last">
  Hello
  </div>
</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'


  export default {
    name: 'UserOrderDetail',
    components:{

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