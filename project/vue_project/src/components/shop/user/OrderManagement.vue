<template>
<div class="container clearfix">

  <div class="postcontent nobottommargin col_last">
    

          <div class="table-responsive">
            <table class="table cart">
              <thead>
                <tr>
                  <th class="cart-product-remove">&nbsp;</th>
                  <th class="cart-product-name">Customer</th>
                  <th class="cart-product-price">Total</th>
                  <th class="cart-product-quantity">Logistic</th>
                  <th class="cart-product-subtotal">Created</th>
                </tr>
              </thead>
              <tbody>
                <tr class="cart_item" v-for="order in orders">
                  <td class="cart-product-remove">
                    <a href="#" class="remove" title="Remove this item"><i class="icon-trash2"></i></a>
                  </td>

                  <td class="cart-product-name">
                    <a href="#">{{order.last_name}} {{order.first_name}}</a>
                  </td>

                  <td class="cart-product-price">
                    <span class="amount">{{order.total|currency}}</span>
                    <span class="badge badge-success" v-if="order.discount >0">{{order.discount|currency}}</span>
                  </td>

                  <td class="cart-product-name">
                    <a href="" class="btn btn-info text-white">
                      {{order.logistic}} oooo<span class="badge badge-light">M</span>
                    </a>
                  </td>

                  <td class="cart-product-name">
                    <span class="" >{{order.created_at|StandardDate}}</span>
                  </td>
                </tr>
              </tbody>

            </table>
          </div>

  </div>

<!--   <div class="sidebar nobottommargin">
    <div class="sidebar-widgets-wrap">

      <div class="widget widget-filter-links clearfix">

        <h4>Select Category</h4>
        <ul class="custom-filter" data-container="#shop" data-active-class="active-filter">
          <li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
          <li v-for="item in subcatalogues_now">
            <a href="#" data-filter=".sf-dress">{{item.name}}</a>
            <span>{{item.product_num}}</span>
          </li>
        </ul>
      </div>
    </div>
  </div> -->

</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'


  export default {
    name: 'UserOrderList',
    components:{
    },
    data () {
      return {
        ME:null,
        orders:[]
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
      this.loadMyOrderlist()
    },
    methods: {
      loadMyOrderlist(){
        this.$store.dispatch("orders/getMyOrderList").then(resolve=>{
          if(resolve.result){
            this.orders=resolve.orders
          }
        })
      },
    },
    watch: {
      '$route' (to, from) {
          console.log("watch route222")
          const to_id=to.params.catalogue_id
          const from_id =from.params.catalogue_id
          if(from_id !== to_id){
            this.loadCatalogueProducts(to_id)
          }
      }
  }
};
</script>

<style lang="scss">
</style>