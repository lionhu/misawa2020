import system from '../../api/system';

const state = {
    ME:{},
    catalogues:[],
    monthSummary:[],

};

// getters
const getters = {
    // monthSummary_chartData: (state) => {
    //     if(state.monthSummary.length > 0){
    //         const _Dataset=state.monthSummary.reduce(function (result,current) {
    //             result.R_Total=result.R_Total.concat(parseInt(current.total_R_price/10000));
    //             result.Count=result.Count.concat(current.po_count);
    //             result.Labels=result.Labels.concat(current.PO_Month);
    //
    //             return result;
    //         },{R_Total:[],Count:[],Labels:[]});
    //         return _Dataset;
    //     }
    // },
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

    load_management_info({commit}){
        console.log("load_management_info")
        system.load_systemmanagement_info(
            data => {
                if(data.result ==="OK"){
                    commit("set_managementinfo", data);
                }
            },
            err =>{
                console.log(err)
            })
    },
};

// mutations
const mutations = {
    set_managementinfo(state,data){
        state.ME={
            id:data.user.id,
            name:data.user.name,
            rate:data.user.rate,
            role:data.user.roles[0].name
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
