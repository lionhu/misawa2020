import ordersAPI from '../../api/admin_orders.js';

// initial state
const state = {
    AuctionOrders:[],
    AuctionOrderSummary:{},
    // public_orders:[],
    // order_summary:{},
    // MyOrderList:[],
    // MyOrder_summary:{},
    // MyOfferList:[],
    // MyOffer_summary:{},
    DSOrder:{},
    DSOrders:[],
    DSOrderSummary:{},
};

// getters
const getters = {

    // chartdata_BocRates: (state, getters) =>{
    // },

};

// actions
const actions = {
    getAdminAuctionOrderList({commit}){
        ordersAPI.getAdminAuctionorders(
            res => {
                console.log(res.data)
                commit("setOrderList",res.data);
            },err =>{
                console.log(err)
            }
        );
    },
    getAdminAuctionSingleOrder({ commit },slug) {
        return new Promise((resolve,reject)=>{
            ordersAPI.getAdminAuctionSingleOrder(slug,
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

    getAdminDirectOrderList({commit}){
        return new Promise((resolve,reject)=>{
            ordersAPI.getAdminDirectOrders(
                res => {
                    commit("setDSOrderList",res.data);
                    resolve(res.data)
                },err =>{
                    console.log(err)
                }
            );
        })
    },
    getAdminDirectSingleOrder({ commit },slug) {
        return new Promise((resolve,reject)=>{
            ordersAPI.getAdminDirectSingleOrder(slug,
                res => {
                    if( !res.data.error ){
                        commit("setDSOrder",res.data);
                        resolve(res.data)
                    }
                },err =>{
                    reject("none")
                }
            );
        })
    },
};

const mutations = {
    setOrderList(state,data){
        state.AuctionOrders=data.orders;
        state.AuctionOrderSummary=data.summary
    },
    setDSOrderList(state,data){
        state.DSOrders=data.orders;
        state.DSOrderSummary=data.summary
    },
    setDSOrder(state,data){
        state.DSOrder=data.order;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
