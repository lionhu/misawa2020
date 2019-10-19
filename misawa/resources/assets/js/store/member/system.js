import system from '../../api/system';
import member from '../../api/member';

const state = {
    catalogues:[],
    ME:{},
    current_SubCatalogue_id:33,
    current_Catalogue_id:3,
    top5:[]
};

// getters
const getters = {
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
        member.load_member_systemmanagement_info(
            data => {
                console.log("system load_management_info")
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
        // state.user_rate=data.user.rate;

        state.ME={
            id:data.user.id,
            name:data.user.name,
            rate:data.user.rate,
            role:data.user.roles[0].name
        }

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
                            b_price:parseInt((product.o_price-product.b_price)*state.ME.rate)+parseInt(product.b_price)
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

        state.top5=data.top5;

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
