<template>
  <div class="register-box">

     <div class="register-box-body">
        <div class="register-logo">
            <img src="/static/img/logo.svg" alt="logo" class="dark-logo lionhu_img">
            <img src="/static/img/nichiei_text.svg" alt="logo" class="dark-logo lionhu_img">
            <img :src="newuser.avatar" v-if="isFacebookAuth">
        </div>
        <div class="form-element">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" v-model="newuser.username" required placeholder="Full name">
            <span class="ion ion-person form-control-feedback "></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" v-model="newuser.email" required placeholder="Email">
            <span class="ion ion-email form-control-feedback "></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" v-model="newuser.password" required placeholder="Password">
            <span class="ion ion-locked form-control-feedback "></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" @keyup.enter="SignupMe" v-model="newuser.password2" required placeholder="Retype password">
            <span class="ion ion-log-in form-control-feedback "></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" v-model="newuser.introcode" required placeholder="introcode" style="display:none">
          </div>
          <div class="row">
            <div class="col-12">
              <div class="checkbox">
                <input type="checkbox" v-model="newuser.agreed" id="basic_checkbox_1">
          <label for="basic_checkbox_1">I agree to the <a href="#"><b>Terms</b></a></label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-12 text-center">
              <button @click="SignupMe" class="btn btn-info btn-block margin-top-10">SIGN UP</button>
            </div>
            <!-- /.col -->
          </div>
        </div>
      
        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <v-facebook-login
              style="margin:0 auto!important;"
              app-id="1076451029210276"
              version="v5.0"
              :login-options="scope"
              @sdk-init="setSdk"
              @connect="connected"
              @logout="onLogout">      
              <span slot="login">Facebookで登録</span>
              <span slot="logout">Facebookからログアウト</span>
          </v-facebook-login>
          <!-- <a href="#" class="btn btn-social-icon btn-circle btn-google"><i class="fa fa-google-plus"></i></a> -->
        </div>
      <!-- /.social-auth-links -->
    
      <div class="margin-top-20 text-center">
        <p>Already have an account? 
          <router-link to="/login" class="text-info m-l-5">Sign In</router-link></p>
      </div>
    
    </div>
  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
import { VFBLogin as VFacebookLogin } from 'vue-facebook-login-component'


  export default {
    name: 'login',
    data () {
      return {
        sdkFB: undefined,
        scope: { scope: "public_profile, email" },
        isFacebookAuth: false,
        facebookInfo: undefined,
        newuser:{
          username:"",
          email:"",
          password:"",
          password2:"",
          introcode:"",
          agreed:true,
          avatar:""
        }

      }
    },
    components: {
      VFacebookLogin
    },
    computed:{
    },
    created() {
      var introcode=this.$route.query.introcode;
      this.newuser.introcode= introcode==undefined?"introcode":introcode
    },
    methods: {
      SignupMe(){

        const singupURL='/api/userprofiles/singup/'
        if(this.newuser.agreed){
          if(this.newuser.password ==this.newuser.password2 && this.newuser.password.length >0 ){
            if(this.newuser.username.length>0 &&  this.newuser.email.length>0){

                  console.log(this.newuser)
                  axios.post(singupURL,this.newuser)
                  .then((resolved)=>{
                      console.log(resolved.data)
                      if(resolved.data.result){
                        Swal.fire({
                          type: 'success',
                          title: 'Registered successfully!',
                          text: "Please login with your information"
                        })
                        this.$router.push({ name: 'login'})
                      }else{
                        Swal.fire({
                          type: 'error',
                          title: 'Signup failed!',
                          text: resolved.data.message
                        })
                      }
                    })
                  .catch(rejected=>{
                      Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: "contact with admin about your trouble"
                      })

                  })
            }else{

              Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: "you have to input userName and email"
                })
            }

          }else{

          Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: 'passwords are not the same!'
                })
          }

        }else{
          Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: 'You have to read agreement!'
                })
        }
      },
      // sdkの読み込み完了
    setSdk(sdk) {
      this.sdkFB = sdk.FB;
    },
    // 認証が完了したらconnectedが呼ばれる
    connected() {
      this.isFacebookAuth = true;
      // id、名前、写真、メールアドレスを取得
      this.sdkFB.api(
        "/me?fields=id,name,picture,email",
        function(response) {
          // 取得したデータを設定
          this.newuser = {
            id: response.id,
            username: response.name,
            email: response.email,
            avatar: response.picture.data.url
          };
        }.bind(this)
      );
    },
    // ログアウト時は認証フラグをfalse
    onLogout(response) {
      this.isFacebookAuth = false;
    }
    }
  };

</script>

<style lang="scss">
.lionhu_img{
  display:block;
  margin: 0 auto;
  width: 20%;
}
.v-facebook-login{
  margin:0 auto;
}
</style>



