
import Vue from 'vue';
import Router from 'vue-router';
import store from '../store'
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
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("Profile.vue")
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
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("MemberManage.vue") 
            }
        },
        {
            path: '/bonus',
            name:"bonus",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("Bonus.vue")
            }
        },
        {
            path: '/profile',
            name:"profile",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("Profile.vue")
            }
        },
        {
            path: '/law',
            name:"law",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("exrate/Law.vue")
            }
        },
        {
            path: '/introduction',
            name:"introduction",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("exrate/Introduction.vue")
            }
        },
        {
            path: '/order/list',
            name:"orderlist",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("orders/OrderList.vue")
            }
        },
        {
            path: '/order/mylist',
            name:"myorderlist",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("orders/UserOrderList.vue")
            }
        },
        {
            path: '/dsorder/mylist',
            name:"mydsorderlist",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("orders/UserDSOrderList.vue")
            }
        },
        {
            path: '/offer/mylist',
            name:"myofferlist",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("orders/UserOfferList.vue")
            }
        },
        {
            path: '/singleorder/:slug',
            name:"singleorder",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("orders/SingleOrder.vue")
            }
        },
        {
            path: '/mysingleorder/:slug',
            name:"mysingleorder",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("orders/UserSingleOrder.vue")
            }
        },
        {
            path: '/order/new',
            name:"neworder",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent: loadView("orders/NewOrder.vue")
            }
        },
        {
            path: '/dsorder/new',
            name:"newdsorder",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent: loadView("orders/NewDSOrder.vue")
            }
        },
        {
            path: '/resetpassword',
            name:"resetpassword",
            components:{
                maincontent:loadView("auth/PasswordReset.vue")
            }
        },
        {
            path: '/shop/orderlist',
            name:"shop_orderlist",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("shop/ShopOrderList.vue")
            }
        },

        {
            path: '/chat',
            name:"chat",
            components:{
                topmenu:loadView("TopMenu.vue"),
                sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("Chat.vue")
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

/**
 * 1. 导航被触发
 * 2. 在失活的组件（即将离开的页面组件）里调用离开守卫 beforeRouteLeave
 * 3. 调用全局的前置守卫 beforeEach
 * 4. 在重用的组件里调用 beforeRouteUpdate
 * 5. 调用路由独享的守卫 beforeEnter
 * 6. 解析异步路由组件
 * 7. 在被激活的组件（即将进入的页面组件）里调用 beforeRouteEnter
 * 8. 调用全局的解析守卫 beforeResolve
 * 9. 导航被确认
 * 10. 调用全局的后置守卫 afterEach
 * 11. 触发DOM更新
 * 12. 用创建好的实例调用beforeRouterEnter守卫里传给next的回调函数
 */

export default router