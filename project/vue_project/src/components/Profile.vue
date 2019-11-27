<template>
<div>
      <div class="row">
        <div class="col-xl-4 col-lg-5 text-center">
          <div class="box bg-yellow bg-deathstar-dark">
            <div class="box-body box-profile">
              <a href="javascript:void(0);" @click="selectProfileAvatar">
                   <div class="image" :style="'background-image:url('+ME.avatar+');background-size:cover;border:2px silver solid;border-radius:100%;height:160px;width:160px;margin:auto;'">
                  </div>
              </a>


              <h2 class="profile-username text-center mb-0">{{ME.user.username}}</h2>
              <div class="row social-states">
                <div class="col-6 text-right"><a href="#" class="link text-white"><i class="ion ion-ios-people-outline"></i> 254</a></div>
                <div class="col-6 text-left"><a href="#" class="link text-white"><i class="ion ion-images"></i> 54</a></div>
              </div>
              <h4 class="text-center mt-0"><i class="fa fa-envelope-o mr-10"></i>{{ME.user.email}}</h4>
              <div class="row">
                <div class="col-12">
                  <div class="media-list media-list-hover media-list-divided w-p100 mt-30">
                    <h4 class="media media-single p-15">
                      <i class="fa fa-arrow-circle-o-right mr-10"></i><span class="title">My Profile</span>
                    </h4>
                    <h4 class="media media-single p-15">
                      <i class="fa fa-arrow-circle-o-right mr-10"></i><span class="title">Invests</span>
                    </h4>
                    <h4 class="media media-single p-15">
                      <i class="fa fa-arrow-circle-o-right mr-10"></i><span class="title">The Wallet</span>
                    </h4>
                    <h4 class="media media-single p-15">
                      <i class="fa fa-arrow-circle-o-right mr-10"></i><span class="title">Deposit</span>
                    </h4>
                    <h4 class="media media-single p-15">
                      <i class="fa fa-arrow-circle-o-right mr-10"></i><span class="title">Reports</span>
                    </h4>
                    <h4 class="media media-single p-15">
                      <i class="fa fa-arrow-circle-o-right mr-10"></i><span class="title">Services</span>
                    </h4>
                    <h4 class="media media-single p-15">
                      <i class="fa fa-arrow-circle-o-right mr-10"></i><span class="title">Support</span>
                    </h4>
                  </div>
                </div>
              </div>

              </div>
            </div>
          </div>

        <div class="col-xl-8 col-lg-7">
          <div class="box box-solid bg-black">
              <div class="box-header with-border">
                <h3 class="box-title">Trust Relationship</h3>
                <div class="row">
                    <div class="col-12">
                      <a class="box box-body box-inverse box-primary pull-up bg-hexagons-white" href="#">
                        <div class="flexbox align-items-center">
                          <div>
                            <h6 class="mb-0">{{profile.father.username}}</h6>
                            <small>1度信用</small>
                          </div>
                          <img class="avatar avatar-lg avatar-bordered" :src="profile.father.profile.avatar" alt="..." style="width:80px;height:80px;">
                        </div>
                      </a>
                    </div>
                </div>
              </div>
          </div>
          <div class="box box-body text-center pull-up py-50">
              <div id="qrcode"></div>
            <h5 class="mt-3 mb-1"><a class="hover-primary" href="#">{{$t("m.introcode")}}</a></h5>
            <span id="introcode_url" >{{introcode_url}}</span>
          </div>
        </div>
      </div>
</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import {setToken,getToken} from "../lib/util.js"

  export default {
    name: 'app',
    components:{
    },
    data () {
      return {
        ME:{
          avatar:"",
          user:{
            username:"",
            email:""
          }
        },
        profile:{
          avatar:"",
          imageUrl:"",
          wechat:"",
          wechatUrl:"",
          line:"",
          lineUrl:"",
          id_image:"",
          id_imageUrl:"",

          postcode:"",
          address1:"",
          address2:"",
          telephone:"08043608496",

          father:{
            profile:{
              avatar:""
            }
          },
          grandfather:{
            profile:{
              avatar:""
            }
          },
          partner:{
            profile:{
              avatar:""
            }
          }
        },
        introcode_url:""
      }
    },
    computed:{
      token(){
              return this.$store.state.system.token;
      },
    },

    mounted() {

      // this.$store.dispatch("users/get_myprofile");
      this.ME=this.$store.state.users.profile;
      this.profile.imageUrl = this.ME.avatar
      this.profile.wechatUrl = this.ME.wechat
      this.profile.lineUrl = this.ME.line
      this.profile.id_imageUrl = this.ME.id_image

      this.profile.partner=this.ME.partner
      this.profile.father=this.ME.father
      this.profile.grandfather=this.ME.grandfather

      if(this.ME.language==""){
          setToken("zh_CN","lang");
          this.$i18n.locale = "zh_CN";//关键语句
      }else{
          setToken(this.ME.language,"lang");
          this.$i18n.locale = this.ME.language;//关键语句
      }



      const introcode="https://"+location.host+"/member/#/signup?introcode="+this.ME.slug

      this.introcode_url="https://"+location.host+"/member/#/signup?introcode="+this.ME.slug

      $("#qrcode").qrcode({
                render:"canvas",
                width: 200,//宽度
                height: 200,//高度
                correctLevel:2,
                text: this.utf16to8(introcode),
            });


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
        async selectProfileAvatar(){
          const { value: file } = await Swal.fire({
            title: this.$t("m.select_avatar"),
            input: 'file',
            inputAttributes: {
              accept: 'image/*',
              'aria-label': 'Upload your profile picture'
            }
          })

          if (file && this.checkfile(file)){
              let formData = new FormData();
              formData.append('avatar', file)

              this.$store.dispatch("users/upload_mainImage",{id:this.ME.user.id,formData:formData}).then(resolve=>{
                    this.ME=this.$store.state.users.profile;
                    const reader = new FileReader()
                    reader.onload = (file) => {
                      Swal.fire({
                        title: this.$t("m.uploaded_avatar"),
                        imageUrl: file.target.result,
                        imageAlt: 'The uploaded picture'
                      })
                    }
                    reader.readAsDataURL(file)
              },reject=>{})
          }
        },
        checkfile(file){
          const isJPGPNG = file.type === 'image/jpeg' || file.type ==='image/png';
          const isLt2M = file.size / 1024 / 1024 < 2;

          if (!isJPGPNG) {
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: '上传头像图片只能是 JPG 格式!'
              })
              return false
          }
          if (!isLt2M) {
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: '上传头像图片大小不能超过 2MB!'
              })
              return false
          }
          return true
        },
    }
};

</script>

<style>

    .swal2-image{
      height:280px;
    }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
    border: 1px dashed #d9d9d9;
    border-color: #409EFF;
  }
</style>