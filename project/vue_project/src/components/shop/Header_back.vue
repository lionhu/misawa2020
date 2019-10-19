<template>

<div>
    <!-- Top Bar
    ============================================= -->
    <div id="top-bar" class="d-none d-md-block">

      <div class="container clearfix">

        <div class="col_half nobottommargin">

          <p class="nobottommargin"><strong>Call:</strong> 120-547-2145 | <strong>Email:</strong> info@canvas.com</p>

        </div>

        <div class="col_half col_last fright nobottommargin">

          <!-- Top Links
          ============================================= -->
          <div class="top-links">
            <ul>
              <li><a href="#">USD</a>
                <ul>
                  <li><a href="#">EUR</a></li>
                  <li><a href="#">AUD</a></li>
                  <li><a href="#">GBP</a></li>
                </ul>
              </li>
              <li><a href="#">EN</a>
                <ul>
                  <li><a href="#"><img src="/static/canvas/images/icons/flags/french.png" alt="French"> FR</a></li>
                  <li><a href="#"><img src="/static/canvas/images/icons/flags/italian.png" alt="Italian"> IT</a></li>
                  <li><a href="#"><img src="/static/canvas/images/icons/flags/german.png" alt="German"> DE</a></li>
                </ul>
              </li>
              <li>
                <a href="#" id="login_user">{{user.username ==""? "Login":user.username}}</a>
                <div class="top-link-section">
                    <div class="input-group" id="top-login-username">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="icon-user"></i></div>
                      </div>
                      <input type="text" v-model="user.username" class="form-control" placeholder="Email address" required="">
                    </div>
                    <div class="input-group" id="top-login-password">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="icon-key"></i></div>
                      </div>
                      <input type="password"  v-model="user.password"   class="form-control" placeholder="Password" required="">
                    </div>
                    <label class="checkbox">
                      <input type="checkbox"value="remember-me"> Remember me
                    </label>
                    <a href="javascript:void(0);" @click="logout">Logout</a>
                    <button class="btn btn-danger btn-block" @click="loginMe">Sign in</button>
                </div>
              </li>
            </ul>
          </div><!-- .top-links end -->

        </div>

      </div>

    </div><!-- #top-bar end -->
    <!-- Header
    ============================================= -->
    <header id="header">

      <div id="header-wrap">

        <div class="container clearfix">

          <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

          <!-- Logo
          ============================================= -->
          <div id="logo">
            <a href="index.html" class="standard-logo" data-dark-logo="images/logo-dark.png"><img src="/static/img/nichiei_with_text.png" alt="Canvas Logo"></a>
            <a href="index.html" class="retina-logo" data-dark-logo="images/logo-dark@2x.png"><img src="/static/img/nichiei_with_text.png" alt="Canvas Logo"></a>
          </div><!-- #logo end -->

          <!-- Primary Navigation
          ============================================= -->
          <nav id="primary-menu">

            <ul>
              <li class="current"><a href="#"><div>Home</div><span>Lets Start</span></a>
                <ul>
                  <li><a href="index-corporate.html"><div>Home - Corporate</div></a>
                    <ul>
                      <li><a href="index-corporate.html"><div>Corporate - Layout 1</div></a></li>
                      <li><a href="index-corporate-2.html"><div>Corporate - Layout 2</div></a></li>
                      <li><a href="index-corporate-3.html"><div>Corporate - Layout 3</div></a></li>
                      <li><a href="index-corporate-4.html"><div>Corporate - Layout 4</div></a></li>
                    </ul>
                  </li>
                  <li><a href="index-portfolio.html"><div>Home - Portfolio</div></a>
                    <ul>
                      <li><a href="index-portfolio.html"><div>Portfolio - Layout 1</div></a></li>
                      <li><a href="index-portfolio-2.html"><div>Portfolio - Layout 2</div></a></li>
                      <li><a href="index-portfolio-3.html"><div>Portfolio - Masonry</div></a></li>
                      <li><a href="index-portfolio-4.html"><div>Portfolio - AJAX</div></a></li>
                    </ul>
                  </li>
                  <li><a href="index-blog.html"><div>Home - Blog</div></a>
                    <ul>
                      <li><a href="index-blog.html"><div>Blog - Layout 1</div></a></li>
                      <li><a href="index-blog-2.html"><div>Blog - Layout 2</div></a></li>
                      <li><a href="index-blog-3.html"><div>Blog - Layout 3</div></a></li>
                    </ul>
                  </li>
                  <li><a href="index-shop.html"><div>Home - Shop</div></a>
                    <ul>
                      <li><a href="index-shop.html"><div>Shop - Layout 1</div></a></li>
                      <li><a href="index-shop-2.html"><div>Shop - Layout 2</div></a></li>
                    </ul>
                  </li>
                  <li><a href="index-magazine.html"><div>Home - Magazine</div></a>
                    <ul>
                      <li><a href="index-magazine.html"><div>Magazine - Layout 1</div></a></li>
                      <li><a href="index-magazine-2.html"><div>Magazine - Layout 2</div></a></li>
                      <li><a href="index-magazine-3.html"><div>Magazine - Layout 3</div></a></li>
                    </ul>
                  </li>
                  <li><a href="landing.html"><div>Home - Landing Page</div></a>
                    <ul>
                      <li><a href="landing.html"><div>Landing Page - Layout 1</div></a></li>
                      <li><a href="landing-2.html"><div>Landing Page - Layout 2</div></a></li>
                      <li><a href="landing-3.html"><div>Landing Page - Layout 3</div></a></li>
                      <li><a href="landing-4.html"><div>Landing Page - Layout 4</div></a></li>
                      <li><a href="landing-5.html"><div>Landing Page - Layout 5</div></a></li>
                    </ul>
                  </li>
                  <li><a href="index-fullscreen-image.html"><div>Home - Full Screen</div></a>
                    <ul>
                      <li><a href="index-fullscreen-image.html"><div>Full Screen - Image</div></a></li>
                      <li><a href="index-fullscreen-slider.html"><div>Full Screen - Slider</div></a></li>
                      <li><a href="index-fullscreen-video.html"><div>Full Screen - Video</div></a></li>
                    </ul>
                  </li>
                  <li><a href="index-onepage.html"><div>Home - One Page</div></a>
                    <ul>
                      <li><a href="index-onepage.html"><div>One Page - Default</div></a></li>
                      <li><a href="index-onepage-2.html"><div>One Page - Submenu</div></a></li>
                      <li><a href="index-onepage-3.html"><div>One Page - Dots Style</div></a></li>
                    </ul>
                  </li>
                  <li><a href="index-wedding.html"><div>Home - Wedding</div></a></li>
                  <li><a href="index-restaurant.html"><div>Home - Restaurant</div></a></li>
                  <li><a href="index-events.html"><div>Home - Events</div></a></li>
                  <li><a href="index-parallax.html"><div>Home - Parallax</div></a></li>
                  <li><a href="index-app-showcase.html"><div>Home - App Showcase</div></a></li>
                </ul>
              </li>
              <!-- Mega Menu
              ============================================= -->
              <li class="mega-menu"><a href="#"><div>Men</div><span>Out of the Box</span></a>
                <div class="mega-menu-content style-2 clearfix">
                  <ul class="mega-menu-column col-lg-3">
                    <li class="mega-menu-title"><a href="#"><div>Footwear</div></a>
                      <ul>
                        <li><a href="#"><div>Casual Shoes</div></a></li>
                        <li><a href="#"><div>Formal Shoes</div></a></li>
                        <li><a href="#"><div>Sports shoes</div></a></li>
                        <li><a href="#"><div>Flip Flops</div></a></li>
                        <li><a href="#"><div>Slippers</div></a></li>
                        <li><a href="#"><div>Sports Sandals</div></a></li>
                        <li><a href="#"><div>Party Shoes</div></a></li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="mega-menu-column col-lg-3">
                    <li class="mega-menu-title"><a href="#"><div>Clothing</div></a>
                      <ul>
                        <li><a href="#"><div>Casual Shirts</div></a></li>
                        <li><a href="#"><div>T-Shirts</div></a></li>
                        <li><a href="#"><div>Collared Tees</div></a></li>
                        <li><a href="#"><div>Pants / Trousers</div></a></li>
                        <li><a href="#"><div>Ethnic Wear</div></a></li>
                        <li><a href="#"><div>Jeans</div></a></li>
                        <li><a href="#"><div>Sweamwear</div></a></li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="mega-menu-column col-lg-3">
                    <li class="mega-menu-title"><a href="#"><div>Accessories</div></a>
                      <ul>
                        <li><a href="#"><div>Bags &amp; Backpacks</div></a></li>
                        <li><a href="#"><div>Watches</div></a></li>
                        <li><a href="#"><div>Sunglasses</div></a></li>
                        <li><a href="#"><div>Wallets</div></a></li>
                        <li><a href="#"><div>Caps &amp; Hats</div></a></li>
                        <li><a href="#"><div>Jewellery</div></a></li>
                        <li><a href="#"><div>Belts, Ties</div></a></li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="mega-menu-column col-lg-3">
                    <li class="mega-menu-title"><a href="#"><div>New Arrivals</div></a>
                      <ul>
                        <li><a href="#"><div>T-Shirts</div></a></li>
                        <li><a href="#"><div>Formal Shoes</div></a></li>
                        <li><a href="#"><div>Accessories</div></a></li>
                        <li><a href="#"><div>Watches</div></a></li>
                        <li><a href="#"><div>Perfumes</div></a></li>
                        <li><a href="#"><div>Belts, Ties</div></a></li>
                        <li><a href="#"><div>Formal Shirts</div></a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </li><!-- .mega-menu end -->
              <li><a href="#"><div>Women</div><span>Out of the Box</span></a>
                <div class="mega-menu-content style-2 clearfix">
                  <ul class="mega-menu-column col-lg-6">
                    <li class="mega-menu-title"><a href="#"><div>Footwear</div></a>
                      <ul>
                        <li><a href="#"><div>Casual Shoes</div></a></li>
                        <li><a href="#"><div>Formal Shoes</div></a></li>
                        <li><a href="#"><div>Sports shoes</div></a></li>
                        <li><a href="#"><div>Flip Flops</div></a></li>
                        <li><a href="#"><div>Slippers</div></a></li>
                        <li><a href="#"><div>Sports Sandals</div></a></li>
                        <li><a href="#"><div>Party Shoes</div></a></li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="mega-menu-column col-lg-6">
                    <li class="mega-menu-title"><a href="#"><div>Clothing</div></a>
                      <ul>
                        <li><a href="#"><div>Casual Shirts</div></a></li>
                        <li><a href="#"><div>T-Shirts</div></a></li>
                        <li><a href="#"><div>Collared Tees</div></a></li>
                        <li><a href="#"><div>Pants / Trousers</div></a></li>
                        <li><a href="#"><div>Ethnic Wear</div></a></li>
                        <li><a href="#"><div>Jeans</div></a></li>
                        <li><a href="#"><div>Sweamwear</div></a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </li><!-- .mega-menu end -->
              <li><a href="#"><div>Accessories</div><span>Awesome Works</span></a></li>
              <li><a href="#"><div>Sale</div><span>Awesome Works</span></a></li>
              <li><a href="#"><div>Blog</div><span>Latest News</span></a></li>
              <li><a href="#"><div>Videos</div><span>Latest News</span></a></li>
              <li><a href="#"><div>Contact</div><span>Get In Touch</span></a></li>
            </ul>

            <div  style="width:80px;">
              <a href="#" id="login_user">{{ME.user.username}}</a>
                <div class="top-link-section">

                    <div class="input-group" id="top-login-username">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="icon-user"></i></div>
                      </div>
                      <input type="text" v-model="user.username" class="form-control" placeholder="Email address" required="">
                    </div>
                    <div class="input-group" id="top-login-password">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="icon-key"></i></div>
                      </div>
                      <input type="password"  v-model="user.password"   class="form-control" placeholder="Password" required="">
                    </div>
                    <label class="checkbox">
                      <input type="checkbox"value="remember-me"> Remember me
                    </label>
                    <a href="javascript:void(0);" @click="logout">Logout</a>
                    <button class="btn btn-danger btn-block" @click="loginMe">Sign in</button>

                </div>
              </div>


            <!-- Top Cart
            ============================================= -->
            <div id="top-cart">
              <a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span>5</span></a>
              <div class="top-cart-content">
                <div class="top-cart-title">
                  <h4>Shopping Cart</h4>
                </div>
                <div class="top-cart-items">
                  <div class="top-cart-item clearfix">
                    <div class="top-cart-item-image">
                      <a href="#"><img src="/static/canvas/images/shop/small/1.jpg" alt="Blue Round-Neck Tshirt" /></a>
                    </div>
                    <div class="top-cart-item-desc">
                      <a href="#">Blue Round-Neck Tshirt</a>
                      <span class="top-cart-item-price">$19.99</span>
                      <span class="top-cart-item-quantity">x 2</span>
                    </div>
                  </div>
                  <div class="top-cart-item clearfix">
                    <div class="top-cart-item-image">
                      <a href="#"><img src="/static/canvas/images/shop/small/6.jpg" alt="Light Blue Denim Dress" /></a>
                    </div>
                    <div class="top-cart-item-desc">
                      <a href="#">Light Blue Denim Dress</a>
                      <span class="top-cart-item-price">$24.99</span>
                      <span class="top-cart-item-quantity">x 3</span>
                    </div>
                  </div>
                </div>
                <div class="top-cart-action clearfix">
                  <span class="fleft top-checkout-price">$114.95</span>
                  <button class="button button-3d button-small nomargin fright">View Cart</button>
                </div>
              </div>
            </div><!-- #top-cart end -->

            <!-- Top Search
            ============================================= 
            <div id="top-search">
              <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
              <form action="search.html" method="get">
                <input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
              </form>
            </div>-->

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
        ME:{
          user:{
            username:"Login"
          }
        },
        jwt_token:"",
        user:{
          username:"",
          password:""
        }
      }
    },
    computed:{
      // myprofile(){
      //     return this.$store.state.users.profile;
      // },
    },
    mounted() {

      let username=getToken("username")

      if(username =="" || username ==undefined){
        let jwt_token = localStorage.getItem("jwt_token");
        if(jwt_token){
            this.$store.dispatch("users/get_myprofile").then(
            resolve=>{
                this.ME=this.$store.state.users.profile;

                if(this.ME.language==""){
                    setToken("zh_CN","lang");
                    this.$i18n.locale = "zh_CN";//关键语句
                }else{
                    setToken(this.ME.language,"lang");
                    this.$i18n.locale = this.ME.language;//关键语句
                }

                setToken(this.ME.user.username,"username")

            },reject=>{});
        }
      }else{
        this.ME.user.username=username
      }

    },
    methods: {
      loginMe(){
        console.log({
            userName: this.user.username,
            password: this.user.password
          })
        this.$store.dispatch("users/login",{
            userName: this.user.username,
            password: this.user.password
          })
            .then(() => {
              console.log("login success!!");
              let jwt_token = localStorage.getItem("jwt_token");
              this.jwt_token = jwt_token;
              localStorage.setItem("username",this.user.username);
              window.axios.defaults.headers.Authorization=`jwt ` + jwt_token

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
      logout(){
        console.log("logout")
        this.$store.dispatch("users/logout")

        localStorage.setItem("username","");
        this.user.username=""
        console.log(this.user.username)
      },



      // submitform(){
      //   if (this.confirm_selectDate()){
      //       console.log(this.order)
      //       this.order.due_at +=" 23:59:59"
      //       this.$store.dispatch("orders/post_new_order",this.order).then(
      //         resolve=>{
      //           Swal.fire({
      //             type: 'success',
      //             title: 'Congratulation!',
      //             text: 'You have successfully placed a new order!'
      //           })
      //         },reject=>{})
      //   }
      // },
      // confirm_selectDate(){
      //   var ds = new Date()
      //   var selectds=new Date(this.order.due_at)

      //   if (this.order.due_at =="" || selectds < ds){
      //     Swal.fire({
      //       type: 'error',
      //       title: 'Oops...',
      //       text: '选择将来的日期作为有效期!'
      //     })
      //     this.order.due_at=""
      //     return false
      //   }else{
      //     return true
      //   }
      // },
      // adjust_rate(val){
      //   var newval=parseFloat(this.order.rate)+val
      //   this.order.rate =Math.round(newval*10000)/10000
      //   this.caculate_price()
      // },
      // select_type_jpy(){
      //   this.order.from_currency="jpy";
      //   this.order.to_currency = "rmb";
      //   this.order.rate = this.todayrate.chao_in
      //   this.caculate_price()
      // },
      // select_type_rmb(){
      //   this.order.from_currency="rmb";
      //   this.order.to_currency = "jpy";
      //   this.order.rate = this.todayrate.hui_out

      //   this.caculate_price()
      // },
      // caculate_price(){
      //   if (this.order.from_currency =="jpy"){
      //       if(this.order.amount>1000){
      //         this.order.amount=1000;
      //         Swal.fire({
      //           type:"error",
      //           title:"Oops...",
      //           text:this.$t("m.amount_tradelimit_jp")
      //         })
      //       }

      //       this.order.price =  parseInt(Math.round(this.order.amount*this.order.rate*100000)/1000)
      //   }else{
      //       if(this.order.amount>600000){
      //         this.order.amount=600000;
      //         Swal.fire({
      //           type:"error",
      //           title:"Oops...",
      //           text:this.$t("m.amount_tradelimit_cn")
      //         })
      //       }

      //       this.order.price = Math.round(this.order.amount/this.order.rate*100)

      //   }
      // }
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