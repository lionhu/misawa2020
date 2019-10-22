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
      'zh_CN': require('./common/shop_lang/zh'),   // 中文语言包
      'en_US': require('./common/shop_lang/en'),    // 英文语言包
      'jp': require('./common/shop_lang/jp')    // 英文语言包
    }
})



import './style/mystyle.scss';

import App from './Shop.vue';
import shop_header from './components/shop/Header.vue'
import router from './router/shop_index'
import store from "./store/shop_index";
import msaFilters from './api/plugins/filters';
Vue.filter('currency', msaFilters.currency);
Vue.filter('currency_jpy', msaFilters.currency_jpy);
Vue.filter('currency_rmb', msaFilters.currency_rmb);
Vue.filter('filterUsername', msaFilters.filterUsername);


const MainContent=new Vue({
    el: '#app',
    router,
    i18n,  // 不要忘记
    store,
    render: h => h(App)
});

const Header=new Vue({
    el: '#shop_header',
    router,
    i18n,  // 不要忘记
    store,
    render: h => h(shop_header)
});
console.log("hello_lionhu from shop.js")