//lib.js

function common_a(str){
  console.log("this is common "+str)
}

export const GetProfile = (str) => {
  common_a("get profile "+ str)
  return str;
};

export const GetOrder = (str) => {
  common_a(" GetOrder "+str)
  return str;
};

// import {GetProfile,GetOrder} from "lib.js"
// GetProfile()






//main.js
export default {
  common_fun(str){
    console.log("inside common: "+str)
  },
  GetProfile({str}, cb, errorCb) {
    console.log(str);
    this.common_fun(str)
  }
};

// import APIs from "main.js"
// APIs.GetProfile()
