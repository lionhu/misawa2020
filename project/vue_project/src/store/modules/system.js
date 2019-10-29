import system from '../../api/system';

// initial state
const state = {
    todayrate:{},
    token:"",
    systemEnvs:{}
};

// getters
const getters = {

    // chartdata_BocRates: (state, getters) =>{
    // },

};

// actions
const actions = {

    get_todayrate({ commit }){
        console.log("store get_todayrate");
        return new Promise((resolve,reject)=>{
            system.get_TodayRate(
                res => {
                    if(!res.error){
                        commit("setTodayRate",res.data.todayrate);
                        resolve(res.data)
                    }
                },err =>{
                    console.log(err)
                }
            );
        })
    },
    get_systemEnvs({ commit }){
        console.log("store systemEnvs");
        return new Promise((resolve,reject)=>{
            system.get_systemEnvs(
                res => {
                    if(!res.result){
                        commit("setsystemEnvs",res.systemEnvs);
                        // resolve(res.data)
                    }
                },err =>{
                    console.log(err)
                }
            );
        })
    },
    load_dashboard({commit}){
        console.log("load_dashboard");
        return new Promise((resolve,reject)=>{
            system.load_dashboard(
                res => {
                    if(res.data.result){
                        resolve(res.data.data)
                    }
                },err =>{
                    console.log(err)
                }
            );
        })
    }
};

const mutations = {
    setsystemEnvs(state,data){
        this.systemEnvs=data
    },
    setToken(state,data){
        state.token=data.token;

    },
    setTodayRate(state,data){
        state.todayrate=data
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
