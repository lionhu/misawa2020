import system from '../../api/system';
import customerAdmin from '../../api/customerAdmin';

const state = {
    all:[],
    mypos:[],
    teampos:[],
    this_customer:{},
    monthlySummary:[]
};

// getters
const getters = {

    po_count: (state) => {
        return state.teampos.length},


    monthSummary_chartData: (state) => {
        if(state.monthlySummary.length > 0){
            const _Dataset=state.monthlySummary.reduce(function (result,current) {
                result.B_Total=result.B_Total.concat(current.total_B_price);
                result.O_Total=result.O_Total.concat(current.total_O_price);
                result.Profit=result.Profit.concat(current.profit);
                result.Count=result.Count.concat(current.po_count);
                result.Labels=result.Labels.concat(current.PO_Month);

                return result;
            },{O_Total:[],B_Total:[],Count:[],Profit:[],Labels:[]});
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

    get_customeradmin_ofStatus({commit},_status){
        console.log("get_customeradmin_ofStatus")
        return new Promise(resolve=>{
            customerAdmin.get_pos_ofStatus(_status,
            data => {
                if(data.result ==="OK"){
                    // commit("set_all_mypos", data.pos);
                    resolve(data)
                }
            },
            err =>{
                console.log(err)
            })
        },reject=>{});
    },
    get_customeradmin_mypos({commit}){
        console.log("get_customeradmin_mypos")
        customerAdmin.get_customeradmin_mypos(
            data => {
            if(data.result ==="OK"){
            commit("set_all_mypos", data.pos);
        }
    },
        err =>{
            console.log(err)
        })
    },
    get_customeradmin_teampos({commit,state}){
        console.log("get_customeradmin_teampos")
        customerAdmin.get_customeradmin_teampos(
            data => {
                    if(data.result ==="OK"){
                        commit("set_all_teampos", data.pos);
                    }else{
                        commit("set_all_teampos", []);
                    }
            },
            err =>{
                console.log(err)
            })
    },
    get_monthly_summary({commit}){
        console.log("get_monthly_summary")
        customerAdmin.getCustomerAdmin_MonthlySummary(
            data => {
            if(data.result ==="OK"){
            commit("set_monthlySummary", data);
        }
    },err =>{
            console.log(err)
        })
    },
};

// mutations
const mutations = {
    set_monthlySummary(state, data){
        state.monthlySummary=data.monthlySummary;
    },

    set_all_teampos(state, pos){
        state.teampos=[];
        state.teampos=pos;
        state.teampos.map(function (po) {
            po.cart_R_Price=0;
            po.cart_B_Price=0;
            po.cart=null;
            po.cart_admin=null;
            po.cartitems.map(function (item) {
                item.b_price=0;
                item.total_b_price=0;
                item.r_price=0;
                item.total_r_price=0;
            })
        });
    },
    set_all_mypos(state, pos){

        state.mypos=[];
        state.mypos=pos;
        state.mypos.map(function (po) {
            po.cart_R_Price=0;
            po.cart_B_Price=0;
            po.cart=null;
            po.cart_admin=null;
            po.cartitems.map(function (item) {
                item.b_price=0;
                item.total_b_price=0;
                item.r_price=0;
                item.total_r_price=0;
            })
        });
    },
    set_remove_mypo(state, id){
        const index=state.mypos.findIndex(po =>po.id ==id);

        if(index >-1){
            state.mypos.splice(index,1);
        }
    },
    set_remove_teampo(state, id){
        console.log("remove teampo");
        const index=state.teampos.findIndex(po =>po.id ==id);

        if(index >-1){
            state.teampos.splice(index,1);
        }
    },
    update_customer_info(state,customerinfo){
        console.log(customerinfo);
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
