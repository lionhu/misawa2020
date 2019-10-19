/**
 * Mocking client-server processing
 */
// import axios from 'axios'
// import VueAxios from 'vue-axios'

export default {
    get_public_orders(cb, errorCb){
        axios.get('/api/order/',)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    get_my_orders(cb, errorCb){
        axios.post('/api/order/UserOrdersList/',{
            "OrderType":"withoutOffers"
        })
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },
    get_my_offers(cb, errorCb){
        axios.post('/api/offer/list_user_offers/')
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

	post_new_order(params,cb, errorCb){
        axios.post('/api/order/',params)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    post_createoffer(params,cb, errorCb){
        // console.log(params)
        axios.post('/api/offer/',params)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },
    post_deleteoffer(id,cb, errorCb){
        var url= '/api/offer/'+id+'/'
        axios.delete(url)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    post_updateoffer(params,cb, errorCb){
        var url= '/api/offer/'+params.offer_id+'/update_orderoffer/'
        axios.post(url,params)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    get_singleorder(slug,cb, errorCb){
        axios.post('/api/order/get_order_by_slug/',{
            "slug":slug
        })
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },




    post_createTransactionAPI(params,cb,errorCb){
        axios.post('/api/transaction/',params)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    }


};