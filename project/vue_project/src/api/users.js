/**
 * Mocking client-server processing
 */
// import axios from 'axios'
// import VueAxios from 'vue-axios'

export default {
    // User opertion related
    get_myprofile(cb, errorCb){
        axios.get('/api/userprofiles/get_myprofile/')
        .then((res)=>{
             cb(res);
        }).catch(function(error){
            errorCb(error);
        });
    },

    // Admin Users functions
    getUserList(cb, errorCb){
        axios.get('/api/userprofiles/Admin_UserList/')
        .then((res)=>{
             cb(res);
        }).catch(function(error){
            errorCb(error);
        });
    },
};