import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";
import pos from './member/pos'
import products from './member/products'
import shoppingcart from './shoppingcart'
import system from './member/system'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        products,
        pos,
        system,
        shoppingcart
    },
    plugins: [createPersistedState()],
    strict: debug
});
