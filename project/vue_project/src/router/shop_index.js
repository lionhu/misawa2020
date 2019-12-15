
import Vue from 'vue';
import Router from 'vue-router';
import store from '../store/shop_index'
import { setTitle, setToken, getToken } from '../lib/util'


Vue.use(Router);
function loadView(view) {
  return ()=>import(/* webpackChunkName: "../../static/bundles/[request]" */`../components/${view}`)
}


const router = new Router({
  routes:[
        {
            path: '/',
            name:"home",
            components:{
                // topmenu:loadView("shop/Header.vue"),
                // sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("shop/Top.vue")
            }
        },
        {
            path: '/user/home',
            name:"userhome",
            components:{
                // topmenu:loadView("shop/Header.vue"),
                // sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("shop/user/Home.vue")
            }
        },
        {
            path: '/cart/',
            name:"cart",
            components:{
                // topmenu:loadView("shop/Header.vue"),
                // sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("shop/Cart.vue")
            }
        },
        {
            path: '/checkout/',
            name:"checkout",
            components:{
                // topmenu:loadView("shop/Header.vue"),
                // sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("shop/Checkout.vue")
            }
        },
        {
            path: '/pay/',
            name:"payments",
            components:{
                // topmenu:loadView("shop/Header.vue"),
                // sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("shop/Payment.vue")
            }
        },
        {
            path: '/catalogue/:catalogue_id',
            name:"catalogue",
            components:{
                // topmenu:loadView("shop/Header.vue"),
                // sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("shop/Catalogue.vue")
            }
        },
        {
            path: '/product/:product_slug',
            name:"singleproduct",
            components:{
                maincontent:loadView("shop/SingleProduct.vue")
            }
        },
        {
            path: '/product_article/:slug',
            name:"product_article",
            components:{
                maincontent:loadView("shop/parts/ArticleProduct.vue")
            }
        },
        {
            path: '/user/orderlist',
            name:"orderlist",
            components:{
                maincontent:loadView("shop/user/OrderManagement.vue")
            }
        },
        {
            path: '/user/orderdetail/:slug',
            name:"orderdetail",
            components:{
                maincontent:loadView("shop/user/OrderDetails.vue")
            }
        },
        {
            path: '/login',
            name:"login",
            components:{
                maincontent:loadView("auth/shop/Login.vue")
            }
        },
        {
            path: '/signup',
            name:"signup",
            components:{
                maincontent:loadView("auth/shop/Signup.vue")
            }
        },
    ]
});

const HAS_LOGINED = false
router.beforeEach((to, from, next) => {

  const token = getToken()
  // console.log("router to: "+to.name+" check token: "+token)
  if (token) {
      store.dispatch('users/authorization',token).then(rules => {
        console.log("OK authorization")
        next()
      }).catch(() => {
        console.log("NG authorization")
        setToken('')
        // next({ name: 'login' })
        window.location.href="/member/#/login/"
      })
  } else {
    const safe_routers=["home","login","logout","resetpassword","catalogue","singleproduct"]
    var check_safe_router=safe_routers.findIndex(router => router==to.name)

    if(check_safe_router>-1){
    // if (to.name == 'home' || to.name == 'login' || to.name=="signup" || to.name=="resetpassword"){
        next()
    }else{
        // next({ name: 'login' })
        window.location.href="/member/#/login/"
    }
  }
})

// router.beforeResolve

router.afterEach((to, from) => {
  // logining = false
})


export default router