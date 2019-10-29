
export default {
    get_TodayRate(cb, errorCb){
        axios.get('/api/bankrate/todayrate/')
        .then((res)=>{
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
    load_systemEnvs(cb, errorCb){
        axios.post('/api/sysenv/d/')
        .then((res)=>{
            cb(res)
        }).catch(function(error){
            errorCb(error)
        })
    },



};