import system from '../../api/system';
import member from '../../api/member';

const state = {
    all:[],
};

// getters
const getters = {

    po_count: (state) => {
        return state.all.length},

}

// actions
const actions = {
    get_all_mypos({commit}){
        console.log("get_all_mypos")
        member.get_mypos(
            data => {
            if(data.result ==="OK"){
            commit("set_all_mypos", data.pos);
        }
    },
        err =>{
            console.log(err)
        })
    },
};

// mutations
const mutations = {

    set_all_mypos(state, pos){

        const _pos=pos.map(function (po) {
            return {
                id: po.id,
                cart_Qty: po.cart_Qty,
                cart_Dis_Price: po.cart_Dis_Price,
                cart_O_Price: po.cart_O_Price,
                vendor: po.vendor,
                customer: po.customer,
                status: po.status,
                P_Adjust: po.P_Adjust,
                locked:po.locked=='1'?true:false,
                delivery_no: po.delivery_no,
                created_at: po.created_at,
                paid_customer: po.paid_customer,
                cart: JSON.parse(po.cart)
            }
        });


        state.all=_pos;
    },
    set_remove_mypo(state, id){
        const index=state.all.findIndex(po =>po.id ==id);

        if(index >-1){
            state.all.splice(index,1);
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
