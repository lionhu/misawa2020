import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";
import users from './customeradmin/users'
import customers from './customeradmin/customers'
import pos from './customeradmin/pos'
import system from './customeradmin/system'
import shoppingcart from './shoppingcart'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        users,
        customers,
        pos,
        system,
        shoppingcart
    },
    plugins: [createPersistedState()],
    strict: debug
});
