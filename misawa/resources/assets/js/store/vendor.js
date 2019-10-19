import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";
import pos from './vendor/pos'
import system from './vendor/system'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        pos,
        system
    },
    plugins: [createPersistedState()],
    strict: debug
});
