const baseURL = "nichiei.servies";

class HttpRequest {
  constructor(baseUrl = baseURL) {
    this.baseUrl = baseUrl;
  }
  create(url) {
    return new Promise(
      resolved => {
        console.log("create promise: " + url);
        resolved("hu")
      },
      rejected => {}
    );
  }
  distroy(url) {
    console.log("distroy: " + url);
  }
}
export default HttpRequest;



// import Request from "./testclass"

// .....
//     var request=new Request("url")
//     console.log(request.create("看看").then(
//       resolved=>{
//         console.log("return promise value: "+ resolved)
//       }
//     ),rejected=>{})