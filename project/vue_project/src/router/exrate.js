
import Vue from 'vue';
import Router from 'vue-router';
import store from '../store/exrate'
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
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/Profile.vue")
            }
        },
        {
            path: '/login',
            name:"login",
            components:{
                maincontent:loadView("auth/Login.vue")
            }
        },
        {
            path: '/signup',
            name:"signup",
            components:{
                maincontent:loadView("auth/Signup.vue")
            }
        },
        {
            path: '/myteam',
            name:"myteam",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/MemberManage.vue") 
            }
        },
        {
            path: '/bonus',
            name:"bonus",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/Bonus.vue")
            }
        },
        {
            path: '/profile',
            name:"profile",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/Profile.vue")
            }
        },
        {
            path: '/law',
            name:"law",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/Law.vue")
            }
        },
        {
            path: '/faq',
            name:"faq",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/FAQ.vue")
            }
        },
        {
            path: '/contact',
            name:"contact",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/Contact.vue")
            }
        },
        {
            path: '/introduction',
            name:"introduction",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/Introduction.vue")
            }
        },
        {
            path: '/order/list',
            name:"orderlist",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/orders/OrderList.vue")
            }
        },
        {
            path: '/order/mylist',
            name:"myorderlist",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/orders/UserOrderList.vue")
            }
        },
        {
            path: '/dsorder/mylist',
            name:"mydsorderlist",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/orders/UserDSOrderList.vue")
            }
        },
        {
            path: '/offer/mylist',
            name:"myofferlist",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/orders/UserOfferList.vue")
            }
        },
        {
            path: '/singleorder/:slug',
            name:"singleorder",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("exrate/orders/SingleOrder.vue")
            }
        },
        {
            path: '/mysingleorder/:slug',
            name:"mysingleorder",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("exrate/orders/UserSingleOrder.vue")
            }
        },
        {
            path: '/order/new',
            name:"neworder",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent: loadView("exrate/orders/NewOrder.vue")
            }
        },
        {
            path: '/dsorder/new',
            name:"newdsorder",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent: loadView("exrate/orders/NewDSOrder.vue")
            }
        },
        {
            path: '/resetpassword',
            name:"resetpassword",
            components:{
                maincontent:loadView("auth/PasswordReset.vue")
            }
        },
        // {
        //     path: '/shop/orderlist',
        //     name:"shop_orderlist",
        //     components:{
        //         topmenu:loadView("exrate/TopMenu.vue"),
        //         sidemenu:loadView("exrate/SideMenu.vue"),
        //         maincontent:loadView("shop/ShopOrderList.vue")
        //     }
        // },

        {
            path: '/chat',
            name:"chat",
            components:{
                topmenu:loadView("exrate/TopMenu.vue"),
                sidemenu:loadView("exrate/SideMenu.vue"),
                maincontent:loadView("parts/Chat.vue")
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
        // console.log("OK authorization")
        next()
      }).catch(() => {
        // console.log("NG authorization")
        setToken('')
        // next({ name: 'login' })
        window.location.href="/member/#/login/"
      })
  } else {
    if (to.name == 'login' || to.name=="signup" || to.name=="resetpassword"){
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