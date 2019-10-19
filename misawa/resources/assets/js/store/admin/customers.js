import system from '../../api/system';

const state = {
    all:[],
};

// getters
const getters = {
    customer_count: (state) => {
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
    update_user_client({commit},params){
        console.log("update_user_client")
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
    remove_user({commit},id){
        console.log("remove_user")
        system.remove_user(id,
            data => {
            if(data.result ==="OK"){
            commit("set_remove_user", data.id);
        }
    },
        err =>{
            console.log(err)
        })
    },
    get_all_customers({commit}){
        console.log("get_all_customers")
        system.getAllCustomers(
            data => {
                if(data.result ==="OK"){
                    commit("set_all_customers", data.customers);
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
    set_all_customers(state, customers){
        state.all=customers;
    },
    set_remove_customers(state, id){
        const index=state.all.findIndex(customer =>customer.id ==id);

        if(index >-1){
            state.all.splice(index,1);
        }
    },
    update_customer_info(state,customerinfo){
        const customerIndex=state.all.findIndex(customer => customer.id==customerinfo.id);

        if(customerIndex > -1){
            state.all[customerIndex]=customerinfo;
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
