
require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);

import App from './components/Top';
import store from "./store/vendor";
import router from "./router/vendor/index";

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);

import msaFilters from './plugin/filters';
Vue.filter('currency', msaFilters.currency);
Vue.filter('currency_jpy', msaFilters.currency_jp);
Vue.filter('currency_rmb', msaFilters.currency_cny);

const MainContent=new Vue({
    el: '#app',
    store,
    i18n:Vue.i18n,
    router,
    render: h => h(App)
});