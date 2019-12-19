import usersAPI from '../../api/users.js';
import { login, loginSync,logoutSync,authorization } from '../../api/auth'
import { setToken,getToken } from '../../lib/util'

// initial state
const state = {
    ME:{
      username:"",
      email:"",
      language:""
    },
    rules: {},
    profile:{},
    accesstoken:""
};

// getters
const getters = {


};

// actions
const actions = {
    
    get_myprofile({ commit }) {
      return new Promise((resolve,reject)=>{
        usersAPI.get_myprofile(
            res => {
                if(res.data.result){
                    commit("set_myprofile",res.data.data);
                    resolve(res.data.data)
                }

            },err =>{
                console.log(err)
                reject()
            }
        );
      })
    },
    upload_mainImage({commit},{id,formData}){
        let config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        };
        const url='/api/userprofiles/'+id+'/upload_mainImage/';
        return new Promise((resolve,reject)=>{
            axios.post(url,formData,config)
            .then((res)=>{
                commit("set_mainImage",res.data)
                resolve(true)
            }).catch(function(error){
                console.log(error)
            })
        })

    },
  login ({ commit }, { userName, password }) {
    return new Promise((resolve, reject) => {
      login({ userName, password }).then(res => {

        if (res.status === 200 && res.data.token) {
          setToken(res.data.token,"jwt_token")
          commit("set_accesstoken",res.data.token)
          resolve(res.data.token)
        } else {
          reject(new Error('错误'))
        }
      }).catch(error => {
        reject(error)
      })
    })
  },
  authorization ({ commit },token) {
    return new Promise((resolve, reject) => {
      // console.log("store user modeule's authorization")
      authorization({token}).then(res => {
        if (parseInt(res.status) === 401) {
          reject(new Error('token error'))
        } else {
          // console.log(res.data.token)
          setToken(res.data.token)
          resolve()
        }
      }).catch(error => {
        reject(error)
      })
    })
  },
  logout ({ commit }) {
    // console.log("logout")
    // logoutSync().then(res=>{
    //         console.log(res)
            commit("reset_ME")
          // })
  }

};

const mutations = {
    set_myprofile(state,data){
        state.profile=data;
        state.ME.username=data.user.username
        state.ME.email=data.user.email
        state.ME.language=data.language
        setToken(data.user.username,"username")

        if(state.ME.language==""){
            setToken("zh_CN","lang");
            // this.$i18n.locale = "zh_CN";
        }else{
            setToken(state.ME.language,"lang");
            // this.$i18n.locale = this.ME.language;
        }
    },
    set_mainImage(state,data){
        state.profile.avatar=data.avatar
        state.profile.id_image=data.id_image
        state.profile.wechat=data.wechat
        state.profile.line=data.line
    },
    reset_ME(state){
        state.ME=null;
        setToken("","username");
        setToken("","jwt_token");
    },
    set_accesstoken(state,token){
        state.accesstoken=token
        window.axios.defaults.headers.Authorization=`jwt ` + token;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
