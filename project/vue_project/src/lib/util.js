  import Swal from 'sweetalert2'
  
export const setTitle = (title) => {
  window.document.title = title || 'admin'
}

export const setToken = (token, tokenName = 'jwt_token') => {
  localStorage.setItem(tokenName, token)
  // if (token !==""){
  //   window.axios.defaults.headers.Authorization=`jwt ` + jwt_token
  // }
}

export const getToken = (tokenName = 'jwt_token') => {
  return localStorage.getItem(tokenName)
}


export const removeToken = (tokenName = 'jwt_token') => {
  localStorage.removeItem(tokenName)
}

export const showNotification = (message = '',type="success") => {
		const Toast = Swal.mixin({
		  toast: true,
		  position: 'top-end',
		  showConfirmButton: false,
		  timer: 3000
		})

		Toast.fire({
		  type: type,
		  title: message
		})

}

export const FetchAddressByPostcode = (Postcode = '') => {
	return new Promise((resolve,reject)=>{
        var key="AIzaSyBgFQF5WNfpGu1hlzwhtm8pQknGx8YG3uc"
        $.ajax({
          type : 'get',
          url : 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBgFQF5WNfpGu1hlzwhtm8pQknGx8YG3uc',
          crossDomain : true,
          dataType : 'json',
          data : {
            address : Postcode,
            language : 'ja',
            sensor : false
          },
          success : function(resp){
            var res={
              "result":true,
              "address":{
                "state":"",
                "city":"",
                "street_address1":""
              },
              "message":""
            }
            if(resp.status == "OK"){
              // APIのレスポンスから住所情報を取得
              var obj = resp.results[0].address_components;
              if (obj.length < 5) {
                res.message='正しい郵便番号を入力してください';
                res.result=false
                reject(res)
              }

              //$('#country').val(obj[4]['long_name']); // 国
              res.address.state=obj[5]['long_name']+obj[4]['long_name']; // 都道府県
              res.address.city=obj[3]['long_name'];  // 市区町村
              res.address.street_address1=obj[2]['long_name']+obj[1]['long_name']; // 番地
              res.result=true
              res.message="Successfully fetched"

              resolve(res);

            }else{
              res.message='住所情報が取得できませんでした';
              res.result=false
              reject(res)
            }

          }
        });

	})

}



