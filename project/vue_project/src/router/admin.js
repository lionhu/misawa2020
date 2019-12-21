
import Vue from 'vue';
import Router from 'vue-router';
import store from '../store/exrate'
import { setTitle, setToken, getToken } from '../lib/util'


Vue.use(Router);
function loadView(view) {
  return ()=>import(/* webpackChunkName: "../../static/bundles/admin/[request]" */`../components/admin/${view}.vue`)
}

const router = new Router({
  routes:[
        {
            path: '/',
            name:"home",
            components:{
                topmenu:loadView("menu/TopMenu"),
                sidemenu:loadView("menu/SideMenu"),
                maincontent:loadView("Home")
            }
        },
        {
            path: '/dsorder',
            name:"dsorder",
            components:{
                topmenu:loadView("menu/TopMenu"),
                sidemenu:loadView("menu/SideMenu"),
                maincontent:loadView("Orders/DirectSingleOrder")
            }
        },
        {
            path: '/dsorders',
            name:"dsorders",
            components:{
                topmenu:loadView("menu/TopMenu"),
                sidemenu:loadView("menu/SideMenu"),
                maincontent:loadView("Orders/DirectOrders")
            }
        },
        {
            path: '/single_auctionorder',
            name:"single_auctionorder",
            components:{
                topmenu:loadView("menu/TopMenu"),
                sidemenu:loadView("menu/SideMenu"),
                maincontent:loadView("Orders/AuctionSingleOrder")
            }
        },
        {
            path: '/auctionorders',
            name:"auctionorders",
            components:{
                topmenu:loadView("menu/TopMenu"),
                sidemenu:loadView("menu/SideMenu"),
                maincontent:loadView("Orders/AuctionOrders")
            }
        },
        {
            path: '/users',
            name:"users",
            components:{
                topmenu:loadView("menu/TopMenu"),
                sidemenu:loadView("menu/SideMenu"),
                maincontent:loadView("Users")
            }
        },
        {
            path: '/shopusers',
            name:"shopusers",
            components:{
                topmenu:loadView("menu/TopMenu"),
                sidemenu:loadView("menu/SideMenu"),
                maincontent:loadView("ShopUsers")
            }
        },
    ]
});

const HAS_LOGINED = false
router.beforeEach((to, from, next) => {

  const token = getToken()
  console.log("router to: superadmin")
  if (token) {
      store.dispatch('users/authorization',token).then(rules => {
        const membership=store.state.users.profile.membership
        console.log(membership)
        if(membership=="ADMIN"){        
            console.log("OK authorization admin")
            next()
        }else{ 
            console.log("Not superadmin authorization ")
            window.location.href="/exrate"
        }

      }).catch(() => {
        console.log("NG authorization")
        setToken('')
        window.location.href="/member/#/login/"
      })
  } else {
    const safe_routers=["login","logout","resetpassword"]
    var check_safe_router=safe_routers.findIndex(router => router==to.name)
    console.log(check_safe_router)
    if(check_safe_router>-1){
        next()
    }else{
        window.location.href="/member/#/login/"
    }
  }
})

// router.beforeResolve

router.afterEach((to, from) => {
  // logining = false
})

export default router