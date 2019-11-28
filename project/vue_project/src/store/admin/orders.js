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
    // MyDSOrderList:[],
    // MyDSOrder_summary:{},
};

// getters
const getters = {

    // chartdata_BocRates: (state, getters) =>{
    // },

};

// actions
const actions = {
    // get_mailExchange_orders({ commit }) {
    //     return new Promise(function(resolve,reject){
    //         ordersAPI.get_public_orders(res => {
    //                 commit("setMailExangeOrders",res.data);
    //                 resolve(res.data);
    //             },err =>{
    //                 console.log(err);
    //                 reject(err);
    //             }
    //         )
    //     })
    // },

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


    // get_my_offerlist({commit}){
    //     return new Promise((resolve,reject)=>{
    //         ordersAPI.get_my_offers(
    //             res => {
    //                 commit("setMyOfferList",res.data);
    //                 resolve(res.data)
    //             },err =>{
    //                 console.log(err)
    //             }
    //         );
    //     })

    // },

    // post_new_order({ commit },params) {
    //     console.log("post_new_order");
    //     return new Promise((resolve,reject)=>{
    //         ordersAPI.post_new_order(params,
    //             res => {
    //                 if(res.data.id>0){
    //                     resolve(true)
    //                 }
    //             },err =>{
    //                 console.log(err)
    //             }
    //         );
    //     })
    // },



    // post_createoffer({commit},params){
    //     return new Promise((resolve,reject)=>{
    //         console.log("create offer")
    //         ordersAPI.post_createoffer(params,
    //             res => {
    //                 if( res.data.result ){
    //                     resolve(res.data.offer)
    //                 }
    //             },err =>{
    //                 console.log(err)
    //             }
    //         );
    //     })
    // },
    // post_updateoffer({commit},params){
    //     return new Promise((resolve,reject)=>{
    //         ordersAPI.post_updateoffer(params,
    //             res => {
    //                 if( res.data.result ){
    //                     resolve(res.data)
    //                 }
    //             },err =>{
    //                 console.log(err)
    //             }
    //         );
    //     })
    // },
    // post_deleteOffer({commit},id){
    //     return new Promise((resolve,reject)=>{
    //         ordersAPI.post_deleteoffer(id,
    //             res => {
    //                     resolve(true)
    //             },err =>{
    //                 console.log(err)
    //             }
    //         )
    //     })
    // },
    // post_createTransaction({commit},params){
    //     return new Promise((resolve,reject)=>{
    //         ordersAPI.post_createTransactionAPI(params,
    //             res => {
    //                 if( !res.data.error ){
    //                     resolve(res.data)
    //                 }
    //             },err =>{
    //                 console.log(err)
    //             }
    //         );
    //     })
    // },


    // post_new_dsorder({ commit },params) {
    //     console.log("post_new_order");
    //     return new Promise((resolve,reject)=>{
    //         ordersAPI.post_new_dsorder(params,
    //             res => {
    //                 console.log(res.data.success)
    //                 if(res.data.success){
    //                     resolve(true)
    //                 }
    //             },err =>{
    //                 console.log(err)
    //             }
    //         );
    //     })
    // },
    // get_my_dsorderlist({commit}){
    //     return new Promise(function(resolve,reject){
    //         ordersAPI.get_my_dsorders(
    //             res => {
    //                 if(res.data.success){
    //                     commit("setMyDSOrderList",res.data);
    //                     resolve(res.data)
    //                 }
    //             },err =>{
    //                 console.log(err)
    //             }
    //         );
    //     })

    // },
    // delete_dsorder({commit},slug){
    //     ordersAPI.delete_dsorder(slug,
    //         res => {
    //             if(res.data.success){
    //                 commit("RemoveDSOrderFromList",res.data.slug)
    //             }
    //         },err =>{
    //             console.log(err)
    //         }
    //     );

    // },

};

const mutations = {
    // setMailExangeOrders(state,data){
    //     state.public_orders=data.orders;
    //     state.order_summary=data.summary
    // },
    setOrderList(state,data){
        state.AuctionOrders=data.orders;
        state.AuctionOrderSummary=data.summary
    },
    // setMyDSOrderList(state,data){
    //     state.MyDSOrderList=data.orders;
    //     state.MyDSOrder_summary=data.order_summary
    // },
    // RemoveDSOrderFromList(state,slug){
    //     const _index=state.MyDSOrderList.findIndex(order => order.slug==slug)

    //     if (_index>-1){
    //         state.MyDSOrderList.splice(_index,1)
    //     }

    // },
    // setMyOfferList(state,data){
    //     state.MyOfferList=data.offers;
    //     state.MyOffer_summary=data.offer_summary
    // }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
