
// window._ = require('lodash');
// const jQuery = require('jquery');
// const $ = jQuery;
// window.jQuery = jQuery;
// const bootstrap = require('bootstrap');

import tools from "./utils/tools.js"

window.axios = require('axios');
window.axios.defaults.headers.common = {
	'X-Requested-With': 'XMLHttpRequest',
    'Content-Type': 'application/json'
};

let jwt_token = localStorage.getItem("jwt_token");
// console.log("bootstrap jwt_token")


if(jwt_token ==""){
	window.axios.defaults.headers = {
		'X-CSRFToken': tools.GetCookie("csrftoken"),
	    'accept': 'application/json',
	    'Authorization': `jwt ` + jwt_token
	};
}else{
	window.axios.defaults.headers.Accept='application/json'
}




// 添加响应拦截器
// window.axios.interceptors.response.use(function (response) {
//     return response;
//   }, function (error) {
//   	var jwt_token = localStorage.getItem("jwt_token");
//   	if(jwt_token){
//   		localStorage.removeItem("jwt_token")
//   	}
//   	var loginUrl="http://"+window.location.host+"/vue/#/"
//   	console.log(localStorage.getItem("jwt_token"))
//   	window.location.href=loginUrl
//     return Promise.reject(error);
//   });



