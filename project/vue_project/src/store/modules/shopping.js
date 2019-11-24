
import shopAPI from "../../api/lotteryshop.js"
import {showNotification} from "../../lib/util.js"

const state={
        products: null,
        catalogue_products:[],
        catalogues:[],
        cart: {
            summary:{
                Qty:0,
                Total:0
            }
        },
        toast: {
            text: "",
            show: false
        },
    };

const getters= {
        // cartSize: (state) => {
        //     return state.cart.length;
        // },
        cartTotalAmount: (state) => {
            total= state.cart.cartitems.reduce((total, cartitem) => {
                return total + cartitem.quantity;
            }, 0);
            console.log(total)
            return total
        },
        // toast: (state) => {
        //     return state.toast;
        // }
    };
const mutations= {
        setCatalogues(state,data){
            state.catalogues=data
        },
        setUpProducts: (state, productsPayload) => {
            //sets the state's  products property to the products array recieved as payload
            state.products = productsPayload;
        },
        setCatalogueProducts: (state, productsPayload) => {
            //sets the state's  products property to the products array recieved as payload
            state.catalogue_products = productsPayload;
        },
        setUpCart(state,data){
            state.cart=data
            var summary= state.cart.cartitems.reduce((total, cartitem) => {
                total.Qty += cartitem.quantity;
                total.Total += cartitem.sub_total
                return total

            }, {Qty:0,Total:0});
            state.cart.summary=summary
        },
        resetCart(state){
            state.cart={}
            state.cart.summary={
                            Qty:0,
                            Total:0
                        }
        }
    };
const actions= {
        fetchCatalogues: ({ commit }) => {
            shopAPI.getCatalogues().then((res) => {
                commit("setCatalogues", res.data.catalogues);
            });
        },
        fetchProducts: ({ commit }) => {
            shopAPI.getProducts().then((products) => {
                commit("setUpProducts", products);
            });
        },
        getProductBySlug: ({ commit },slug) => {
            return new Promise((resolve,reject)=>{
                shopAPI.getProductBySlug(slug).then((res) => {
                    if(res.data.result){
                        commit("resetCart")
                        resolve(res.data.product)
                    }
                });
            })

        },
        fetchCatalogueProducts: ({ commit },catalogue_id) => {
            shopAPI.productsOfSubCatalogues(catalogue_id).then((res) => {
                commit("setCatalogueProducts", res.data.products);
            },reject=>{
                console.log("error lod product")
            });
        },
        addToCart: ({ commit }, params) => {
            return new Promise((resolve,reject)=>{
                shopAPI.AddCartItem(params).then((res) => {
                    if(res.data.result){
                        commit("setUpCart",res.data.cart)
                        resolve(res.data.product)
                    }else{
                        showNotification(res.data.message,"warning")
                    }
                });
            })

        },
        removeFromCart: ({ commit }, params) => {
            return new Promise((resolve,reject)=>{
                shopAPI.RemoveCartItem(params).then((res) => {
                    if(res.data.result){
                        commit("setUpCart",res.data.cart)
                        resolve(res.data.product)
                    }
                });
            });
        },
        removeFullItemFromCart: ({ commit }, params) => {
            shopAPI.RemoveFullCartItem(params).then((res) => {
                if(res.data.result){
                    commit("setUpCart",res.data.cart)
                }
            });
        },
        updateCartItem: ({ commit }, params) => {
            shopAPI.updateCartItem(params).then((res) => {
                if(res.data.result){
                    commit("setUpCart",res.data.cart)
                }
            });
        },

        placeOrder({ commit },params){
            return new Promise((resolve,reject)=>{
                shopAPI.PlaceOrder(params).then((res) => {
                    if(res.data.result){
                        resolve(res.data)

                    }
                })
            })

        },
        getOrderBySlug({ commit },slug){
            return new Promise((resolve,reject)=>{
                shopAPI.GetOrderBySlug(slug).then((res) => {
                    if(res.data.result){
                        resolve(res.data)

                    }
                })
            })

        },
        getShoppingCart({ commit }){
            shopAPI.GetCart().then((res) => {
                if(res.data.result){
                    commit("setUpCart",res.data.cart)
                }
            })
        },
        getCustomerByPhone: ({ commit },phone) => {
            return new Promise((resolve,reject)=>{
                shopAPI.GetCustomerByPhone(phone).then((res) => {
                    if(res.data.result){
                        resolve(res.data.address)
                    }else{
                        resolve(null)
                    }
                });
            })

        },
        couponValidate: ({ commit },slug) => {
            return new Promise((resolve,reject)=>{
                shopAPI.couponValidate(slug).then((res) => {
                    if(res.data.result){
                        resolve(res.data.coupon)
                    }else{
                        resolve(null)
                    }
                });
            })

        },
        getMyOrderList({ commit }){
            return new Promise((resolve,reject)=>{
                shopAPI.GetMyOrderList().then((res) => {
                    if(res.data.result){
                        resolve(res.data)
                    }else{
                        resolve(null)
                    }
                });
            })
        }
    };

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};