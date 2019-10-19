/**
 * Mocking client-server processing
 */
// import axios from 'axios'
// import VueAxios from 'vue-axios'

export default {
    // User opertion related
    get_myprofile(cb, errorCb){
    	// console.log(axios.defaults.headers)
        axios.get('/api/userprofiles/get_myprofile/',)
        .then((res)=>{
             cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },



};