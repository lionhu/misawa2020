<template>
<div>

Hello Introductiion

<p v-if="$t('m.language')=='jpy'">
  こんにちは  
</p>

<p v-if="$t('m.language')=='rmb'">
  你好
</p>

</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'

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
      // myprofile(){
      //     return this.$store.state.users.profile;
      // },
    },

    mounted() {


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
      selectedFile(e){
        e.preventDefault();
        // console.log(e.target.name)
        let files = e.target.files;
        let file = files[0];

        const isJPGPNG = file.type === 'image/jpeg' || file.type ==='image/png';
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isJPGPNG) {
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: '上传头像图片只能是 JPG 格式!'
            })
        }
        if (!isLt2M) {
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: '上传头像图片大小不能超过 2MB!'
            })
        }

        if (isJPGPNG && isLt2M){
          switch(e.target.name){
            case "wechat":          
                this.profile.wechat = file;
                this.profile.wechatUrl = URL.createObjectURL(this.profile.wechat);
                break;
            case "line":          
                this.profile.line = file;
                this.profile.lineUrl = URL.createObjectURL(this.profile.line);
                break;
            case "avatar":          
                this.profile.avatar = file;
                this.profile.imageUrl = URL.createObjectURL(this.profile.avatar);
                break;
            case "id_image":          
                this.profile.id_image = file;
                this.profile.id_imageUrl = URL.createObjectURL(this.profile.id_image);
                // console.log(this.profile.id_image)
                // console.log(this.profile.id_imageUrl)
                break;
          }
        }    
      },
      submit_update_profile(){
        let formData = new FormData();
        if (this.profile.avatar){
          formData.append('avatar', this.profile.avatar)
        }
        if (this.profile.id_image){
          formData.append('id_image', this.profile.id_image)
        }

        console.log(this.ME.user.id)
        if(this.profile.avatar !="" || this.profile.id_image!=""){
            this.$store.dispatch("users/upload_mainImage",{id:this.ME.user.id,formData:formData});
            this.ME=this.$store.state.users.profile;
            Swal.fire({
              title: 'Success!',
              text: 'Upload main successfully',
              type: 'success',
              confirmButtonText: 'OK'
            })
        }else{
          Swal.fire({
              title: 'Error!',
              text: 'Nothing changed',
              type: 'error',
              confirmButtonText: 'OK'
            })
        }

      },
      submit_update_social(){
        let formData = new FormData();
        if (this.profile.line){
          formData.append('line', this.profile.line)
        }
        if (this.profile.wechat){
          formData.append('wechat', this.profile.wechat)
        }

        if(this.profile.line!="" || this.profile.wechat!=""){
            this.$store.dispatch("users/upload_mainImage",formData);
            this.ME=this.$store.state.users.profile;
            Swal.fire({
              title: 'Success!',
              text: 'Upload main successfully',
              type: 'success',
              confirmButtonText: 'OK'
            })
        }else{
          Swal.fire({
              title: 'Error!',
              text: 'Nothing changed',
              type: 'error',
              confirmButtonText: 'OK'
            })
        }

      },
    }
};

</script>

<style lang="scss">
    #app {
        font-family: "Avenir", Helvetica, Arial, sans-serif;

        h1 {
            color: #CC3333;
        }
    }
     .avatar-uploader .el-upload {
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
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
    border: 1px dashed #d9d9d9;
    border-color: #409EFF;
  }
</style>