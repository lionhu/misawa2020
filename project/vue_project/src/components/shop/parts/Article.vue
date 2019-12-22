<template>
<div class="col-lg-4 mb-4">
<!--     <div class="ribbon ribbon-bookmark bg-secondary" style="padding: 0 5px!important;" v-if="product.hasGroupon">
        <a href="javascript:void(0);" @click="GrouponME(product.grouponSlug,product.thumbimage)"><i class="fab fa-gratipay"></i></a>
    </div> -->
    <div class="flip-card text-center">
        <div class="flip-card-front bg-danger no-after" :style="'background-image: url('+product.thumbimage+')'">

        </div>
        <div class="flip-card-back bg-danger no-after" :style="'background-image: url('+product.thumbimage+')'">
            <div class="flip-card-inner back-inner" style="top:70%!important;">
                <p class="mb-2 text-white">{{product.name}}
                    <br>
                    <span class="product_price">
                      <ins>{{product.price|currency_jpy}}</ins>
                    </span>
                </p>
                <div class="text-center">
                    <router-link :to="{name:'product_article',params:{slug:product.slug}}" v-if="product.medias.length>0"><i class="icon-line-stack-2"></i></router-link>
                    <a href="javascript:void(0);" @click="addProductToCart(product.slug)" class="leftmargin-sm"><i class="icon-shopping-cart"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="product-desc">
        <div class="product-title">
          <h3><a href="javascript:void(0);" @click="addFavorite(product.slug)"><i class="fab fa-gratipay text-danger"></i></a>
          {{product.name}}</h3>
        </div>
        <div class="product-price">
          <del>{{product.open_price|currency_jpy}}</del>
          <ins>{{product.price|currency_jpy}}</ins>
<!--           <div class="groupon" v-if="product.hasGroupon">
            <span class="fright leftmargin-10">{{product.groupon_applicants_count}} / {{product.groupon_target}}</span>
            <span class="fright text-info"><i class="fas fa-thumbs-up fa-2x"></i></span>
          </div> -->
        </div>
        <Thumbup :product="product"></Thumbup>
        <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
    </div>
</div>



</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import { Rate,Image } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';
  import {setToken,getToken,showNotification} from "../../../lib/util.js"
  import Thumbup from "./ProductThumbup.vue"

  export default {
    name: 'product_article',
    props:["product"],
    data () {
      return {
        value:0,
        centerDialogVisible:false,
      options: {},
      series: [44, 55, 41, 17, 15]
      }
    },    
    components:{
      elRate:Rate,
      Thumbup
    },
    mounted() {
      this.value=this.product.ranks;

    },
    methods: {
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
      addProductToCart(slug){
        const jwt_token=getToken("jwt_token")

        if (jwt_token !==undefined && jwt_token !==null){
          const params={
            product_slug:slug,
            quantity:1
          }
          let jwt_token=getToken("jwt_token")
          this.$store.dispatch("lotteryshop/addToCart",params).then(
            resolve=>{
                  showNotification(this.$t("m.add2cart"),"success")
            },reject=>{})
        }else{
          showNotification("You have to login!","warning")
        }
      },
      async ApplyGroupon(groupon,productImage){
        const ipAPI = '/api/applicant/'

        const messageHTML=`
        <div class="">${groupon.description}</div>
        <div class="">数量を選択して下さい</div>
        <div class="message">
          <span class="title">Groupon: </span><span class="message_content">${groupon.name}</span><br>
          <span class="title">目標: </span><span class="message_content">${groupon.target}</span><br>
          <span class="title">単価: </span><span class="message_content">${groupon.price}</span><br>
          <span class="title">返金単価: </span><span class="message_content">${groupon.feedbackprice}</span>
        </div>`

        const { value: buynum } = await Swal.fire({
          html: messageHTML,
          imageUrl: productImage,
          imageWidth: "40%",
          input: 'select',
          inputOptions: {
            1: '1',2: '2',3: '3',4: '4',5: '5'
          },
          inputPlaceholder: 'Select num',
          showCancelButton: true
        })

        if (buynum) {
              Swal.fire({
                type:"question",
                html: "Apply now?",
                confirmButtonText: 'Apply',
                showCancelButton: true,
                showLoaderOnConfirm: true,
              }).then((result)=>{
                if(result.value){
                    axios.post(ipAPI,{
                        "groupon_slug": groupon.slug,
                        "num":buynum
                      }).then(response => {
                        console.log(response)
                        if (response.data.result){
                              const applicant = response.data.applicant
                              const deposite=parseInt(applicant.price)*parseInt(applicant.num)

                              const htmlStr=`<div class="">申し込み完了しました。<br>${applicant.slug}<br>Deposit needed: ${deposite}</div>`

                              Swal.fire({
                                // type:"success",
                                html: htmlStr,
                                confirmButtonText: '予約金支払い',
                                showCancelButton: true,
                                showLoaderOnConfirm: true,
                              }).then((result)=>{
                                if(result.value){
                                  this.showQR(applicant.slug)
                                }
                              })
                        }
                      })
                }
              })
        }
      },
      async showQR(applicant_slug){
          const inputOptions = new Promise((resolve) => {
            resolve({
              'AliPay': '<i class="i-circled i-light alipay_color fab fa-alipay"></i>Aplipay',
              'WechatPay': '<i class="i-circled i-light wechat_color fab fa-weixin"></i>WechatPay'
            })
        })

        const { value: brandType } = await Swal.fire({
          title: 'Select Payment',
          input: 'radio',
          inputOptions: inputOptions,
          inputValidator: (value) => {
            if (!value) {
              return 'You need to choose something!'
            }
          }
        })

        const icon_pay= brandType=="WechatPay"? "wechat_color fab fa-weixin":"alipay_color fab fa-alipay"
        if (brandType) {

          Swal.fire({
            // title: 'Auto close alert!',
            html: 'Applying QR code for payment',
            // timer: 2000,
            // timerProgressBar: true,
            allowOutsideClick: function() {
                return !Swal.isLoading();
              },
            onBeforeOpen: () => {
              Swal.showLoading()
              axios.post('/api/applicant/getPayQR/',{
                "applicant_slug": applicant_slug,
                "brandType":brandType
              }).then(response => {
                if (response.data.result) {
                    Swal.fire({
                      title: '<i class="i-circled '+icon_pay+'"></i>',
                      html: '<div id="paymentQRCode"></div>',
                      allowOutsideClick: () => false
                    })
                    $("#paymentQRCode").qrcode({
                        render:"canvas",
                        width: 320,//宽度
                        height: 320,//高度
                        correctLevel:3,
                        text: this.utf16to8(response.data.QRurl),
                    });
                  }
                  return "hello"
              })
            }
          }).then((result) => {
            console.log(result)

          })

        }
      },
      async GrouponME(grouponSlug,productImage){
          const ipAPI = '/api/groupon/getUserGrouponApplicant/'

          axios.post(ipAPI,{
                "groupon_slug": grouponSlug
              }).then(response => {
                  if (response.data.AppliedGroupon){
                        const groupon= response.data.groupon
                        const applicant = response.data.applicant

                        const htmlStr=`<div class="">すでに申請されています。<br>申請内容は下記の通り：</div><div class="message"><span class="title">Groupon: </span><span class="message_content">${groupon.name}</span><br><span class="title">Number: </span><span class="message_content">${applicant.num}</span></div>`

                        Swal.fire({
                          type:"success",
                          html: htmlStr,
                          position : 'bottom',
                          confirmButtonText: 'Pay Deposite Now!',
                          showConfirmButton: ! applicant.deposite_paid,
                          showCancelButton: true,
                          reverseButtons : true,
                          footer: '<a href="javascript:void(0);">See my coupon list?</a>'
                        }).then((result)=>{
                          if(result.value){
                            this.showQR(applicant.slug)
                          }
                        })
                  }else{
                    this.ApplyGroupon(response.data.groupon,productImage)
                  }
                })
                .catch(() => {
                  Swal.insertQueueStep({
                    icon: 'error',
                    title: 'Unable to get Groupon Information'
                  })
                })
      },
      addFavorite(slug){
        this.$store.dispatch("lotteryshop/AddMyFavoriate",slug).then(
          res=>{
            if(res !==null && res.result == true){
              showNotification('<i class="fab fa-gratipay text-danger fa-2x"></i>',"success")
              console.log(res.result);
            }
          },reject=>{})
      }
    }
};
</script>


<style lang="scss">
.back-inner{
  opacity: 0.8;
  background-color: #000;
}
</style>