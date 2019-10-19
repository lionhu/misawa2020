  import Swal from 'sweetalert2'
  
export const setTitle = (title) => {
  window.document.title = title || 'admin'
}

export const setToken = (token, tokenName = 'jwt_token') => {
  localStorage.setItem(tokenName, token)
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
		var send_url = "http://zipcloud.ibsnet.co.jp/api/search";
        $.ajax({
            type: "GET",
            cache: false,
            data: {
            	zipcode:Postcode
            },
            url: send_url,
            dataType: "jsonp",
            success: function (res) {
                //結果によって処理を振り分ける
                if (res.status == 200) {
                    resolve({result:true,data:res.results[0]})
                    
                } else {
                    reject({result:false,data:{}})
 
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
            }
        });
	})

}



