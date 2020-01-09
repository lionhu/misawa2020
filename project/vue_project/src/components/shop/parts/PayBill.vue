<template>
<div class="promo promo-dark promo-flat center bottommargin-sm ">
    <h4 class="text-white">{{$t("m.orderPlaced")}} </h4>
    <span>@ {{order_created_at}}</span>
    <div class="line"></div>
    <h4 class="text-white">{{$t("m.payment")}}</h4>
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
</div>

</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"

  import {setToken,getToken,showNotification,FetchAddressByPostcode,utf16to8} from "../../../lib/util.js"
  import Swal from 'sweetalert2'


  export default {
    name: 'Checkout',
    props:["order_slug","order_sn","order_created_at"],
    data () {
      return {
      }
    },
  computed: {
  },
  mounted() {
  },
  methods: {
    async PayBill(order_slug,payment){
        var vm = this;
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
          confirmButtonText: vm.$t("m.gotoPay"),
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
</style>