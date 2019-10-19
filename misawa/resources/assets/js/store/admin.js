import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";
import users from './admin/users'
import customers from './admin/customers'
import products from './admin/products'
import pos from './admin/pos'
import system from './admin/system'
import shoppingcart from './shoppingcart'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        users,
        pos,
        system,
        customers,
        products,
        shoppingcart
    },
    plugins: [createPersistedState()],
    strict: debug
});
