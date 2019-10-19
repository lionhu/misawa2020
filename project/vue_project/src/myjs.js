import Vue from 'vue';
import App from './App.vue';
import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios,axios)


import 'bootstrap/dist/css/bootstrap.min.css';
import './style/common.scss';
import './style/mystyle.scss';

new Vue({
  el: '#app',
  template: '<App/>',
  components: { App }
})

console.log("hello_lionhu from myjs.js")