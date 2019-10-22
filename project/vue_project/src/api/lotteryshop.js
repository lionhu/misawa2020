export default {
    getCatalogues: () => {
        return new Promise((resolve, reject) => {
            axios.get('/api/catalogue/',).then((res)=>{
                resolve(res)
            }).catch(function(error){
                reject(error)
            })
            // setTimeout(() => {
            //     resolve(products);
            // }, 500);
        });
    },
    getProducts: () => {
        return new Promise((resolve, reject) => {
            axios.get('/api/order/',).then((res)=>{
                cb(res)
            }).catch(function(error){
                errorCb(error)
            })
        });
    },
    getProductBySlug: ( product_slug) => {
        return new Promise((resolve, reject) => {
            axios.get('/api/product/'+product_slug+"/",).then((res)=>{
                resolve(res)
            }).catch(function(error){
                reject(error)
            })
        });
    },
    productsOfSubCatalogues: (catalogue_id) => {
        return new Promise((resolve, reject) => {
            axios.get('/api/subcatalogue/'+catalogue_id,).then((res)=>{
                resolve(res)
            }).catch(function(error){
                reject(error)
            })
        });
    },

    // Cart related
    AddCartItem: (params) => {
        return new Promise((resolve, reject) => {
            axios.post('/api/cartitem/add/',params).then((res)=>{
                    resolve(res)
                }).catch(function(error){
                    reject(error)
                })
        });
    },
    updateCartItem: (params) => {
        return new Promise((resolve, reject) => {
            axios.post('/api/cartitem/update_item_quantity/',params).then((res)=>{
                    resolve(res)
                }).catch(function(error){
                    reject(error)
                })
        });
    },
    RemoveCartItem: (params) => {
        return new Promise((resolve, reject) => {
            axios.post('/api/cartitem/remove/',params).then((res)=>{
                    resolve(res)
                }).catch(function(error){
                    reject(error)
                })
        });
    },
    RemoveFullCartItem: (params) => {
        return new Promise((resolve, reject) => {
            axios.post('/api/cartitem/remove_fullitem/',params).then((res)=>{
                    resolve(res)
                }).catch(function(error){
                    reject(error)
                })
        });
    },
    GetCart: () => {
        return new Promise((resolve, reject) => {
            axios.get('/api/cart/').then((res)=>{
                    resolve(res)
                }).catch(function(error){
                    reject(error)
                })
        });
    },

    // Order related
    PlaceOrder: (params) => {
        console.log(params)
        return new Promise((resolve, reject) => {
            axios.post('/api/shop_order/',params).then((res)=>{
                    resolve(res)
                }).catch(function(error){
                    reject(error)
                })
        });
    },
    GetOrder: () => {
        return new Promise((resolve, reject) => {
            axios.get('/api/shop_order/').then((res)=>{
                    resolve(res)
                }).catch(function(error){
                    reject(error)
                })
        });
    },
    GetOrderBySlug: (slug) => {
        return new Promise((resolve, reject) => {
            axios.post('/api/shop_order/'+slug+'/bySlug/').then((res)=>{
                    resolve(res)
                }).catch(function(error){
                    reject(error)
                })
        });
    },
    GetCustomerByPhone(phone){
        console.log(phone)
        return new Promise((resolve, reject) => {
            axios.post('/api/address/retrieveByPhone/',{phone:phone}).then((res)=>{
                    resolve(res)
                }).catch(function(error){
                    reject(error)
                })
        });
    }
}