<template>

<div class="container clearfix">
    <div class="promo promo-dark promo-flat bottommargin" v-if="order_placed">
        <h3><span>Order No: </span> {{order_slug}} </h3>
        <span>Your order has been place at {{order_created_at}}</span>
        <a href="javascript:void(0);" class="button button-dark button-xlarge button-rounded">Successfully!</a>


    </div>
    <div class="col_half">
        <div class="card">
            <div class="card-body">
                Returning customer? <a href="login-register.html">Click here to login</a>
            </div>
        </div>
    </div>
    <div class="col_half col_last">
        <div class="card">
            <div class="card-body">
                Have a coupon? <a href="login-register.html">Click here to enter your code</a>
            </div>
        </div>
    </div>

    <div class="clear"></div>
    <div class="row clearfix">
        <div class="col-lg-6" v-if="!order_placed">
            <h3 class="">Shipping Address</h3>
            <div class="alert alert-warning" v-if="existed_customer">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon-warning-sign"></i><strong>Warning!</strong> You are trying to update existed customer information.
            </div>
            <div class="col_half">
                <label for="shipping-form-name">First Name:</label>
                <input type="text" id="shipping-form-name" name="shipping-form-name" value="" class="sm-form-control" data-vv-as="First Name" v-validate="'required'" :class="{'input': true, 'form-danger': errors.has('shipping-form-name') }" v-model="address.first_name" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-name')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-name') }}</p>
                </div>
            </div>

            <div class="col_half col_last">
                <label for="shipping-form-lname">Last Name:</label>
                <input type="text" id="shipping-form-lname" name="shipping-form-lname" value="" class="sm-form-control" data-vv-as="Last Name" v-validate="'required'" :class="{'input': true, 'form-danger': errors.has('shipping-form-lname') }" v-model="address.last_name" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-lname')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-lname') }}</p>
                </div>
            </div>

            <div class="clear"></div>
            <div class="col_full">
                <label for="shipping-form-email">Email</label>
                <input type="text" id="shipping-form-email" name="shipping-form-email" value="" class="sm-form-control" data-vv-as="Email" v-validate="'required|email'" :class="{'input': true, 'form-danger': errors.has('shipping-form-email') }" v-model="address.email" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-email')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-email') }}</p>
                </div>
            </div>

            <div class="col_half">
                <label for="shipping-form-phone">Phone</label>
                <input type="text" id="shipping-form-phone" name="shipping-form-phone" value="" class="sm-form-control" data-vv-as="Phone" v-validate="'required|min:6'" :class="{'input': true, 'form-danger': errors.has('shipping-form-phone') }" v-model="address.phone" @blur="confirm_exist_customer" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-phone')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-phone') }}</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col_half">
                <label for="shipping-form-postcode">PostCode:</label>
                <input type="text" id="shipping-form-postcode" name="shipping-form-postcode" value="" class="sm-form-control" data-vv-as="PostCode" v-validate="'required|min:4'" :class="{'input': true, 'form-danger': errors.has('shipping-form-postcode') }" v-model="address.postcode" @blur="getAddressFromPostcode" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-postcode')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-postcode') }}</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col_half">
                <label for="shipping-form-state">State / City</label>
                <input type="text" id="shipping-form-state" name="shipping-form-state" value="" class="sm-form-control" data-vv-as="State / City" v-validate="'required|min:3'" :class="{'input': true, 'form-danger': errors.has('shipping-form-state') }" v-model="address.state" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-state')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-state') }}</p>
                </div>
            </div>
            <div class="col_half col_last">
                <label for="shipping-form-city">Town:</label>
                <input type="text" id="shipping-form-city" name="shipping-form-city" value="" class="sm-form-control" data-vv-as="Town" v-validate="'required|min:3'" :class="{'input': true, 'form-danger': errors.has('shipping-form-city') }" v-model="address.city" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-city')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-address') }}</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col_full">
                <label for="shipping-form-address">Address:</label>
                <input type="text" id="shipping-form-address" name="shipping-form-address" value="" class="sm-form-control" data-vv-as="Address" v-validate="'required|min:3'" :class="{'input': true, 'form-danger': errors.has('shipping-form-address') }" v-model="address.street_address1" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-address')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-address') }}</p>
                </div>
            </div>
            <div class="col_full">
                <input type="text" id="shipping-form-address2" name="shipping-form-adress2" value="" class="sm-form-control" v-model="address.street_address2" />
            </div>
            <div class="col_full">
                <label for="shipping-form-message">Notes <small>*</small></label>
                <textarea class="sm-form-control" id="shipping-form-message" name="shipping-form-message" rows="6" cols="30" v-model="note"></textarea>
            </div>
        </div>

        <div class="col-lg-6" v-else-if="order_placed">
            <h3 class="">Customer</h3>
            <div class="card">
                <div class="card-header">Shipping Address</div>
                <div class="card-body">
                    <p class="card-text">
                        First Name: {{address.first_name}}
                        <br> Last Name: {{address.last_name}}
                        <br> Email:{{address.email}}
                        <br> Phone:{{address.phone}}
                    </p>

                </div>
            </div>

            <div class="card">
              <div class="card-header">Shipping Address</div>
              <div class="card-body">
                  <p class="card-text">
                      PostCode:{{address.postcode}}
                      <br> {{address.state}} {{address.city}}
                      <br> {{address.street_address1}}
                      <br> {{address.street_address2}}
                  </p>
            </div>
            <blockquote class="quote">
                <p>{{note}}</p>
                <footer class="blockquote-footer"> note added</footer>
            </blockquote>
        </div>
        </div>
        <div class="col-lg-6">
            <h4>Cart Totals</h4>

            <div class="table-responsive">
                <table class="table cart">
                    <tbody>
                        <tr class="cart_item">
                            <td class="notopborder cart-product-name">
                                <strong>Cart Subtotal</strong>
                            </td>

                            <td class="notopborder cart-product-name">
                                <span class="amount">{{cart.Total | currency }}</span>
                            </td>
                        </tr>
                        <tr class="cart_item">
                            <td class="cart-product-name">
                                <strong>Tax</strong>
                            </td>

                            <td class="cart-product-name">
                                <span class="amount">{{parseInt(cart.summary.Total*0.1)|currency}}</span>
                            </td>
                        </tr>
                        <tr class="cart_item">
                            <td class="cart-product-name">
                                <strong>Total</strong>
                            </td>

                            <td class="cart-product-name">
                                <span class="amount color lead"><strong>{{cart.summary.Total+parseInt(cart.summary.Total*0.1)|currency}}</strong></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
          <div class="fancy-title title-bottom-border">
            <h4><span>支払いについて</span></h4>
          </div>
            <div class="accordion clearfix">
                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Direct Bank Transfer</div>
                <div class="acc_content clearfix">Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</div>

                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Cheque Payment</div>
                <div class="acc_content clearfix">Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.</div>

                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Paypal</div>
                <div class="acc_content clearfix">Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur.</div>
            </div>
            <a href="javascript:void(0);" class="button button-3d fright" @click="PlaceOrder" v-if="!order_placed">Place Order</a>
        </div>
    </div>


    <div class="w-100 bottommargin"></div>
    <div class="col-lg-12">
        <h4>Your Orders</h4>

        <div class="table-responsive">
            <table class="table cart">
                <thead>
                    <tr>
                        <th class="cart-product-thumbnail">&nbsp;</th>
                        <th class="cart-product-name">Product</th>
                        <th class="cart-product-quantity">Quantity</th>
                        <th class="cart-product-subtotal">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="cart_item" v-for="cartitem in cart.cartitems">
                        <td class="cart-product-thumbnail">
                            <a href="#"><img width="64" height="64" :src="cartitem.product.avatar" :alt="cartitem.product.name"></a>
                        </td>

                        <td class="cart-product-name">
                            <a href="#">{{cartitem.product.name}}</a>
                        </td>

                        <td class="cart-product-quantity">
                            <div class="quantity clearfix">
                                1x{{cartitem.quantity}}
                            </div>
                        </td>

                        <td class="cart-product-subtotal">
                            <span class="amount">{{cartitem.sub_total|currency}}</span>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>        
    <div class="divider divider-border divider-center" v-if="order_slug!=''">
      <i class="icon-email2"></i>
    </div>
    <div id="qrcode" class="text-center"></div>
</div>

</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"

  import {setToken,getToken,showNotification,FetchAddressByPostcode} from "../../lib/util.js"
  import Swal from 'sweetalert2'

  export default {
    name: 'cart',
    data () {
      return {
        address:{
          first_name:"HU",
          last_name:"Haiguang",
          postcode:"3360031",
          state:"",
          city:"",
          email:"huhaiguang@me.com",
          street_address1:"",
          street_address2:"street_address2",
          phone:"13816321110",
        },
        note:"note added",
        existed_customer:false,
        existed_customer_slug:"",
        order_slug:"",
        order_placed:false,
        order_created_at:""
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
    confirm_exist_customer(){
      if (this.address.phone.length>6){
        this.$store.dispatch("lotteryshop/getCustomerByPhone",this.address.phone).then(
          resolve=>{
              if(resolve){
                  const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-success',
                      cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                  })

                  swalWithBootstrapButtons.fire({
                    title: 'Update existed customer?',
                    html: '<strong>'+resolve.first_name+" "+resolve.last_name+'</strong>',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, that it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                  }).then((result) => {
                    if (result.value) {
                      this.existed_customer=true
                      this.existed_customer_slug=resolve.slug
                      this.address=resolve
                    }
                  })
              }

          },reject=>{})
      }
    },
    checkIsEmptyCart(){
      if(this.cart.summary.Qty==0){
        this.$router.push({ path: '/' })
      }
    },
    PlaceOrder(){
      this.$validator.validateAll().then((result) => {
            if (result) {
               //エラーがなかった時の処理を下に記述
               const params={
                  address:this.address,
                  note:this.note,
                  coupon:"",
                  existed_customer:this.existed_customer,
                  existed_customer_slug:this.existed_customer_slug,
               }
               this.$store.dispatch("lotteryshop/placeOrder",params).then(resolve=>{
                      console.log("placed successfully")
                      console.log(resolve)
                      this.order_slug=resolve.order_slug
                      this.order_created_at=resolve.created_at
                      this.order_placed=true
                      // console.log(this.order_slug)
                     $("#qrcode").qrcode({
                                render:"canvas",
                                width: 200,//宽度
                                height: 200,//高度
                                correctLevel:3,
                                moduleColor:"#1ABC9C",
                                text: resolve.order_slug
                            });
               },reject=>{})

            }
        });
    },
    getAddressFromPostcode(){
      console.log(this.address.postcode)
      if(this.address.postcode.length>3){
        FetchAddressByPostcode(this.address.postcode).then(
          resolve=>{
            if(resolve.result){
              console.log(resolve.result)
              this.address.state=resolve.data.address1
              this.address.city=resolve.data.address2
              this.address.street_address1=resolve.data.address3
            }else{
              showNotification("invalid postcode","warning")
            }
          },reject=>{})
      }
    },
  }
};
</script>

<style lang="scss">
</style>