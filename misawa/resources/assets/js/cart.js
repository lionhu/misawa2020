

require('./bootstrap');

window.Vue = require('vue');

// Vue.component('cartitem', require('./components/CartItem.vue'));
// Vue.component('cart', require('./components/Cart.vue'));


import Shop_Cart from './components/Shop_Cart';

var vm=new Vue({
    el: '#app',
    render: h => h(Shop_Cart)
});
