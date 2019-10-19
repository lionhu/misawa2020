

$("#login-form").on("submit", function (event) {
    var username = $('#id_login').val();
    var password = $('#id_password').val();

    var data_ ={
        "username":username,
        "password":password
    }


    // event.preventDefault();
    $.ajax({
        type: "POST",
        url: "http://localhost/api-token-auth/",
        data: data_,
        success: function (data) {
            console.log("successfully goten token")
            localStorage.setItem('jwt_token', data.token);
            // window.location.href = "http://localhost/";
        },
        error: function () {
            window.location.href = "accounts/login/";
        }
    });
});