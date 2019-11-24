<template>
<div>

<!--           <article class="portfolio-item pf-media pf-icons wide"  v-if="product.article.mediatype=='standard'">
            <div class="portfolio-image">
              <router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">
                <img :src="product.thumbimage" alt="Open Imagination">
              </router-link>
              <div class="portfolio-overlay">
                <div class="sale-flash soldout" v-if="product.stock==0">Sold Out!</div>
                <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
                <div class="portfolio-desc">
                  <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
                  <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
                </div>
                <a :href="product.avatar" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon" ><i class="icon-shopping-cart"></i></a>
              </div>
            </div>
          </article>



          <article class="portfolio-item pf-icons pf-illustrations wide"  v-if="product.article.mediatype=='gallery'">
            <div class="portfolio-image">
              <div class="fslider" data-arrows="false" data-speed="400" data-pause="4000">
                <div class="flexslider">
                  <div class="slider-wrap">
                    <div class="slide" v-for="_image in product.article.galleryimages">
                      <router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">
                        <img :src="_image.thumbimage" :alt="product.name">
                      </router-link>
                    </div>
                  </div>
                </div>
              </div>
              <div class="portfolio-overlay" data-lightbox="gallery">
                <div class="sale-flash soldout" v-if="product.stock==0">Sold Out!</div>
                <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>

                <a :href="_image.postimage" v-bind:class="{'left-icon':_image.memo=='show','hidden':_image.memo=='hidden'}"  data-lightbox="gallery-item" v-for="_image in product.article.galleryimages"><i class="icon-line-stack-2"></i></a>
                <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon"  ><i class="icon-shopping-cart"></i></a>
              </div>
            </div>
            <div class="portfolio-desc">
              <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
              <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
            </div>
          </article>





          <article class="portfolio-item pf-graphics pf-media pf-uielements"  v-if="product.article.mediatype=='video'">
            <div class="portfolio-image">
              <router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">
                <img :src="product.thumbimage" :alt="product.name">
              </router-link>
              <div class="portfolio-overlay">
                <div class="sale-flash soldout" v-if="product.stock==0">Sold Out!</div>
                <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
                <div class="portfolio-desc">
                  <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
                  <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
                </div>
                <a :href="product.article.video_url" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
                <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon" ><i class="icon-shopping-cart"></i></a>
              </div>
            </div>
          </article> -->

  <article class="portfolio-item pf-media pf-icons" data-loader="include/ajax/portfolio-ajax-image.php" v-if="product.article.mediatype=='standard'">
    <div class="ribbon ribbon-bookmark bg-secondary" v-if="product.hasGroupon">
      <a href="javascript:void(0);" @click="GrouponME(product.grouponSlug,product.thumbimage)"><i class="fas fa-bullhorn"></i></a>
    </div>
    <div class="portfolio-image">
        <img :src="product.thumbimage" :alt="product.name">
        <div class="portfolio-overlay">
          <a :href="product.avatar" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
          <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon"><i class="icon-shopping-cart"></i></a>
        </div>
    </div>
    <div class="portfolio-desc">
        <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
        <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
    </div>  
    <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
  </article>



  <article class="portfolio-item pf-icons pf-illustrations"  data-loader="include/ajax/portfolio-ajax-gallery.php" v-if="product.article.mediatype=='gallery'">
    <div class="ribbon ribbon-bookmark bg-secondary" v-if="product.hasGroupon">
      <a href="javascript:void(0);" @click="GrouponME(product.grouponSlug,product.thumbimage)"><i class="fas fa-bullhorn"></i></a>
    </div>
    <div class="portfolio-image">
      <div class="fslider" data-arrows="false" data-speed="400" data-pause="4000">
        <div class="flexslider">
          <div class="slider-wrap">
            <div class="slide" v-for="_image in product.article.galleryimages">
              <a href="portfolio-single-gallery.html">
                <img :src="_image.thumbimage" :alt="product.name">
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="portfolio-overlay" data-lightbox="gallery">
        <a :href="_image.postimage" class="left-icon" :class="_image.memo" data-lightbox="gallery-item" v-for="_image in product.article.galleryimages"><i class="icon-line-stack-2"></i></a>
        <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon"><i class="icon-shopping-cart"></i></a>
      </div>
    </div>
    <div class="portfolio-desc">
        <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
        <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
    </div>    
    <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
  </article>


  <article class="portfolio-item pf-graphics pf-uielements"  data-loader="include/ajax/portfolio-ajax-video.php"  v-if="product.article.mediatype=='video'">
    <div class="ribbon ribbon-bookmark bg-secondary" v-if="product.hasGroupon">
      <a href="javascript:void(0);" @click="GrouponME(product.grouponSlug,product.thumbimage)"><i class="fas fa-bullhorn"></i></a>
    </div>
    <div class="portfolio-image">
      <a href="#">
        <img :src="product.thumbimage" :alt="product.name">
      </a>
      <div class="portfolio-overlay">
        <a :href="product.article.video_url" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
        <a href="javascript:void(0);"  @click="addProductToCart(product.slug)" class="right-icon"><i class="icon-shopping-cart"></i></a>
      </div>
    </div>
    <div class="portfolio-desc">
        <h3><router-link :to="{name:'singleproduct',params:{product_slug:product.slug}}"  class="t400">{{product.name}}</router-link></h3>
        <span class="product_price"><del>{{product.open_price|currency_jpy}}</del><ins>{{product.price|currency_jpy}}</ins></span>
    </div>    
    <el-rate v-model="value" disabled text-color="#ff9900" score-template="{product.ranks}"></el-rate>
  </article>


</div>


</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import { Rate,Dialog,Button } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';
  import {setToken,getToken,showNotification} from "../../../lib/util.js"


  export default {
    name: 'product',
    props:["product"],
    components:{
      Dialog,Rate,Button
    },
    data () {
      return {
        value:0,
        centerDialogVisible:false
      }
    },    
    components:{
      elRate:Rate
    },
    mounted() {
      this.value=this.product.ranks
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
            axios.post('/api/applicant/getPayQR/',{
              "applicant_slug": applicant_slug,
              "brandType":brandType
            }).then(response => {
              console.log(response.data.result)
              console.log(response.data.QRurl)
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
                          confirmButtonText: '申請詳細確認',
                          showCancelButton: true,
                          footer: '<a href="javascript:void(0);">See my coupon list?</a>'
                        }).then((result)=>{
                          if(result.value){
                            console.log("jump to details")
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
.soldout{
  background-color:red;
  color:white-space
}
.message{
  text-align:left;
  color:black!important;
}
.title{
  display:inline-block;
  width:150px;
  font-size:16px;
  font-weight:700;
  text-align:right;
}
.message_content{
  display:inline-block;
  margin-left: 10px;
}
</style>