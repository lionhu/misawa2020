import usersAPI from '../../api/users.js';
import { login, authorization } from '../../api/auth'
import { setToken,getToken } from '../../lib/util'

// initial state
const state = {
    ME:{},
    userlist:[]
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
              // console.log("response from get my profile")
              // console.log(res.data)
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
        // console.log("url")
        // console.log(url)

        axios.post(url,formData,config)
          .then((res)=>{
              // console.log(res.data)
              commit("set_mainImage",res.data)
          }).catch(function(error){
              console.log(error)
          })
    },
    login ({ commit }, { userName, password }) {
      return new Promise((resolve, reject) => {
        login({ userName, password }).then(res => {

          if (res.status === 200 && res.data.token) {
            // console.log(res.data)
            setToken(res.data.token,"jwt_token")
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
      commit("reset_ME")
    },
    getUserList({commit}){
      console.log("getUserList")
      return new Promise((resolve,reject)=>{
        usersAPI.getUserList(res=>{
          if(res.data.success){
            commit("setUserList",res.data.users)
            // resolve(res.data.users)
          }
        },err=>{})
      })
    }

};

const mutations = {
    setUserList(state,users){
      state.userlist=users
    },
    setUserStatus(state,data){
      const userIndex=state.userlist.findIndex(user =>user.id ==data.user_id)

        if(userIndex>-1){
          var user=state.userlist[userIndex]
          user.profile.online=data.status

          state.userlist.splice(userIndex,1,user)
        }
        // this.$set(this.tableData,users)
    },
    set_myprofile(state,data){
        state.profile=data;
        state.ME.username=data.user.username
        state.ME.email=data.user.email
        state.ME.language=data.language
        setToken(data.user.username,"username")
    },
    set_mainImage(state,data){
        state.profile.avatar=data.avatar
        state.profile.id_image=data.id_image
        state.profile.wechat=data.wechat
        state.profile.line=data.line
    },
    reset_ME(state){
        state.ME={}
        setToken("","username")
        setToken("","jwt_token")
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
