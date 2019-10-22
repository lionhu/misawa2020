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
<!--                 <h2 class="title w-p100 mt-10 mb-0 p-20">Last Transactions</h2>
                <div class="col-12">
                  <div class="media-list media-list-hover w-p100 mt-0">
                    <h5 class="media media-single py-10 px-0 w-p100 justify-content-between">
                        <p>
                        <i class="fa fa-circle text-red pr-10 font-size-12"></i>Deal number 1548
                        <span class="subtitle pl-20 mt-10">by<span class="text-red">Johen Doe</span></span>             
                        </p>
                        <p class="text-right pull-right"><span class="badge badge-sm badge-danger mb-10">sell</span><br>0.12458921 BTC</p>
                    </h5>
                    <h5 class="media media-single py-10 px-0 w-p100 justify-content-between">
                        <p>
                        <i class="fa fa-circle text-success pr-10 font-size-12"></i>Deal number 1548
                        <span class="subtitle pl-20 mt-10">by<span class="text-success">Johen Doe</span></span>             
                        </p>
                        <p class="text-right pull-right"><span class="badge badge-sm badge-success mb-10">sell</span><br>0.12458921 BTC</p>
                    </h5>
                    <h5 class="media media-single py-10 px-0 w-p100 justify-content-between">
                        <p>
                        <i class="fa fa-circle text-success pr-10 font-size-12"></i>Deal number 1548
                        <span class="subtitle pl-20 mt-10">by<span class="text-success">Johen Doe</span></span>             
                        </p>
                        <p class="text-right pull-right"><span class="badge badge-sm badge-success mb-10">sell</span><br>0.12458921 BTC</p>
                    </h5>
                    <h5 class="media media-single py-10 px-0 w-p100 justify-content-between">
                        <p>
                        <i class="fa fa-circle text-red pr-10 font-size-12"></i>Deal number 1548
                        <span class="subtitle pl-20 mt-10">by<span class="text-red">Johen Doe</span></span>             
                        </p>
                        <p class="text-right pull-right"><span class="badge badge-sm badge-danger mb-10">sell</span><br>0.12458921 BTC</p>
                    </h5>
                    <h5 class="media media-single py-10 px-0 w-p100 justify-content-between">
                        <p>
                        <i class="fa fa-circle text-success pr-10 font-size-12"></i>Deal number 1548
                        <span class="subtitle pl-20 mt-10">by<span class="text-success">Johen Doe</span></span>             
                        </p>
                        <p class="text-right pull-right"><span class="badge badge-sm badge-success mb-10">sell</span><br>0.12458921 BTC</p>
                    </h5>
                  </div>
                </div> -->
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
          <!-- <div class="box box-solid bg-black"> -->
<!--               <div class="box-header with-border">
                <h3 class="box-title">{{$t("m.personal_info")}}</h3>
              </div> -->
              <!-- /.box-header -->
<!--               <div class="box-body">
                <div class="row">
                    <div class="col-12">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{$t("m.avatar")}}</label>
                        <div class="col-sm-4">
                          <input @change="selectedFile" type="file" name="avatar" title="Avatar Image">
                        </div>
                        <div class="col-sm-6">
                          <img v-if="profile.imageUrl" :src="profile.imageUrl" class="avatar">
                        </div>
                      </div> -->
<!--                       <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ID Image</label>
                        <div class="col-sm-10">
                          <input @change="selectedFile" type="file" name="id_image" title="ID Image">
                        </div>
                        <div class="col-sm-8 offset-sm-2">
                          <img v-if="profile.id_imageUrl" :src="profile.id_imageUrl" class="avatar" style="width:100%">
                        </div>
                      </div> -->
<!--                       <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10 text-right">
                        <button  @click="submit_update_profile" class="btn btn-yellow">{{$t("m.submit")}}</button>
                        </div>
                      </div>
                    </div> -->
<!--                 </div>
              </div>
          </div> -->
<!--           <div class="box box-solid bg-black">
              <div class="box-header with-border">
                <h3 class="box-title">Personal Social Contact</h3>
              </div>
              <div class="box-body">
                <div class="row">
                <div class="col-12">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Wechat</label>
                    <div class="col-sm-4">

                      <input @change="selectedFile" type="file" name="wechat" title="Wechat">
                    </div>
                    <div class="col-sm-6">
                      <img v-if="profile.wechatUrl" :src="profile.wechatUrl" class="avatar">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Line</label>
                    <div class="col-sm-4">
                      <input @change="selectedFile" type="file" name="line" title="Line">
                    </div>
                    <div class="col-sm-6">
                      <img v-if="profile.lineUrl" :src="profile.lineUrl" class="avatar">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10 text-right">
                    <button  @click="submit_update_social" class="btn btn-yellow">Submit</button>
                    </div>
                  </div>
                </div>
                </div>
              </div>
          </div> -->
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



      const introcode="http://"+location.host+"/member/#/signup?introcode="+this.ME.slug

      this.introcode_url="http://"+location.host+"/member/#/signup?introcode="+this.ME.slug

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
      // selectedFile(e){
      //   e.preventDefault();
      //   // console.log(e.target.name)
      //   let files = e.target.files;
      //   let file = files[0];

      //   const isJPGPNG = file.type === 'image/jpeg' || file.type ==='image/png';
      //   const isLt2M = file.size / 1024 / 1024 < 2;

      //   if (!isJPGPNG) {
      //       Swal.fire({
      //         type: 'error',
      //         title: 'Oops...',
      //         text: '上传头像图片只能是 JPG 格式!'
      //       })
      //   }
      //   if (!isLt2M) {
      //       Swal.fire({
      //         type: 'error',
      //         title: 'Oops...',
      //         text: '上传头像图片大小不能超过 2MB!'
      //       })
      //   }

      //   if (isJPGPNG && isLt2M){
      //     switch(e.target.name){
      //       case "wechat":          
      //           this.profile.wechat = file;
      //           this.profile.wechatUrl = URL.createObjectURL(this.profile.wechat);
      //           break;
      //       case "line":          
      //           this.profile.line = file;
      //           this.profile.lineUrl = URL.createObjectURL(this.profile.line);
      //           break;
      //       case "avatar":          
      //           this.profile.avatar = file;
      //           this.profile.imageUrl = URL.createObjectURL(this.profile.avatar);
      //           break;
      //       case "id_image":          
      //           this.profile.id_image = file;
      //           this.profile.id_imageUrl = URL.createObjectURL(this.profile.id_image);
      //           // console.log(this.profile.id_image)
      //           // console.log(this.profile.id_imageUrl)
      //           break;
      //     }
      //   }    
      // },
      // submit_update_profile(){
      //   let formData = new FormData();
      //   if (this.profile.avatar){
      //     formData.append('avatar', this.profile.avatar)
      //   }
      //   if (this.profile.id_image){
      //     formData.append('id_image', this.profile.id_image)
      //   }

      //   // console.log(this.ME.user.id)
      //   if(this.profile.avatar !="" || this.profile.id_image!=""){
      //       this.$store.dispatch("users/upload_mainImage",{id:this.ME.user.id,formData:formData});
      //       this.ME=this.$store.state.users.profile;
      //       Swal.fire({
      //         title: 'Success!',
      //         text: 'Upload main successfully',
      //         type: 'success',
      //         confirmButtonText: 'OK'
      //       })
      //   }else{
      //     Swal.fire({
      //         title: 'Error!',
      //         text: 'Nothing changed',
      //         type: 'error',
      //         confirmButtonText: 'OK'
      //       })
      //   }

      // },
      // submit_update_social(){
      //   let formData = new FormData();
      //   if (this.profile.line){
      //     formData.append('line', this.profile.line)
      //   }
      //   if (this.profile.wechat){
      //     formData.append('wechat', this.profile.wechat)
      //   }

      //   if(this.profile.line!="" || this.profile.wechat!=""){
      //       this.$store.dispatch("users/upload_mainImage",formData);
      //       this.ME=this.$store.state.users.profile;
      //       Swal.fire({
      //         title: 'Success!',
      //         text: 'Upload main successfully',
      //         type: 'success',
      //         confirmButtonText: 'OK'
      //       })
      //   }else{
      //     Swal.fire({
      //         title: 'Error!',
      //         text: 'Nothing changed',
      //         type: 'error',
      //         confirmButtonText: 'OK'
      //       })
      //   }

      // },
    }
};

</script>

<style>
/*    #app {
        font-family: "Avenir", Helvetica, Arial, sans-serif;

        h1 {
            color: #CC3333;
        }
    }*/
    .swal2-image{
      height:280px;
    }
/*     .avatar-uploader .el-upload {
    }
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }*/
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
    border: 1px dashed #d9d9d9;
    border-color: #409EFF;
  }
</style>