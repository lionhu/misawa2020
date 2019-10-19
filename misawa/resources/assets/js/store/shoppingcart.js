import system from '../api/system';
import SuperAdmin from '../api/SuperAdmin';

const state = {
    items:[],
    superadmin_cart:{},
    coupon:"",
    memo:"",
    viewproduct:{},
    jpyrate:0
    // item:{qty,total_o,total_b,product:{id,o_price,b_price}}
}

// getters
const getters = {

    Qty: (state) => {
        const _count=state.items.reduce(function(result,current){
            return result+=current.qty
        },0);
        return _count;},

    Total_O: (state) => {
        const _total=state.items.reduce(function(result,current){
            return result+=current.total_o
        },0);
        return _total;
    },
    Total_B: (state) => {
        const _total=state.items.reduce(function(result,current){
            return result+=current.total_b
        },0);
        return _total;
    },
};

// actions
const actions = {
    post_checkout({commit},params){
        console.log("post_checkout")
        return new Promise(resolve=>{
            system.member_post_checkout(params,
            data => {
                resolve(data);
            },err =>{
                console.log("dispatch error");
                resolve(err.response.data.data)
            })
        },reject=>{

            console.log("reject error");
            reject("NG")
        });
    },

    get_viewproduct({commit},{productid,rate}){
        system.get_viewproduct(productid,
            data => {
                    commit("set_viewproduct",{product:data.product,rate:rate});
            },err =>{console.log(err)}
            )
    },

    superadmin_evaluateCart({state,commit},_user_rate){
        const params={
            user_rate:_user_rate,
            items:state.items
        }
        SuperAdmin.postEvaluateCart(params,
            data => {
                commit("setup_admin_cart",data)
            },err =>{console.log(err)})

    }
};

// mutations
const mutations = {
    set_viewproduct(state,{product,rate}){
        console.log("product view")
        // console.log(rate)
        // state.viewproduct={
        //     id:product.id,
        //     name:product.name,
        //     name_jp:product.name_jp,
        //     b_price:parseInt(product.b_price)+Math.ceil((parseInt(product.o_price)-parseInt(product.b_price))*rate),
        //     o_price:product.o_price,
        //     postimage:product.postimage,
        //     thumbImage:product.thumbImage
        // }
        state.viewproduct=product;
        state.viewproduct.rate=parseInt(product.rate);

    },
    reset(state){
        state.items=[];
        state.coupon="";
        state.memo="";
    },
    add_product(state, params){
        const productIndex=state.items.findIndex(item =>item.product.id ==params.product.id);

        if(productIndex >-1){
            state.items[productIndex].qty += params.qty;
            const new_qty=state.items[productIndex].qty;

            state.items[productIndex].total_o = new_qty*params.product.o_price;
            state.items[productIndex].total_b = new_qty*params.product.b_price;
        }else{
            const item={
                qty:params.qty,
                total_o:params.qty*params.product.o_price,
                total_b:params.qty*params.product.b_price,
                product:params.product
            }
            state.items.push(item)
        }
    },
    remove_product(state, params){
        // params={product:product,qty:qty}
        const productIndex=state.items.findIndex(item =>item.product.id ==params.product.id);
        const dis_price=parseInt(params.product.b_price)+Math.ceil((parseInt(params.product.o_price)-parseInt(params.product.b_price))*params.user_rate);


        if(productIndex >-1){
            if(state.items[productIndex].qty > params.qty){
                state.items[productIndex].qty -= params.qty;
                state.items[productIndex].total_o = state.items[productIndex].qty*params.product.o_price;
                state.items[productIndex].total_b = state.items[productIndex].qty*params.product.b_price;
            }else{
                state.items.splice(productIndex,1)
            }
        }
    },

    removeitem(state,product_id){
        const productIndex=state.items.findIndex(item =>item.product.id ==product_id);

        if(productIndex >-1){
                state.items.splice(productIndex,1)
        }
    },
    setup_items(state,items){
        state.items=items;
    },
    setup_admin_cart(state,data){
        state.superadmin_cart=data.cart;
        state.jpyrate=data.jpy_rate;
    },
    set_coupon(state,coupon){
        state.coupon=coupon;
    }

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
