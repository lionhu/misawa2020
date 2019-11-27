<template>

<div class="login-box">
      <div class="login-logo">
            <img src="/static/img/logo.svg" alt="logo" class="dark-logo lionhu_img">
            <img src="/static/img/nichiei_text.svg" alt="logo" class="dark-logo lionhu_img">
      </div>
  <!-- /.login-logo -->
  <div class="login-box-body pb-20">
    <p class="login-box-msg text-uppercase">Recover password</p>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" v-model="newpassword.email" placeholder="Email">
        <input type="token" v-model="newpassword.token" class="form-control" style="display:none;">
        <span class="ion ion-email form-control-feedback"></span>
      </div>      
      <div class="form-group has-feedback">
        <input type="password" v-model="newpassword.password" class="form-control" placeholder="Password">
        <span class="ion ion-email form-control-feedback"></span>
      </div>      
      <div class="form-group has-feedback">
        <input type="password"  v-model="newpassword.password2" @keyup.enter="submit_resetpassword" class="form-control" placeholder="Confirm Password">
        <span class="ion ion-email form-control-feedback"></span>
      </div>      
      <div class="row">
        <!-- /.col -->
        <div class="col-12 text-center">
          <button @click="submit_resetpassword" class="btn btn-info btn-block text-uppercase">Reset</button>
        </div>

        <!-- /.col -->
      </div>
        <div class="margin-top-30 flex">
          <span class="pull-right"><router-link to="/signup" class="text-info m-l-5">Sign Up?</router-link></span>
          <span class="pull-left"><router-link to="/login" class="text-info m-l-5">Login?</router-link></span>
        </div>
  </div>
</div>
  <!-- /.login-box-body -->
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'


  export default {
    name: 'login',
    data () {
      return {
        newpassword:{
          email:"",
          token:"",
          password:"",
          password2:""
        }

      }
    },
    computed:{
      // myprofile(){
      //     return this.$store.state.users.profile;
      // },
    },
    created() {
      var token=this.$route.query.token
      this.newpassword.token=token!=""?token:""

      console.log("token is :"+token)
        console.log(window.location.host)
      if(token==""||token==undefined){
              this.$router.push({
                name: "login"
              });
      }
    },
    methods: {
      submit_resetpassword(){
        const loginURL="/member/#/login/"
        console.log(loginURL)
        if(this.newpassword.password !="" && this.newpassword.password==this.newpassword.password2 && this.newpassword.email!=="" && this.newpassword.token!=""){

            axios.post('/api/userprofiles/resetpassword_verify/',{
              "token":this.newpassword.token,
              "email":this.newpassword.email,
              "password":this.newpassword.password
            })
            .then((resolved)=>{
                  console.log(resolved)
                  if(resolved.data.result){
                    Swal.fire({
                      type: 'success',
                      title: 'Good work!',
                      text: 'Password updated successfully, please login.',
                    })
                    window.location.href=loginURL
                  }else{
                    Swal.fire({
                      type: 'error',
                      title: 'Something wrong!',
                      text: resolved.data.message
                    })
                  }

              })
            .catch(rejected=>{})
        }else{
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: '检查一下你输入的信息是否有错!',
          })
        }
      },
      loginMe(){
        this.$store.dispatch("users/login",{
            userName: this.username,
            password: this.password
          })
            .then(() => {
              console.log("login success!!");
              let jwt_token = localStorage.getItem("jwt_token");
              
              window.axios.defaults.headers.Authorization=`jwt ` + jwt_token
              
              this.$router.push({
                name: "home"
              });
              // window.location.href="/exrate/"
            })
            .catch(error => {
                Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: '请再次确认您的用户名和密码!'
                })

              console.log(error);
            });
      },

    }
  };

</script>

<style lang="scss">
.lionhu_img{
  display:block;
  margin: 0 auto;
  width: 40%;
}
</style>