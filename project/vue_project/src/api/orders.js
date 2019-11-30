/**
 * Mocking client-server processing
 */
// import axios from 'axios'
// import VueAxios from 'vue-axios'

export default {
    get_public_orders(cb, errorCb){
        axios.get('/api/auction_order/',)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    get_my_orders(cb, errorCb){
        axios.post('/api/auction_order/UserOrdersList/',{
            "OrderType":"withoutOffers"
        })
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },
    get_my_offers(cb, errorCb){
        axios.post('/api/auction_offer/list_user_offers/')
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    post_new_order(params,cb, errorCb){
        console.log("post_new_order")
        axios.post('/api/auction_order/',params)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },
    post_createoffer(params,cb, errorCb){
        // console.log(params)
        axios.post('/api/auction_offer/',params)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },
    post_deleteoffer(id,cb, errorCb){
        var url= '/api/auction_offer/'+id+'/'
        axios.delete(url)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    post_updateoffer(params,cb, errorCb){
        var url= '/api/auction_offer/'+params.offer_id+'/update_orderoffer/'
        axios.post(url,params)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    get_singleorder(slug,cb, errorCb){
        axios.post('/api/auction_order/getOrderBySlug/',{
            "slug":slug
        })
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },




    post_createTransactionAPI(params,cb,errorCb){
        axios.post('/api/auction_transaction/',params)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },



    post_new_dsorder(params,cb, errorCb){
        console.log("post_new_dsorder")
        axios.post('/api/ds_order/',params)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    get_my_dsorders(cb, errorCb){
        axios.get('/api/ds_order/listmine/')
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },

    delete_dsorder(slug,cb, errorCb){
        const url='/api/ds_order/'+slug+"/"
        axios.delete(url)
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },



};