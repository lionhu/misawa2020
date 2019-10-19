require('./bootstrap_auth.js');

import Vue from 'vue';
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate)


import './style/mystyle.scss';

import Single from './Single.vue';
import router from './router/index'
import store from "./store/index";
import msaFilters from './api/plugins/filters';
Vue.filter('currency', msaFilters.currency);
Vue.filter('currency_jpy', msaFilters.currency_jp);
Vue.filter('currency_rmb', msaFilters.currency_rmb);



const MainContent=new Vue({
    el: '#app',
    router,
    store,
    render: h => h(Single)
});
console.log("hello_lionhu from main.js")