/**
 * Mocking client-server processing
 */


export default {

    get_mypos(cb, errorCb){
        axios.post('/po/all')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },


    load_member_systemmanagement_info(cb, errorCb){
        axios.post('/system/getManagementInfo')
            .then(({ data }) => {
            cb(data);
    }).catch(function(error){
            errorCb(error);
        });
    },
};