

require('./bootstrap');

window.Vue = require('vue');


import Shop_Checkout from './components/Shop_Checkout';

var vm=new Vue({
    el: '#app',
    render: h => h(Shop_Checkout)
});
