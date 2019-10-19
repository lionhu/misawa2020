import system from '../../api/system';

const state = {
    vendors:[],
    vendorlist:[],
    catalogues:[],
    count_user:0,
    po_count:0,
    customer_count:0,
    rate:0

};

// getters
const getters = {
    // monthSummary_chartData: (state) => {
    //     if(state.monthSummary.length > 0){
    //         const _Dataset=state.monthSummary.reduce(function (result,current) {
    //             result.B_Total=result.B_Total.concat(parseInt(current.total_B_price));
    //             result.O_Total=result.O_Total.concat(parseInt(current.total_O_price));
    //             result.R_Total=result.R_Total.concat(parseInt(current.total_R_price*state.rate/100));
    //             result.Profit=result.Profit.concat(parseInt(current.total_B_price)-parseInt(current.total_R_price*state.rate/100));
    //             result.Labels=result.Labels.concat(current.PO_Month);
    //
    //             return result;
    //         },{O_Total:[],B_Total:[],R_Total:[],Profit:[],Labels:[]});
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
        state.vendors=data.vendors;
        state.vendorlist=data.vendors;
        // console.log(data.vendors)
        // var arr = new Array();
        //
        // if(state.vendors.length > 0){
        //     var jsonData = {};
        //     state.vendors.forEach(function (vendor) {
        //         var value=vendor.id;
        //         jsonData[value]=vendor.name
        //     });
        // }
        // state.vendorlist=jsonData;
        // console.log(state.vendorlist)

        const _catalogues=data.catalogues.map(function(catalogue){
            const _subcatalogues=catalogue.subcatalogues.map(function(sub){
                return {
                    value:sub.id,
                    label:sub.name
                }
            });
            return {
                value:catalogue.id,
                label:catalogue.name,
                children:_subcatalogues
            }
        });
        state.catalogues=_catalogues;

        state.rate=data.rate;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
