import Vue from "vue"
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";
import system from './modules/system'
import orders from './modules/orders'
import users from './modules/users'
import lotteryshop from "./modules/shopping.js"

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        system,
        orders,
        users,
        lotteryshop
    },
    plugins: [createPersistedState()],
    strict: debug
});