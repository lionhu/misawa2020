import system from '../../api/system';

const state = {
    all:[],
    monthlySummary:[]
};

// getters
const getters = {
    monthSummary_chartData: (state) => {
    if(state.monthlySummary.length > 0){
        const _Dataset=state.monthlySummary.reduce(function (result,current) {
            result.R_Total=result.R_Total.concat(parseInt(current.total_R_price/10000));
            result.Unpaid=result.Unpaid.concat(parseInt((current.total_R_price-current.total_paid_vendor)/10000));
            result.Count=result.Count.concat(current.po_count);
            result.Labels=result.Labels.concat(current.PO_Month);

            return result;
        },{R_Total:[],Count:[],Unpaid:[],Labels:[]});
        return _Dataset;
    }
},
    Last3MonthSummary: (state) => {
        const _lenth=state.monthlySummary.length;
        return state.monthlySummary.slice(_lenth-3,_lenth);
    },
}

// actions
const actions = {

    get_vendor_allpos({commit}){
        console.log("get_vendor_allpos")
        system.get_vendor_allpos(
            data => {
            if(data.result ==="OK"){
            commit("set_all_pos", data);
        }
    },err =>{
            console.log(err)
        })
    },
    get_vendor_monthly_summary({commit}){
        console.log("get_vendor_monthly_summary")
        system.get_vendor_monthly_summary(
            data => {
                    if(data.result ==="OK"){
                    commit("set_monthlySummary", data);
                }
            },err =>{
                    console.log(err)
                })
    },
    update_po({commit},po) {
        console.log("update_po")
        return new Promise(resolve => {
            commit("update_po", po);
            resolve(state.all);
        }, reject => {})
    }
};

// mutations
const mutations = {

    set_monthlySummary(state, data){
        state.monthlySummary=data.monthlySummary;
    },

    set_all_pos(state, data){
        state.all=data.pos;
    },

    update_po(state,updated_po){
        const index=state.all.findIndex(po =>po.id ==updated_po.id);

        if(index >-1){
            state.all.splice(index,1,updated_po);
        }
    },

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
