var jwt_token = localStorage.getItem('jwt_token');
data = {
    "token": jwt_token
};
$.ajax({
    type: "POST",
    url: "http://localhost/api-token-refresh/",

    data: data,
    success: function (data) {
        localStorage.setItem('jwt_token', data.token);
        $.ajax({
            type: "GET",
            url: "http://localhost/api/music/",
            headers: {
                "Authorization": "JWT" + " " + localStorage.getItem('jwt_token')
            },
            success: function (data) {
                var result = "";
                for (var i in data) {
                    result += data[i].id + ", " + data[i].song + " , " + data[i].singer + "-----";
                }
                $("#result").text(result).css('color', 'blue');
            },
            error: function (data) {
                var result = "please login " + data.responseText;
                $("#result").text(result).css('color', 'red');
            }
            // error: function () {
            //     window.location.href = "http://localhost/accounts/login/";
            // }
        });
    },
    error: function (data) {
        console.log("error in refresh token")
        // window.location.href = "accounts/login/";

        var result = "please login " + data.responseText;
        $("#result").text(result).css('color', 'red');
    }
});