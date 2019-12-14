import Vue from "vue"
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";
import users from './modules/users'
import lotteryshop from "./modules/shopping.js"
import orders from "./modules/ShoppingOrder.js"

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        users,
        lotteryshop,
        orders
    },
    plugins: [createPersistedState()],
    strict: debug
});