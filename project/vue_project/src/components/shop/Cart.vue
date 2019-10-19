<template>
  <div class="container clearfix">
      <div class="table-responsive">
        <table class="table cart">
          <thead>
            <tr>
              <th class="cart-product-remove">&nbsp;</th>
              <th class="cart-product-thumbnail">&nbsp;</th>
              <th class="cart-product-name">Product</th>
              <th class="cart-product-price">Unit Price</th>
              <th class="cart-product-quantity">Quantity</th>
              <th class="cart-product-subtotal">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr class="cart_item" v-for="cartitem in cart.cartitems">
              <td class="cart-product-remove">
                <a href="#" class="remove" title="Remove this item" @click="remove_fullitem(cartitem.product.slug)"><i class="icon-trash2"></i></a>
              </td>

              <td class="cart-product-thumbnail">
                <a href="#"><img width="64" height="64" :src="cartitem.product.avatar" alt="Pink Printed Dress"></a>
              </td>

              <td class="cart-product-name">
                <a href="#">{{cartitem.product.name}}</a>
              </td>

              <td class="cart-product-price">
                <span class="amount">{{cartitem.product.price | currency}}</span>
              </td>

              <td class="cart-product-quantity">
                <div class="quantity clearfix">
                  <input type="button" value="-" class="minus" @click="remove_quantity(1,cartitem.product.slug)">
                  <input type="text" name="quantity" :value="cartitem.quantity" class="qty" />
                  <input type="button" value="+" class="plus" @click="add_quantity(1,cartitem.product.slug)">
                </div>
              </td>

              <td class="cart-product-subtotal">
                <span class="amount">{{cartitem.sub_total|currency}}</span>
              </td>
            </tr>

          </tbody>

        </table>
      </div>

      <div class="row clearfix">
        <div class="col-lg-6 clearfix">
          <h4>Cart Totals</h4>

          <div class="table-responsive">
              <table class="table cart">
                <tbody>
                  <tr class="cart_item">
                    <td class="cart-product-name">
                      <strong>Cart Subtotal</strong>
                    </td>

                    <td class="cart-product-name text-right">
                      <span class="amount">{{cart.summary.Total|currency}}</span>
                    </td>
                  </tr>
                  <tr class="cart_item">
                    <td class="cart-product-name">
                      <strong>Tax</strong>
                    </td>

                    <td class="cart-product-name text-right">
                      <span class="amount">{{parseInt(cart.summary.Total*0.1)|currency}}</span>
                    </td>
                  </tr>
                  <tr class="cart_item">
                    <td class="cart-product-name">
                      <strong>Total</strong>
                    </td>

                    <td class="cart-product-name text-right">
                      <span class="amount color lead"><strong>{{cart.summary.Total+parseInt(cart.summary.Total*0.1)|currency}}</strong></span>
                    </td>
                  </tr>
                </tbody>

              </table>
          </div>
        </div>

        <div class="col-lg-6 text-right vertical-middle clearfix">
            <router-link :to="{name:'checkout'}" class="button button-reveal button-xlarge button-rounded tright"><i class="icon-angle-right"></i><span>Checkout Now</span></router-link>
<!--             <a href="#"  class="button button-reveal button-xlarge button-rounded tright"><i class="icon-angle-right"></i><span>Checkout Now</span></a> -->
          </div>
      </div>
  </div>

</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"

  import {setToken,getToken,showNotification,FetchAddressByPostcode} from "../../lib/util.js"
  // import Swal from 'sweetalert2'

  export default {
    name: 'cart',
    data () {
      return {
        address:{
          postcode:"",
          address1:"",
          address2:"",
          detail:"",
          phone:"",
          customer:""
        }
      }
    },
  computed: {
    cart(){
      return this.$store.state.lotteryshop.cart
    }
  },
  mounted() {
    this.checkIsEmptyCart()
  },
  methods: {
    checkIsEmptyCart(){
      if(this.cart.summary.Qty==0){
        this.$router.push({ path: '/' })
      }
    },
    goToCheck(){
      this.$validator.validateAll().then((result) => {
            if (result) {
               //エラーがなかった時の処理を下に記述
            }
        });
    },
    getAddressFromPostcode(){
      if(this.address.postcode.length>3){
        FetchAddressByPostcode(this.address.postcode).then(
          resolve=>{
            if(resolve.result){
              this.address.address1=resolve.data.address1+resolve.data.address2
              this.address.address2=resolve.data.address3
            }else{
              showNotification("invalid postcode","warning")
            }
          },reject=>{})
      }
    },
    login_check(){
      const jwt_token=getToken("jwt_token")

      if (jwt_token == undefined || jwt_token ==null){
        Swal.fire({
          type:"warning",  
          title: 'Oops...',
          text: 'You have to login!',
        })
        return false
      }

      return true
    },
    remove_quantity(quantity,product_slug){
      if(this.login_check()){
          const params={
            product_slug:product_slug,
            quantity:quantity
          }
        this.$store.dispatch("lotteryshop/removeFromCart",params)
      }
    },
    add_quantity(quantity,product_slug){
      if(this.login_check()){
        const params={
            product_slug:product_slug,
            quantity:quantity
          }
        this.$store.dispatch("lotteryshop/addToCart",params)
      }
    },
    remove_fullitem(product_slug){
      if(this.login_check()){
        const params={
            product_slug:product_slug
          }
        this.$store.dispatch("lotteryshop/removeFullItemFromCart",params)
      }
    }
  }
};
</script>

<style lang="scss">
</style>