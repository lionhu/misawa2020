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

export const StandardDate = (value = '') => {
    if(value =="" || value ==undefined ){
      return "";
    }

    var time=value.split("T")[0];
    return time;
}

export const DisplayToast = (data) => {
                const Toast = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 2000
                    })
                    // console.log(data)
                Toast.fire({
                  type: data.message_type,
                  html: "<a href='/'>"+data.message+"</a>"
                })
}
export const DisplayModal = (data) => {
                // console.log(data)
                let timerInterval
                Swal.fire({
                  title: 'New reservation made!',
                  html: "<b></b><br> "+data.now_time,
                  timer: 2000,
                  // timerProgressBar: true,
                  onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                      Swal.getContent().querySelector('b')
                        .textContent = Swal.getTimerLeft()
                    }, 100)
                  },
                  onClose: () => {
                    clearInterval(timerInterval)
                  }
                }).then((result) => {
                  if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.timer
                  ) {
                    console.log('I was closed by the timer') // eslint-disable-line
                  }
                })
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
		  html: message
		})

}

export const  utf16to8= (str = '') =>{ //二维码编码前把字符串转换成UTF-8
        var out, i, len, c; 
            out = ""; 
            len = str.length; 
        for(i = 0; i < len; i++) { 
            c = str.charCodeAt(i); 
            if ((c >= 0x0001) && (c <= 0x007F)) { 
                out += str.charAt(i); 
            } else if (c > 0x07FF) { 
                out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F)); 
                out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F)); 
                out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F)); 
            } else { 
                out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F)); 
                out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F)); 
            } 
        } 
        return out; 
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



