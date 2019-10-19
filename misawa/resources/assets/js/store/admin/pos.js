import system from '../../api/system';

const state = {
    all:[],
    this_customer:{},
    rate:0,
    monthlySummary:[]
};


// getters
const getters = {
    po_count: (state) => {
        return state.all.length;
    },
    monthSummary_chartData: (state) => {
        if(state.monthlySummary.length > 0){
        const _Dataset=state.monthlySummary.reduce(function (result,current) {
                result.Dis_Total=result.Dis_Total.concat(parseInt(current.total_Dis_price));
                result.O_Total=result.O_Total.concat(parseInt(current.total_O_price));
                result.R_Total=result.R_Total.concat(parseInt(current.total_R_price*state.rate/100));
                result.Profit=result.Profit.concat(parseInt(current.total_Dis_price)-parseInt(current.total_R_price*state.rate/100));
                result.Count=result.Count.concat(current.po_count);
                result.Labels=result.Labels.concat(current.PO_Month);

            return result;
            },{O_Total:[],Dis_Total:[],R_Total:[],Count:[],Profit:[],Labels:[]});
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

    get_monthly_summary({commit}){
        console.log("get_monthly_summary")
        system.get_admin_monthly_summary(
            data => {
                if(data.result ==="OK"){
                commit("set_monthlySummary", data);
            }
        },err =>{
                console.log(err)
            })
    },

    get_superadmin_allpos({commit}){
        console.log("get_superadmin_allpos")
        system.get_superadmin_allpos(
            data => {
                if(data.result ==="OK"){
                    commit("set_all_pos", data);
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
        console.log(data)
        state.monthlySummary=data.monthlySummary;
    },

    set_all_pos(state, data){
        console.log(data)
        data.pos.map(function(po){
            po.locked= po.locked =='1'?true:false;
        });
        state.all=data.pos;

        state.rate=data.rate;
    },

    update_po(state,updated_po){
        const index=state.all.findIndex(po =>po.id ==updated_po.id);

        updated_po.locked= updated_po.locked =='1'?true:false;

        if(index >-1){
            state.all.splice(index,1,updated_po);
        }
    },

    set_remove_mypo(state, id){
        const index=state.all.findIndex(po =>po.id ==id);

        if(index >-1){
            state.all.splice(index,1);
        }
    },
    update_customer_info(state,customerinfo){
        console.log(customerinfo);
        const customerIndex=state.all.findIndex(customer => customer.id==customerinfo.id);

        if(customerIndex > -1){
            state.all[customerIndex]=customerinfo;
        }

        console.log(state.all[customerIndex]);
    }

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
