require('./bootstrap');

import Vue from 'vue';
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate)

import VueI18n from 'vue-i18n'
import {setToken,getToken} from "./lib/util.js"

// setToken("zh_CN","lang")


Vue.use(VueI18n) // 通过插件的形式挂载
const i18n = new VueI18n({
    locale: getToken("lang"),    // 语言标识
    //this.$i18n.locale // 通过切换locale的值来实现语言切换
    messages: {
      'zh_CN': require('./common/lang/zh'),   // 中文语言包
      'en_US': require('./common/lang/en'),    // 英文语言包
      'jp': require('./common/lang/jp')    // 英文语言包
    }
})



import './style/mystyle.scss';

import App from './App.vue';
import router from './router/admin.js'
import store from "./store/admin";
import msaFilters from './api/plugins/filters';
Vue.filter('currency', msaFilters.currency);
Vue.filter('currency_jpy', msaFilters.currency_jp);
Vue.filter('currency_rmb', msaFilters.currency_rmb);
Vue.filter('filterUsername', msaFilters.filterUsername);


const MainContent=new Vue({
    el: '#app',
    router,
    i18n,  // 不要忘记
    store,
    render: h => h(App)
});
console.log("hello_lionhu from admin.js")