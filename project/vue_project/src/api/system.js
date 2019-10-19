/**
 * Mocking client-server processing
 */
// import axios from 'axios'
// import VueAxios from 'vue-axios'

export default {
    // User opertion related
    // getMyToken(cb, errorCb){
    //     axios.post('/api-token-auth/',{
    //     'username':'root',
    //     'password':'Lionhu2008'
    //   })
    //     .then((res)=>{
    //         cb(res)
    //     }).catch(function(error){
    //         errorCb(error)
    //     })
    // },
    get_TodayRate(cb, errorCb){
        axios.get('/api/bankrate/todayrate/')
        .then((res)=>{
            console.log("fetch bankrate")
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },
    load_dashboard(cb, errorCb){
        axios.post('/api/order/Dashboard_summary/')
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },



};