<template>

<div class="container clearfix mt-3">
<!--     <div class="promo promo-dark promo-flat bottommargin" v-if="order_placed">
        <h3><span>Order No: </span> {{order_slug}} </h3>
        <span>Your order has been place at {{order_created_at}}</span>
        
        <div class="col_full clearfix">
                <a href="javascript:void(0);"  @click="PayBill(order_slug,'WechatPay')">
                    <i class="i-circled i-light wechat_color fab fa-weixin"></i>
                </a>
                <a href="javascript:void(0);"  @click="PayBill(order_slug,'AliPay')">
                    <i class="i-circled i-light alipay_color fab fa-alipay"></i>
                </a>                
                <a href="javascript:void(0);"  @click="PayBill(order_slug,'LINE')">
                    <i class="i-circled i-light wechat_color fab fa-line"></i>
                </a>
                <a href="javascript:void(0);"  @click="PayBill(order_slug,'CPM')">
                    <i class="i-circled i-light fas fa-qrcode"></i>
                </a>
                <a href="javascript:void(0);"  @click="PayBill(order_slug,'CARD')">
                    <i class="i-circled i-light credit_color fas fa-credit-card"></i>
                </a>
        </div>
    </div> -->
    <PayBill :order_slug="order_slug" :order_created_at="order_created_at"  v-if="order_placed"></PayBill>
    <div class="col_half col_last"  v-if="!order_placed">
        <div class="card">
            <div class="card-body">
                Have a coupon? <a href="javascript:void(0);" @click="userCoupon">{{$t("m.use_coupon")}}</a>
            </div>
        </div>
    </div>

    <div class="clear"></div>
    <div class="row clearfix">
        <div class="col-lg-6" v-if="!order_placed">
            <h3 class="">{{$t("m.shippingaddress")}}</h3>
            <div class="alert alert-warning" v-if="existed_customer">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon-warning-sign"></i><strong>Warning!</strong> You are trying to update existed customer information.
            </div>
            <div class="col_half">
                <label for="shipping-form-name">{{$t("m.first_name")}}:</label>
                <input type="text" id="shipping-form-name" name="shipping-form-name" value="" class="sm-form-control" data-vv-as="First Name" v-validate="'required'" :class="{'input': true, 'form-danger': errors.has('shipping-form-name') }" v-model="address.first_name" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-name')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-name') }}</p>
                </div>
            </div>

            <div class="col_half col_last">
                <label for="shipping-form-lname">{{$t("m.last_name")}}:</label>
                <input type="text" id="shipping-form-lname" name="shipping-form-lname" value="" class="sm-form-control" data-vv-as="Last Name" v-validate="'required'" :class="{'input': true, 'form-danger': errors.has('shipping-form-lname') }" v-model="address.last_name" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-lname')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-lname') }}</p>
                </div>
            </div>

            <div class="clear"></div>
            <div class="col_full">
                <label for="shipping-form-email">{{$t("m.shop_email")}}</label>
                <input type="text" id="shipping-form-email" name="shipping-form-email" value="" class="sm-form-control" data-vv-as="Email" v-validate="'required|email'" :class="{'input': true, 'form-danger': errors.has('shipping-form-email') }" v-model="address.email" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-email')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-email') }}</p>
                </div>
            </div>

            <div class="col_half">
                <label for="shipping-form-phone">{{$t("m.shop_phone")}}</label>
                <input type="text" id="shipping-form-phone" name="shipping-form-phone" value="" class="sm-form-control" data-vv-as="Phone" v-validate="'required|min:6'" :class="{'input': true, 'form-danger': errors.has('shipping-form-phone') }" v-model="address.phone" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-phone')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-phone') }}</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col_half">
                <label for="shipping-form-postcode">{{$t("m.shop_postcode")}}:</label>
                <input type="text" id="shipping-form-postcode" name="shipping-form-postcode" value="" class="sm-form-control" data-vv-as="PostCode" v-validate="'required|min:4'" :class="{'input': true, 'form-danger': errors.has('shipping-form-postcode') }" v-model="address.postcode" @blur="getAddressFromPostcode" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-postcode')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-postcode') }}</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col_half">
                <label for="shipping-form-state">{{$t("m.state")}}</label>
                <input type="text" id="shipping-form-state" name="shipping-form-state" value="" class="sm-form-control" data-vv-as="State / City" v-validate="'required|min:3'" :class="{'input': true, 'form-danger': errors.has('shipping-form-state') }" v-model="address.state" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-state')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-state') }}</p>
                </div>
            </div>
            <div class="col_half col_last">
                <label for="shipping-form-city">{{$t("m.town")}}:</label>
                <input type="text" id="shipping-form-city" name="shipping-form-city" value="" class="sm-form-control" data-vv-as="Town" v-validate="'required|min:3'" :class="{'input': true, 'form-danger': errors.has('shipping-form-city') }" v-model="address.city" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-city')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-address') }}</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col_full">
                <label for="shipping-form-address">{{$t("m.shop_address")}} :</label>
                <input type="text" id="shipping-form-address" name="shipping-form-address" value="" class="sm-form-control" data-vv-as="Address" v-validate="'required|min:3'" :class="{'input': true, 'form-danger': errors.has('shipping-form-address') }" v-model="address.street_address1" />
                <div class="form-control-feedback" v-show="errors.has('shipping-form-address')">
                    <p class="alert alert-danger">{{ errors.first('shipping-form-address') }}</p>
                </div>
            </div>
            <div class="col_full">
                <input type="text" id="shipping-form-address2" name="shipping-form-adress2" value="" class="sm-form-control" v-model="address.street_address2" />
            </div>
            <div class="col_full">
                <label for="shipping-form-message">{{$t("m.note")}} <small>*</small></label>
                <textarea class="sm-form-control" id="shipping-form-message" name="shipping-form-message" rows="6" cols="30" v-model="note"></textarea>
            </div>
        </div>

        <div class="col-lg-6" v-else-if="order_placed">
            <h3 class="">{{$t("m.shop_customer")}} </h3>
            <div class="card">
                <div class="card-header">{{$t("m.shippingaddress")}}</div>
                <div class="card-body">
                    <p class="card-text">
                        {{$t("m.first_name")}}: {{address.first_name}}
                        <br> {{$t("m.last_name")}}: {{address.last_name}}
                        <br> {{$t("m.shop_email")}}:{{address.email}}
                        <br> {{$t("m.shop_phone")}}:{{address.phone}}
                    </p>

                </div>
            </div>

            <div class="card">
              <div class="card-header">{{$t("m.shippingaddress")}}</div>
              <div class="card-body">
                  <p class="card-text">
                      〒{{address.postcode}}
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
            <h4>{{$t("m.cartinfo")}}</h4>

            <div class="table-responsive">
                <table class="table cart">
                    <tbody>
                        <tr class="cart_item">
                            <td class="notopborder cart-product-name">
                                <strong>{{$t("m.shop_cart_subtotal")}}</strong>
                            </td>

                            <td class="notopborder cart-product-name">
                                <span class="amount">{{cart.summary.Total | currency_jpy }}</span>
                            </td>
                        </tr>
                        <tr class="cart_item">
                            <td class="cart-product-name">
                                <strong>{{$t("m.shop_tax")}}</strong>
                            </td>

                            <td class="cart-product-name">
                                <span class="amount">{{cartTax|currency_jpy}}</span>
                            </td>
                        </tr>
                        <tr class="cart_item bg-danger text-white" v-if="hascoupon">
                            <td class="cart-product-name">
                                <strong>{{$t("m.coupon")}}</strong>
                            </td>

                            <td class="cart-product-name">
                                <span class="amount">
                                -{{couponAmount|currency_jpy}}
                              </span>
                            </td>
                        </tr>
                        <tr class="cart_item">
                            <td class="cart-product-name">
                                <strong>{{$t("m.shop_total")}}</strong>
                            </td>

                            <td class="cart-product-name">
                                <span class="amount color lead"><strong>{{CartFinalTotal|currency_jpy}}</strong></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
<!--           <div class="fancy-title title-bottom-border">
            <h4><span>支払いについて</span></h4>
          </div>
            <div class="accordion clearfix">
                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Direct Bank Transfer</div>
                <div class="acc_content clearfix">Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</div>

                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Cheque Payment</div>
                <div class="acc_content clearfix">Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.</div>

                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Paypal</div>
                <div class="acc_content clearfix">Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur.</div>
            </div> -->
            <a href="javascript:void(0);" class="button button-3d fright" @click="PlaceOrder" v-if="!order_placed">{{$t("m.placeOrder")}}</a>
        </div>
    </div>


    <div class="w-100 bottommargin"></div>
    <div class="col-lg-12">
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
</div>

</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"

  import {setToken,getToken,showNotification,FetchAddressByPostcode,utf16to8} from "../../lib/util.js"
  import Swal from 'sweetalert2'
  import PayBill from "./parts/PayBill.vue"


  export default {
    name: 'Checkout',
    components:{
        PayBill
    },
    data () {
      return {
        address:{
          first_name:"",
          last_name:"",
          postcode:"",
          state:"",
          city:"",
          email:"",
          street_address1:"",
          street_address2:"street_address2",
          phone:"",
        },
        note:"note added",
        existed_customer:false,
        existed_customer_slug:"",
        order_slug:"",
        order_placed:false,
        order_created_at:"",
        hascoupon:false,
        coupon:{
          id:"",
          coupontype:"",
          discount:0,
          description:""
        }
      }
    },
  computed: {
    cart(){
      return this.$store.state.lotteryshop.cart
    },
    couponAmount(){
      if(this.hascoupon){
        if(this.coupon.coupontype=="amount"){
          return this.coupon.discount
        }
        if(this.coupon.coupontype=="ratio"){
          return parseInt(this.cart.summary.Total*this.coupon.discount/100)
        }
      }else{
        return 0;
      }

    },
    cartTax(){
      return parseInt(this.cart.summary.Total*0.1)
    },
    CartFinalTotal(){
      return this.cart.summary.Total+this.cartTax-this.couponAmount
    }
  },
  mounted() {
    this.checkIsEmptyCart()
  },
  methods: {
    async userCoupon(){
        var vm=this;
        const { value: file } = await Swal.fire({
                  title: 'Scan CouponQR',
                  input: 'file',
                  inputAttributes: {
                    accept: 'image/*',
                    'aria-label': 'Upload your profile picture'
                  }
                })

        if (file) {
          const reader = new FileReader()
          reader.onload = (e) => {
            let formData = new FormData();
            formData.append('cpm_code', file)
            // formData.append('coupon', order_slug)
            formData.append('QRType', "coupon")

              Swal.fire({
                // title: 'Auto close alert!',
                html: 'Validating Your Coupon Code',
                // timer: 2000,
                // timerProgressBar: true,
                allowOutsideClick: function() {
                    return !Swal.isLoading();
                  },
                onBeforeOpen: () => {
                  Swal.showLoading()

                    axios.post(`/api/shop_order/scanQR/`,formData,{
                                headers: {
                                    'Content-type':'multipart/form-data'
                                }
                            }
                        ).then(response => {
                            if (!response.data.result) {
                                vm.hascoupon=false
                                vm.coupon={
                                      id:"",
                                      coupontype:"",
                                      discount:0,
                                      description:""
                                    }
                                Swal.fire({
                                  type:"danger",
                                  html: 'Invalid Coupon'
                                })

                                throw new Error(response.statusText)
                            }
                            vm.hascoupon=true
                            vm.coupon= response.data.coupon

                            var message = 'Discount: '+ String(vm.couponAmount) 


                            Swal.fire({
                              title: 'Coupon Validated ',
                              html: message,
                              imageUrl: e.target.result,
                              imageAlt: 'The uploaded picture'
                            })
                      })
                      .catch(error => {
                            Swal.fire({
                              type:"danger",
                              html: 'Coupon does not Exist!'
                            })
                      })
                }
              }).then((result) => {
                console.log(result)

              })

          }
          reader.readAsDataURL(file)
        }
    },
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
                  coupon:this.coupon.id,
                  discount:this.couponAmount,
                  existed_customer:this.existed_customer,
                  existed_customer_slug:this.existed_customer_slug,
                  cartTax:this.cartTax,
                  CartFinalTotal:this.CartFinalTotal,
               }
               this.$store.dispatch("lotteryshop/placeOrder",params).then(resolve=>{
                      console.log("placed successfully")
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

            }else{
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: this.$t("m.inputmissing")
              })
            }
        });
    },
    getAddressFromPostcode(){
      if(this.address.postcode.length>3){
        FetchAddressByPostcode(this.address.postcode).then(
          resolve=>{
              this.address.state=resolve.address.state
              this.address.city=resolve.address.city
              this.address.street_address1=resolve.address.street_address1
          },reject=>{
            showNotification(reject.message,"warning")
          })
      }
    },    
    utf16to8(str) { //二维码编码前把字符串转换成UTF-8
        var out, i, len, c; 
            out = ""; 
            len = str.length; 
        for(i = 0; i < len; i++) { 
            c = str.charCodeAt(i); 
            if ((c >= 0x0001) && (c <= 0x007F)) { 
                out += str.charAt(i); 
            } else if (c > 0x07FF) { 
                out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F)); 
                out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F)); 
                out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F)); 
            } else { 
                out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F)); 
                out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F)); 
            } 
        } 
        return out; 
    },
    async PayBill(order_slug,payment){
        var icon_pay="";
        switch (payment){
            case "WechatPay":
                icon_pay= "wechat_color fab fa-weixin";
                break;
            case "AliPay":
                icon_pay = "alipay_color fab fa-alipay";
                break;
            case "LINE":
                icon_pay = "wechat_color fab fa-line";
                break;
            case "CARD":
                icon_pay = "credit_color fas fa-credit-card";
        }

        if(payment=="CPM"){
                const { value: file } = await Swal.fire({
                  title: 'Select image',
                  input: 'file',
                  inputAttributes: {
                    accept: 'image/*',
                    'aria-label': 'Upload your profile picture'
                  }
                })

                if (file) {
                  const reader = new FileReader()
                  reader.onload = (e) => {
                    let formData = new FormData();
                    formData.append('cpm_code', file)
                    formData.append('order_slug', order_slug)
                    formData.append('QRType', "Coupon")

                    axios.post(`/api/shop_order/scanQR/`,formData,{
                                headers: {
                                    'Content-type':'multipart/form-data'
                                }
                            }
                        ).then(response => {
                        if (!response.data.result) {
                          throw new Error(response.statusText)
                        }
                        console.log(response.data)
                        Swal.fire({
                          title: 'response.data.message',
                          html:response.data.QRCODE,
                          imageUrl: e.target.result,
                          imageAlt: 'The uploaded picture'
                        })
                      })
                      .catch(error => {
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Unknown PayCode!',
                        })
                      })
                  }
                  reader.readAsDataURL(file)
                }
        }

        Swal.fire({
          title: '<i class="i-circled i-light'+icon_pay+'"></i>',
          showCancelButton: true,
          confirmButtonText: 'Go to Pay',
          showLoaderOnConfirm: true,
          preConfirm: () => {
            return axios.post(`/api/shop_order/getPayQR/`,{
                "order_slug": order_slug,
                "brandType": payment
            }).then(response => {
                if (!response.data.result) {
                  throw new Error(response.statusText)
                }
                return response.data
              })
              .catch(error => {
                Swal.showValidationMessage(
                  `Request failed: ${error}`
                )
              })
          },
          allowOutsideClick: () => !Swal.isLoading()
        })
        .then((result) => {
            console.log(result)
            if(result.value.result){
                if(result.value.brandType =="CARD"){
                    Swal.fire({
                      title: '<i class="i-circled i-light wechat_color fas fa-envelope"></i>',
                      html: result.value.message,
                    })
                }else{
                    Swal.fire({
                      title: '<i class="i-circled '+icon_pay+'"></i>',
                      html: 'PayCode: '+result.value.paymemocode,
                      imageUrl: result.value.QRurl,
                      imageWidth: 320,
                      imageHeight: 320,
                    })
                }

            }
          // if (result.value.QRurl) {
          //   Swal.fire({
          //     title: '<i class="i-circled '+icon_pay+'"></i>',
          //     html: '<div id="paymentQRCode"></div>',
          //     allowOutsideClick: () => false
          //   })
          //   $("#paymentQRCode").qrcode({
          //       render:"canvas",
          //       width: 320,//宽度
          //       height: 320,//高度
          //       correctLevel:3,
          //       text: this.utf16to8(result.value.QRurl),
          //   });
        })
    }
  }
};
</script>

<style lang="scss">
.credit_color{
    color:#f08200;
}
</style>