<template>
<div class="col-lg-4 mb-4">
    <div class="ribbon ribbon-bookmark bg-secondary" style="padding: 0 5px!important;" v-if="product.hasGroupon">
        <a href="javascript:void(0);" @click="GrouponME(product.grouponSlug,product.thumbimage)"><i class="icon-thumbs-up"></i></a>
    </div>
    <div class="flip-card text-center">
        <div class="flip-card-front dark" :style="'background-image: url('+product.article.postimage+')'">

        </div>
        <div class="flip-card-back bg-danger no-after" :style="'background-image: url('+product.article.postimage+')'">
            <div class="flip-card-inner back-inner">
                <p class="mb-2 text-white">{{product.name}}
                    <br>
                    <span class="product_price">
            <ins>{{product.price|currency_jpy}}</ins>
          </span>
                </p>
                <div class="text-center">
                    <a :href="product.avatar" data-lightbox="image"><i class=" icon-line-plus"></i></a>
                    <a href="javascript:void(0);" @click="addProductToCart(product.slug)" class="leftmargin-sm"><i class="icon-shopping-cart"></i></a>
                </div>

            </div>
        </div>
    </div>
    <div class="product-desc">
        <div class="product-title">
          <h3><a href="https://www.instagram.com/p/B5sYR1UAhNB/">{{product.name}}</a></h3>
        </div>

        <div class="product-price">
          <del>{{product.open_price|currency_jpy}}</del>
          <ins>{{product.price|currency_jpy}}</ins>
          <ol class="breadcrumb_groupon">
			<li class="breadcrumb-item"><a href="#">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Blog</li>
		</ol>
          <span class="fright text-info"><i class="fas fa-thumbs-up fa-2x"></i></span>
        </div>
        
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
  // import "../../../lib/jquery.sparkline.min.js"

  export default {
    name: 'product_article',
    props:["product"],
    data () {
      return {
        value:0,
        centerDialogVisible:false,
        url: 'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
        srcList: [
          'https://fuss10.elemecdn.com/8/27/f01c15bb73e1ef3793e64e6b7bbccjpeg.jpeg',
          'https://fuss10.elemecdn.com/1/8e/aeffeb4de74e2fde4bd74fc7b4486jpeg.jpeg'
        ]
      }
    },    
    components:{
      elRate:Rate,
      // elImage:Image
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


          // Swal.queue([{
          //   html: 'Modal with a custom image.',
          //   imageUrl: productImage,
          //   imageWidth: "40%",
          //   imageAlt: 'Custom image',
          //   confirmButtonText: 'Confirming your applicant',
          //   showLoaderOnConfirm: true,
          //   preConfirm: () => {
          //     return axios.post(ipAPI,{
          //       "groupon_slug": "5b8a56a5-e59b-4e3c-8ceb-1ea148d70d20_1123"
          //     }).then(response => {
          //         console.log(response)
          //         return response.data
          //       })
          //       .then(data => {
          //           console.log(data)
          //           var mssage= "lionhu "+data.ip
          //           Swal.insertQueueStep(mssage)
          //       })
          //       .catch(() => {
          //         Swal.insertQueueStep({
          //           icon: 'error',
          //           title: 'Unable to get your public IP'
          //         })
          //       })
          //   }
          // }])
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