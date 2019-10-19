import system from '../../api/system';
import customerAdmin from '../../api/customerAdmin';


const state = {
    all:[],
    this_user:{},
};

// getters
const getters = {
    user_count: (state) => {
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
    get_customeradmin_users({commit}){
        console.log("get_customeradmin_users lionhu")
        customerAdmin.getCustomerAdminUsers(
            data => {
                if(data.result ==="OK"){
                    commit("set_all_users", data.users);
                }
            },
            err =>{
                console.log(err)
            })
    },
    // load_management_info({commit}){
    //     console.log("load_usermanagement_info")
    //
    //
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
    // set_managementinfo(state,data){
    //     state.clients=data.clients;
    //     state.roles=data.roles;
    // },

    set_all_users(state, users){
        state.all=users;
    },
    set_remove_user(state, id){
        const index=state.all.findIndex(user =>user.id ==id);

        if(index >-1){
            state.all.splice(index,1);
        }
    },
    update_user_info(state,userinfo){
        const userIndex=state.all.findIndex(user => user.id==userinfo.id);

        if(userIndex > -1){
            state.all[userIndex]=userinfo;
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
