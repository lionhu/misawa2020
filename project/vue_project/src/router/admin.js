
import Vue from 'vue';
import Router from 'vue-router';
import store from '../store'
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
                // topmenu:loadView("TopMenu.vue"),
                // sidemenu:loadView("SideMenu.vue"),
                maincontent:loadView("home")
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
        const membership=store.state.users.profile.membership
        if(membership!="Admin"){
            window.location.href="/exrate"
        }else{
            console.log("OK authorization admin")
            next()
        }

      }).catch(() => {
        console.log("NG authorization")
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