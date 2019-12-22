<template>
  <div class="sidebar nobottommargin">
    <div class="sidebar-widgets-wrap">

      <div class="widget widget-filter-links clearfix">

        <h4>User Menu</h4>
        <ul class="custom-filter" data-container="#shop" data-active-class="active-filter">
          <li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
          <li>
            <router-link :to="{name:'orderlist'}"><i class="fas fa-clipboard-list rightmargin-5"></i>{{$t("m.shop_orderlist")}}</router-link>
          </li>          
          <li>
            <router-link :to="{name:'favorites'}"><i class="fab fa-gratipay text-danger rightmargin-5"></i>Favorites</router-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"


  export default {
    name: 'UserSideMenu',
    components:{

    },
    data () {
      return {
        ME:null,
      }
    },
  computed: {

  },
    mounted() {
    },
    methods: {
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