require('./bootstrap');

import Vue from 'vue';
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate)



// import 'bootstrap/dist/css/bootstrap.min.css';

// import ElementUI from 'element-ui';

// import locale     from 'element-ui/lib/locale/lang/ja'
// import 'element-ui/lib/theme-chalk/index.css';
// Vue.use(ElementUI, {locale});

// import './style/common.scss';
import './style/mystyle.scss';
// import { Button, Select,Table,TableColumn } from 'element-ui';
// import 'element-ui/lib/theme-chalk/lionhu.css';
// Vue.use(Button,Select,Table,TableColumn)

import App from './App.vue';
import router from './router/exrate'
import store from "./store/exrate";

const MainContent=new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
console.log("hello_lionhu from order.js")