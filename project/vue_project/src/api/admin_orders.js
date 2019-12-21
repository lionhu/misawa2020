/**
 * Mocking client-server processing
 */
// import axios from 'axios'
// import VueAxios from 'vue-axios'

export default {
    getAdminAuctionorders(cb, errorCb){
        axios.post('/api/auction_order/AdminOrdersList/',)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },
    getAdminAuctionSingleOrder(slug,cb, errorCb){
        axios.post('/api/auction_order/AdminSingleOrder/',{
            "slug":slug
        })
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    getAdminDirectOrders(cb, errorCb){
        axios.post('/api/ds_order/AdminOrdersList/',)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },
    getAdminDirectSingleOrder(slug,cb, errorCb){
        axios.post('/api/ds_order/AdminSingleOrder/',{
            "slug":slug
        })
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },


};