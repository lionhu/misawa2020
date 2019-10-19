import system from '../../api/system';
import customerAdmin from '../../api/customerAdmin';

const state = {
    all:[],
    this_customer:{},
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
};

// actions
const actions = {
    get_customeradmin_customers({commit}){
        console.log("get_customeradmin_customers")
        customerAdmin.getCustomerAdminCustomers(
            data => {
                if(data.result ==="OK"){
                    commit("set_all_customers", data.customers);
                }
            },
            err =>{
                console.log(err)
            })
    },
};

// mutations
const mutations = {
    set_all_customers(state, customers){
        state.all=customers;
    },
    set_remove_customer(state, id){
        const index=state.all.findIndex(user =>user.id ==id);

        if(index >-1){
            state.all.splice(index,1);
        }
    },
    update_customer_info(state,customerinfo){
        const customerIndex=state.all.findIndex(customer => customer.id==customerinfo.id);

        if(customerIndex > -1){
            state.all.splice(customerIndex,1,customerinfo);
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
