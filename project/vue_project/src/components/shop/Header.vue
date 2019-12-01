<template>

<div>

    <!-- Header
    ============================================= -->
    <header id="header" class="full-header clearfix">

      <div id="header-wrap">

        <div class="container clearfix">

          <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

          <!-- Logo
          ============================================= -->
          <div id="logo">
            <a href="/exrate/" class="standard-logo"><img src="/static/img/nichiei_with_text.png" alt="Canvas Logo"></a>
            <a href="/exrate/" class="retina-logo"><img src="/static/img/nichiei_with_text.png" alt="Canvas Logo"></a>
          </div><!-- #logo end -->

          <!-- Primary Navigation
          ============================================= -->
          <nav id="primary-menu" class="style-2 with-arrows">

            <ul>
              <li class="current">
                <router-link :to="{name:'home'}"><div>Home</div></router-link>
              </li>
              <!-- Mega Menu
              ============================================= -->
              <li class="mega-menu" v-for="catalogue in catalogues"><a href="#"><div>{{catalogue.name}}</div></a>
                <div class="mega-menu-content style-2 clearfix">
                  <ul class="mega-menu-column border-left-0 col-lg-3">
                    <li class="mega-menu-title" v-for="subcatalogue in catalogue.subcatalogues">
                      <router-link :to="{name:'catalogue',params:{'catalogue_id':subcatalogue.id}}"><div>{{subcatalogue.name}}</div></router-link>
                      <!-- <a href="#"><div>{{subcatalogue.name}}</div></a> -->
                    </li>
                  </ul>
                </div>
              </li>
            </ul>

            <!-- Top Cart
            ============================================= -->
            <div id="top-cart">
              <a href="#" id="top-cart-trigger"><i class="icon-line-bag"></i><span>{{cart.summary.Qty}}</span></a>
              <div class="top-cart-content">
                <div class="top-cart-title">
                  <h4>Shopping Cart</h4>
                </div>
                <div class="top-cart-items">
                  <div class="top-cart-item clearfix" v-for="cartitem in cart.cartitems">
                    <div class="top-cart-item-image">
                      <a href="#"><img :src="cartitem.product.avatar" :alt="cartitem.product.name" /></a>
                    </div>
                    <div class="top-cart-item-desc">
                      <router-link :to="{name:'singleproduct',params:{product_slug:cartitem.product.slug}}"  class="t400">{{cartitem.product.name}}</router-link>
                      <!-- <a href="#" class="t400">{{cartitem.product.name}}</a> -->
                      <span class="top-cart-item-price">{{cartitem.product.price|currency}}</span>
                      <span class="top-cart-item-quantity t600">x {{cartitem.quantity}}</span>
                    </div>
                  </div>
                </div>
                <div class="top-cart-action clearfix">
                  <span class="fleft top-checkout-price t600 text-dark">{{cart.summary.Total | currency}}</span>
                  <router-link :to="{name:'cart'}" class="button button-dark button-small nomargin fright text-white">View Cart</router-link>
                  <!-- <a class="button button-dark button-small nomargin fright text-white">View Cart</a> -->
                </div>
              </div>
            </div><!-- #top-cart end -->

            <!-- Top Search
            ============================================= -->
            <div id="top-account">
              <a href="javascript:void(0);" @click="showLogin"  v-if="ME.username ==undefined">
                <span class="d-sm-inline-block font-primary t500"><i class="icon-line2-user position-relative" ></i></span>
              </a>
              <a href="javascript:void(0);" @click="Logout" v-if="ME.username !=undefined">
                <i class="icon-line2-user mr-1 position-relative" style="top: 1px;"></i>{{ME.username}}
              </a>
            </div>

          </nav><!-- #primary-menu end -->

        </div>

      </div>

    </header><!-- #header end -->
</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'

  import {setToken,getToken} from "../../lib/util.js"

  export default {
    name: 'shop_header',
    components:{
    },
    // inject:["reload"],
    data () {
      return {
        user:{
          username:"",
          password:""
        }
      }
    },
    computed:{
      ME(){
        return this.$store.state.users.ME
      },
      catalogues:function(){
        return this.$store.state.lotteryshop.catalogues
      },

      cart(){
        return this.$store.state.lotteryshop.cart
      }
    },
    mounted() {
      let jwt_token=getToken("jwt_token")

      if( jwt_token !==null){
        window.axios.defaults.headers.Authorization=`jwt ` + jwt_token
        this.load_myprofile()
      }else{
        delete window.axios.defaults.headers.Authorization
        this.$store.commit("lotteryshop/resetCart")
      }
      this.$store.dispatch("lotteryshop/fetchCatalogues")
    },
    methods: {

      load_myprofile(){
          this.$store.dispatch("users/get_myprofile").then(resolve=>{
            this.$i18n.locale = this.ME.language;
            this.$store.dispatch("lotteryshop/getShoppingCart")
          },reject=>{})
      },
      Logout(){
        this.$store.dispatch("users/logout")
        Swal.fire({
                  type: 'success',
                  text: 'Logout!'
                })
        localStorage.removeItem("username")
        localStorage.removeItem("jwt_token")
        this.$store.commit("lotteryshop/resetCart")
        delete window.axios.defaults.headers.Authorization

        // window.location.reload();
      },
      async showLogin(){
            const { value: formValues } = await Swal.fire({
            title: 'Login',
            html:
              '<input id="swal_username" placeholder="username" class="swal2-input" value="root">' +
              '<input id="swal_password" type="password" placeholder="password" class="swal2-input" value="Hisshghu3500">',
            focusConfirm: false,
            // showCancelButton: true,
            // confirmButtonText: 'Login!',
            // cancelButtonText: 'Logout!',
            // reverseButtons: true,
            preConfirm: () => {
              return [
                document.getElementById('swal_username').value,
                document.getElementById('swal_password').value
              ]
            }
          })

          if (formValues) {
            this.loginMe(formValues[0],formValues[1])
          }
      },
      loginMe(username,password){
        console.log("loginMe")
        const vm=this
        this.$store.dispatch("users/login",{
            userName: username,
            password: password
          }).then((token) => {
              // window.axios.defaults.headers.Authorization=`jwt ` + token;
              console.log("login success!!");
              this.load_myprofile()
              // window.location.reload();
              return true;
            })
            .catch(error => {              
                Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: '请再次确认您的用户名和密码!'
                })
                return false
            });
      },
    }
};

</script>


<style lang="scss">

    .revo-slider-emphasis-text {
      font-size: 58px;
      font-weight: 700;
      letter-spacing: 1px;
      font-family: 'Raleway', sans-serif;
      padding: 15px 20px;
      border-top: 2px solid #FFF;
      border-bottom: 2px solid #FFF;
    }

    .revo-slider-desc-text {
      font-size: 20px;
      font-family: 'Lato', sans-serif;
      width: 650px;
      text-align: center;
      line-height: 1.5;
    }

    .revo-slider-caps-text {
      font-size: 16px;
      font-weight: 400;
      letter-spacing: 3px;
      font-family: 'Raleway', sans-serif;
    }

    .tp-video-play-button { display: none !important; }

    .tp-caption { white-space: nowrap; }
</style>