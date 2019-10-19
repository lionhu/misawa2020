/**
 * Mocking client-server processing
 */


export default {

    getCustomerAdminUsers(cb, errorCb){
        axios.post('/customerAdmin/user/getall')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },

    getCustomerAdminCustomers(cb, errorCb){
        axios.post('/customerAdmin/customer/getall')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },

    get_customeradmin_mypos(cb, errorCb){
        axios.post('/customerAdmin/pos/mine')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },

    get_pos_ofStatus(_status,cb, errorCb){
        axios.post('/customerAdmin/pos/ofStatus',{
            status:_status
        }).then(({ data }) => {
                    cb(data);
            }).catch(function(error){
                    errorCb(error);
            });
    },

    get_customeradmin_teampos(cb, errorCb){
        axios.post('/customerAdmin/pos/team')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },

    getCustomerAdmin_MonthlySummary(cb, errorCb){
        axios.post('/customerAdmin/pos/monthlySummary')
            .then(({ data }) => {
                    cb(data);
            }).catch(function(error){
                    errorCb(error);
                });
    },

    load_systemmanagement_info(cb, errorCb){
        axios.post('/customerAdmin/system/getManagementInfo')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },

};