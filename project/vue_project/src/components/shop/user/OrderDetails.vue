<template>
<div class="container clearfix">

<!--   <div class="sidebar nobottommargin">
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
  </div> -->
  <SideMenu></SideMenu>
  <div class="postcontent nobottommargin col_last">
    <div class="col_half card">
        <div class="card-header">{{$t("m.shop_customer")}}</div>
        <div class="card-body">
            <address>
                <abbr><strong>{{$t("m.shop_address")}}:</strong>〒{{order.address.postcode}}</abbr><br>
                <abbr><strong></strong>{{order.address.state}}{{order.address.city}}</abbr><br>
                <abbr><strong></strong>{{order.address.street_address1}}{{order.address.street_address2}}</abbr><br>
                <abbr><strong>{{$t("m.shop_customer")}}:</strong>{{order.address.first_name}} {{order.address.last_name}}</abbr><br>
                <abbr><strong>{{$t("m.shop_email")}}:</strong>{{order.address.email}}</abbr><br>
                <abbr><strong>{{$t("m.shop_phone")}}:</strong>{{order.address.phone}}</abbr><br>
            </address>
        </div>
    </div>
    <div class="col_half card col_last">
        <div class="card-header">{{$t("m.shop_summary")}}
          <span v-if="order.discount"><i class="fas fa-tags text-danger"></i></span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
              <table class="table cart">
                <tbody>
                  <tr class="cart_item">
                    <td class="notopborder cart-product-name">
                      <strong>{{$t("m.shop_cart_subtotal")}}</strong>
                    </td>

                    <td class="notopborder cart-product-name tright">
                      <span class="amount">{{order.total|currency_jpy}}</span>
                    </td>
                  </tr>
                  <tr class="cart_item">
                    <td class="cart-product-name">
                      <strong>{{$t("m.shop_tax")}} </strong>
                    </td>

                    <td class="cart-product-name tright">
                      <span class="amount">{{order.tax|currency_jpy}}</span>
                    </td>
                  </tr>
                  <tr class="cart_item">
                    <td class="cart-product-name">
                      <strong>{{$t("m.shop_total")}}</strong>
                    </td>

                    <td class="cart-product-name tright">
                      <span class="amount lead text-danger" v-if="order.discount"><strong>-{{order.discount|currency_jpy}}</strong></span> <br>
                      <span class="amount color lead"><strong>{{order.total + order.tax-order.discount|currency_jpy}}</strong></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
    </div>
    <div class="col_full">
        <h4>{{$t("m.shop_ordercontent")}}</h4>
        <div class="table-responsive">
          <table class="table cart">
            <thead>
              <tr>
                <th class="cart-product-thumbnail">&nbsp;</th>
                <th class="cart-product-name">{{$t("m.shop_product")}}</th>
                <th class="cart-product-quantity">{{$t("m.shop_quantity")}}</th>
                <th class="cart-product-subtotal">{{$t("m.shop_subtotal")}}</th>
              </tr>
            </thead>
            <tbody>
              <tr class="cart_item" v-for="item in order.cartjson.cartitems">
                <td class="cart-product-thumbnail">
                  <a href="#"><img width="64" height="64" :src="item.product.avatar" :alt="item.product.name"></a>
                </td>

                <td class="cart-product-name">
                  <a href="#">{{item.product.name}}</a>
                </td>

                <td class="cart-product-quantity">
                  <div class="quantity clearfix">
                    1x{{item.quantity}}
                  </div>
                </td>

                <td class="cart-product-subtotal">
                  <span class="amount">{{item.sub_total|currency}}</span>
                </td>
              </tr>
            </tbody>

          </table>
        </div>
    </div>
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
        order:{
          cartjson:{
            cartitems:[]
          },
          address:{
            postcode:""
          }
        }
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
      this.loadOrderDetail()
    },
    methods: {
      loadOrderDetail(){
        const slug=this.$route.params.slug;
        var vm = this;
        this.$store.dispatch("orders/getOrderBySlug",slug).then(resolve=>{
            this.order=resolve.order;
        },reject=>{
            window.location.href="/shop/#/user/orderlist"
        })
      },
    },
    watch: {
      '$route' (to, from) {
          const to_id=to.params.slug
          const from_id =from.params.slug
          if(from_id !== to_id){
            this.loadOrderDetail(to_id)
          }
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