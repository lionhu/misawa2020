import ordersAPI from '../../api/orders.js';

// initial state
const state = {
    public_orders:[],
    order_summary:{},
    MyOrderList:[],
    MyOrder_summary:{},
    MyOfferList:[],
    MyOffer_summary:{}
};

// getters
const getters = {

    // chartdata_BocRates: (state, getters) =>{
    // },

};

// actions
const actions = {
    get_mailExchange_orders({ commit }) {
        return new Promise(function(resolve,reject){
            ordersAPI.get_public_orders(res => {
                    commit("setMailExangeOrders",res.data);
                    resolve(res.data);
                },err =>{
                    console.log(err);
                    reject(err);
                }
            )
        })
    },

    get_my_orderlist({commit}){
        ordersAPI.get_my_orders(
            res => {
                commit("setMyOrderList",res.data);
            },err =>{
                console.log(err)
            }
        );
    },

    get_my_offerlist({commit}){
        return new Promise((resolve,reject)=>{
            ordersAPI.get_my_offers(
                res => {
                    commit("setMyOfferList",res.data);
                    resolve(res.data)
                },err =>{
                    console.log(err)
                }
            );
        })

    },

    post_new_order({ commit },params) {
        console.log("post_new_order");
        return new Promise((resolve,reject)=>{
            ordersAPI.post_new_order(params,
                res => {
                    if(res.data.id>0){
                        resolve(true)
                    }
                },err =>{
                    console.log(err)
                }
            );
        })
    },

    post_new_dsorder({ commit },params) {
        console.log("post_new_order");
        return new Promise((resolve,reject)=>{
            ordersAPI.post_new_dsorder(params,
                res => {
                    console.log(res.data.success)
                    if(res.data.success){
                        resolve(true)
                    }
                },err =>{
                    console.log(err)
                }
            );
        })
    },
    get_singleorder({ commit },slug) {
        return new Promise((resolve,reject)=>{
            ordersAPI.get_singleorder(slug,
                res => {
                    if( !res.data.error ){
                        resolve(res.data)
                    }
                },err =>{
                    console.log(err)
                }
            );
        })
    },

    post_createoffer({commit},params){
        return new Promise((resolve,reject)=>{
            console.log("create offer")
            ordersAPI.post_createoffer(params,
                res => {
                    if( res.data.result ){
                        resolve(res.data.offer)
                    }
                },err =>{
                    console.log(err)
                }
            );
        })
    },
    post_updateoffer({commit},params){
        return new Promise((resolve,reject)=>{
            ordersAPI.post_updateoffer(params,
                res => {
                    if( res.data.result ){
                        resolve(res.data)
                    }
                },err =>{
                    console.log(err)
                }
            );
        })
    },
    post_deleteOffer({commit},id){
        return new Promise((resolve,reject)=>{
            ordersAPI.post_deleteoffer(id,
                res => {
                        resolve(true)
                },err =>{
                    console.log(err)
                }
            )
        })
    },
    post_createTransaction({commit},params){
        return new Promise((resolve,reject)=>{
            ordersAPI.post_createTransactionAPI(params,
                res => {
                    if( !res.data.error ){
                        resolve(res.data)
                    }
                },err =>{
                    console.log(err)
                }
            );
        })
    }
};

const mutations = {
    setMailExangeOrders(state,data){
        state.public_orders=data.orders;
        state.order_summary=data.summary
    },
    setMyOrderList(state,data){
        state.MyOrderList=data.data.orders;
        state.MyOrder_summary=data.order_summary
    },
    setMyOfferList(state,data){
        state.MyOfferList=data.offers;
        state.MyOffer_summary=data.offer_summary
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
