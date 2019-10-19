import system from '../api/system';

const state = {
    catalogues:[],
    user_rate:1,
    current_SubCatalogue_id:2,
    current_Catalogue_id:3
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
        system.load_member_systemmanagement_info(
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
        state.user_rate=data.user_rate;

        const _catalogues=data.catalogues.map(function(catalogue){

            const _subcatalogues=catalogue.subcatalogues.map(function(sub){
                const tempProducts=sub.products.filter(product => product.active =='1');
                const _products=tempProducts.map(function(product){
                        return {
                            id:product.id,
                            name:product.name,
                            name_jp:product.name_jp,
                            postimage:product.postimage,
                            thumbImage:product.thumbImage,
                            o_price:parseInt(product.o_price),
                            b_price:parseInt((product.o_price-product.b_price)*state.user_rate)+parseInt(product.b_price)
                        }
                })

                return {
                    value:sub.id,
                    label:sub.name,
                    products_count:_products.length,
                    products:_products
                }
            });
            const tempSub=_subcatalogues.filter(sub =>sub.products_count>0);

            return {
                value:catalogue.id,
                label:catalogue.name,
                children:tempSub
            }
        });
        state.catalogues=_catalogues;

    },
    set_current_subCatalogue_id(state,params){
        console.log(params)
        state.current_SubCatalogue_id=parseInt(params.subcatalogueID);
        state.current_Catalogue_id=parseInt(params.catalogueID);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
