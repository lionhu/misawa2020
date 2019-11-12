<template>
    <div class="login-box">
      <div class="login-logo">
            <img src="/static/img/logo.svg" alt="logo" class="dark-logo lionhu_img">
            <img src="/static/img/nichiei_text.svg" alt="logo" class="dark-logo lionhu_img">
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <div  class="form-element">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" v-model="username" placeholder="Username">
            <span class="ion ion-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" @keyup.enter="loginMe" v-model="password" placeholder="Password">
            <span class="ion ion-locked form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="checkbox">
                <input type="checkbox" id="basic_checkbox_1">
          <label for="basic_checkbox_1">Remember Me</label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-6">
             <div class="fog-pwd">
                <a href="javascript:void(0)" @click="sendPasswordResetEmail"><i class="ion ion-locked"></i> Forgot pwd?</a><br>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-12 text-center">
              <button @click="loginMe" class="btn btn-info btn-block margin-top-10">SIGN IN</button>
            </div>
            <!-- /.col -->
          </div>
        </div>

<!--         <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-social-icon btn-circle btn-facebook"><i class="fa fa-facebook"></i></a>
          <a href="#" class="btn btn-social-icon btn-circle btn-google"><i class="fa fa-google-plus"></i></a>
        </div> -->
        <!-- /.social-auth-links -->

        <div class="margin-top-30 text-center">
          <p>Don't have an account? 
          <router-link to="/signup" class="text-info m-l-5">Sign Up</router-link></p>
        </div>

      </div>
      <!-- /.login-box-body -->
    </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'


  export default {
    name: 'login',
    data () {
      return {
        username:"",
        password:""
      }
    },
    computed:{
      // myprofile(){
      //     return this.$store.state.users.profile;
      // },
    },
    created() {

    },
    methods: {
      loadProfile(){
        axios.get(`http://localhost/users/`)
        .then((resolved)=>{
            console.log(resolved.data)
          })
        .catch(rejected=>{})
      },
      loginMe(){
        this.$store.dispatch("users/login",{
            userName: this.username,
            password: this.password
          })
            .then((jwt_token) => {
              console.log("login success!!");

              window.axios.defaults.headers.Authorization=`jwt ` + jwt_token

              this.$store.dispatch("users/get_myprofile").then(
                resolve=>{
                    this.$store.dispatch("system/get_systemEnvs")
                    // this.$router.push("/exrate/")
                    if(resolve.membership=="ADMIN"){
                      window.location.href="/superadmin/"
                    }else{
                      window.location.href="/exrate/"
                    }
                },rejecte=>{});

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
      sendPasswordResetEmail(){
        Swal.fire({
          title: 'Submit your Email',
          input: 'email',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Apply',
          showLoaderOnConfirm: true,
          preConfirm: (email) => {
            var params={
              "email":email
            }
            return axios.post("/api/userprofiles/resetpassword/",params)
            .then(response => {
                if (!response.data.result) {
                  throw new Error(response.message)
                }
                return response.data
              })
              .catch(error => {
                console.log(error)
              })
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
          console.log(result)
          if (result.value.result) {
            var imageURL="http://"+location.hostname+":2080/static/img/logo.svg"
            Swal.fire({
              title: `Reset link was sent`,
              // title: `Sent ${result.value.email} reset link.`,
              imageUrl: imageURL
            })
          }else{            
            Swal.fire(
              '失败!',
              '确定邮箱没有问题？没有找到该用户！',
              'error'
            )
          }
        })

      },
    }
  };

</script>

<style lang="scss">
.lionhu_img{
  display:block;
  margin: 0 auto;
  width: 20%;
}
.swal2-image{
  width: 40%;
}
</style>