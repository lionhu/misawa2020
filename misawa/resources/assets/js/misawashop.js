
require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);

import App from './components/Top_Member';
import store from "./store/member";
import router from "./router/member/index";

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

import TopCart from './components/Member/parts/MenuCart';
const MenuCart=new Vue({
    el: '#menucart',
    store,
    router,
    render: h => h(TopCart)
});

import TopCatalogueBar from './components/Member/parts/TopCatalogueBar';
const TopCatalogueMenu=new Vue({
    el: '#TopCatalogueMenu',
    store,
    router,
    render: h => h(TopCatalogueBar)
});