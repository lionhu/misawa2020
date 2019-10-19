/**
 * Mocking client-server processing
 */


export default {
    update_user_client(params,cb,errorCb){
        axios.post('/admin/user/updateInfo/client',params)
            .then(({ data }) => {
                    cb(data);
            }).catch(function(error){
                    errorCb(error);
                });
    },

    remove_user(id,cb,errorCb){
        axios.post('/admin/user/delete',{
            userid:id
        }).then(({ data }) => {
                cb(data);
        }).catch(function(error){
                errorCb(error);
        });
    },

    getAllUsers(cb, errorCb){
        axios.post('/admin/user/getall')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },

    getAllCustomers(cb, errorCb){
        axios.post('/admin/customer/getall')
            .then(({ data }) => {
                cb(data);
        }).catch(function(error){
                errorCb(error);
        });
    },

    get_viewproduct(_productid,cb, errorCb){
        axios.post('/product/get',{
            productid:_productid
        }).then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },
    //
    // getCustomerAdminCustomers(cb, errorCb){
    //     axios.post('/customerAdmin/customer/getall')
    //         .then(({ data }) => {
    //         cb(data);
    // }).catch(function(error){
    //         errorCb(error);
    //     });
    // },

    // getCustomerAdmin_MonthlySummary(cb, errorCb){
    //     axios.post('/customerAdmin/customer/getall')
    //         .then(({ data }) => {
    //         cb(data);
    // }).catch(function(error){
    //         errorCb(error);
    //     });
    // },
    //
    //
    // get_customeradmin_mypos(cb, errorCb){
    //     axios.post('/customerAdmin/pos/mine')
    //         .then(({ data }) => {
    //         cb(data);
    // }).catch(function(error){
    //         errorCb(error);
    //     });
    // },
    //
    //
    // get_customeradmin_teampos(cb, errorCb){
    //     axios.post('/customerAdmin/pos/team')
    //         .then(({ data }) => {
    //         cb(data);
    // }).catch(function(error){
    //         errorCb(error);
    //     });
    // },



    load_usermanagement_info(cb, errorCb){
        axios.post('/admin/user/getManagementinfo')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },


    load_systemmanagement_info(cb, errorCb){
        axios.post('/admin/system/getManagementInfo')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },

    get_superadmin_allpos(cb, errorCb){
        axios.post('/admin/pos/all')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },

    get_admin_monthly_summary(cb, errorCb){
        axios.post('/admin/pos/monthlySummary')
            .then(({ data }) => {
                cb(data);
            }).catch(function(error){
                    errorCb(error);
            });
    },

    get_vendor_allpos(cb, errorCb){
        axios.post('/vendor/pos/all')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },

    get_vendor_monthly_summary(cb, errorCb){
        axios.post('/vendor/pos/monthlySummary')
            .then(({ data }) => {
                cb(data);
            }).catch(function(error){
                console.log(error)
            errorCb(error);
        });
    },

    member_post_checkout(params,cb,errorCb){
        axios.post('/shop/checkout',params)
            .then(({ data }) => {
                    cb(data);
            }).catch(function(error){
                    errorCb(error);
            });
    },


};