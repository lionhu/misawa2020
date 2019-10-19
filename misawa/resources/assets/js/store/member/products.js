import system from '../../api/system';
import SuperAdmin from '../../api/SuperAdmin';


const state = {
    all:[],
};

// getters
const getters = {
    product_count: (state) => {
        return state.all.length;
    },
    // selectUserRoleList: (state, getters) => {
    //     if(state.roles.length > 0){
    //         var jsonData = {};
    //         state.roles.forEach(function (role) {
    //             var eachclientID=role.id;
    //             jsonData[eachclientID]=role.name
    //         });
    //         return jsonData;
    //     }
    // },
}

// actions
const actions = {
    // update_bill_status({commit},params){
    //     return new Promise((resolve,reject)=>{
    //         alarmsells.postAdmin_AlarmSellBill_updateStatus(params,
    //             data => {
    //                 // if(data.result=="OK"){
    //                 //     console.log("after postAdmin_Bill_account_check")
    //                 //     commit("set_this_billaccount_status", data.account_status);
    //                 // }
    //                 resolve(params.status)
    //             },
    //             err =>{
    //                 // console.log("err in register_Bill_Bank");
    //                 // console.log(err);
    //                 // reject(err);
    //             })
    //     })
    // },
    // get_alarmsell_thisbill({commit},id){
    //     console.log("get_alarmsell_thisbill")
    //     alarmsells.post_Admin_AlarmSell_SingleBill(id,
    //         data => {
    //             if(data.result ==="OK"){
    //                 commit("set_this_bill", data.bill);
    //             }else{
    //                 commit("set_this_bill", {});
    //             }
    //         },
    //         err =>{
    //             console.log(err)
    //         }
    //     )
    // },
    update_product_infomation({commit},params){
        console.log("update_product_infomation")
        return new Promise((resolve=>{
            system.update_user_client(params,
                data => {
                    if(data.result ==="OK"){
                        commit("update_user_info", data.user);
                    }
                    resolve(data)
            },err=>{})
        }, reject=>{}));
    },
    // remove_product({commit},id){
    //     console.log("remove_user")
    //     system.remove_user(id,
    //         data => {
    //         if(data.result ==="OK"){
    //         commit("set_remove_user", data.id);
    //     }
    // },
    //     err =>{
    //         console.log(err)
    //     })
    // },
    get_all_products({commit}){
        console.log("get_all_products")
        SuperAdmin.getAllProducts(
            data => {
                if(data.result ==="OK"){
                    commit("set_all_products", data.products);
                }
            },
            err =>{
                console.log(err)
            })
    },
    // load_management_info({commit}){
    //     console.log("load_usermanagement_info")
    //     system.load_usermanagement_info(
    //         data => {
    //             if(data.result ==="OK"){
    //                 commit("set_managementinfo", data);
    //             }
    //         },
    //         err =>{
    //             console.log(err)
    //         })
    // },
};

// mutations
const mutations = {
    set_all_products(state, products){
        state.all=products;
    },
    // set_remove_customers(state, id){
    //     const index=state.all.findIndex(customer =>customer.id ==id);
    //
    //     if(index >-1){
    //         state.all.splice(index,1);
    //     }
    // },
    update_product_info(state,productinfo){
        var updateProductIndex=state.all.findIndex(product=>product.id ==productinfo.id);
        if(updateProductIndex >-1){
            console.log("update this po:"+productinfo.id+" index: "+updateProductIndex);
            state.all.splice(updateProductIndex,1,productinfo)
        }
    }

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
