// import axios from "axios";

export const getUserInfo = ({ userId }) => {
  return axios.request({
    url: '/api/userprofiles/get_myprofile/',
    method: 'post',
    data: {
      userId
    }
  })
}

export const login = ({ userName, password }) => {
  var params={
      "username":userName,
      "password":password
    }
  return axios.request({
    url: '/login/',
    method: 'post',
    data: params
  })
}

export const authorization = ({token}) => {
  // console.log("api authorization")
  // var token = getToken()
  // console.log(token)
  return axios.request({
    url: '/api-token-verify/',
    method: 'post',
    data:{
      "token":token
    }
  })
}