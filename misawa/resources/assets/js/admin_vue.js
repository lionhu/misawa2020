
require('./bootstrap');

window.Vue = require('vue');

var app = new Vue({
    el: '#shop',
    data:{
        toAllMessage:"",
        labels:[],
        B_prices:[],
        profits:[],
        user:{
            name:"",
            client:{
                id:"0"
            },
            email:"",
            phone:""
        },
        roleid:""
    },
    methods:{
        addname:function (event) {
            this.names.push(this.newname);
        },
        sendmessage(){
            axios.post("/admin/sendmessage", {
                    "message": this.toAllMessage
                }).then(response=> {
                    // window.location.reload(true);
                // var removePO="#rowID_"+this.po.id;
                // $(removePO).remove();
            });
        },
        deleteUser(userid){
            console.log(userid);
            var userinfo="#user_"+userid;
            axios.post("/admin/user/delete", {
                "userid": userid
            }).then(response=> {
                $(userinfo).remove();
                window.location.reload(true);
            });
        },
        loadEditUserModal(userid){
            var vm=this;
            axios.post("/admin/user/getinfo", {
                "userid": userid
                }).then(response=> {
                    console.log(response.data.user);
                    vm.user=response.data.user;
                    vm.roleid=response.data.roleid;
                    console.log("inside post: "+vm.roleid);
            });
            // console.log(this.rolename);
        },
        updateUserInfo(){
            console.log("update info");
            var data={
                userid:this.user.id,
              clientid:this.user.client.id,
              roleid:this.roleid,
                email:this.user.email,
                phone:this.user.phone
            };
            axios.post("/admin/user/updateUserInfo", data)
                .then(response=> {
                console.log(response.data.user);
                window.location.reload(true);
            });
        }
    },
    mounted(){
    },
    computed:{
        reverseMessage(){
            return this.responseMessage.split('').reverse().join('');
        }
    },
    created(){
        console.log("before echo");
        Echo.channel('private-channel-admin')
            .listen("BrowseProductEvent",(e)=>{
                    var mssage="Someone is browsing product:"+e.product.name;
                    $('#adminMessage').attr("data-notify-msg",mssage)
                    .attr("data-notify-type","warning")
                    .attr("data-notify-position","bottom-full-width");
                    SEMICOLON.widget.notifications($('#adminMessage'));
            })
            .listen("SuperAdminMessageEvent",(e)=>{
                    var mssage="Message from superadmin:   "+e.message;
                    $('#adminMessage').attr("data-notify-msg",mssage)
                        .attr("data-notify-type","warning")
                        .attr("data-notify-position","bottom-full-width");
                    SEMICOLON.widget.notifications($('#adminMessage'));

            });
        }
});

$(".koun_user").on("click",function () {
    var userid=$(this).attr("userid");
    app.loadEditUserModal(userid);
    app.userid=userid;

});

function prepareArray(jsonstr) {

    var temp=jsonstr.substr(1,jsonstr.length-2);
    temp=temp.replace(/\"/g, "");
    return final=temp.split(",");
}

var final_labels=prepareArray($("#labels").html());
var final_client_B_price=prepareArray($("#client_B_price").html());
var final_lclient_profit=prepareArray($("#client_profit").html());


var month_date=prepareArray($("#month_date").html());
var month_po_count=prepareArray($("#month_po_count").html());
var month_R_total=prepareArray($("#month_R_total").html());
var month_B_total=prepareArray($("#month_B_total").html());
var month_O_total=prepareArray($("#month_O_total").html());



var barChartData = {
    labels: final_labels,
    datasets: [{
        label: 'Profit',
        type: 'line',
        fill: false,
        backgroundColor: window.chartColors.red,
        borderColor:window.chartColors.yellow,
        yAxisID: "y-axis-2",
        data: final_lclient_profit
    },{
        type: 'bar',
        label: 'Sales Amount',
        yAxisID: "y-axis-1",
        backgroundColor: window.chartColors.green,
        data: final_client_B_price
    }]

};

var monthlySummary = {
    labels: month_date,
    datasets: [
        {
            type: 'line',
            label: 'PO Count',
            yAxisID: "y-axis-2",
            fill: false,
            borderColor:window.chartColors.blue,
            backgroundColor: window.chartColors.blue,
            data: month_po_count
        },
        {
        type: 'bar',
        label: 'B_total',
        yAxisID: "y-axis-1",
            fill: false,
            borderColor:window.chartColors.green,
        backgroundColor: window.chartColors.red,
        data: month_B_total
    },{
        type: 'bar',
        label: 'O_total',
        yAxisID: "y-axis-1",
            fill: false,
            borderColor:window.chartColors.green,
        backgroundColor: window.chartColors.yellow,
        data: month_O_total
    }]
};

window.onload = function() {
    var ctx = document.getElementById("chart-0").getContext("2d");
    window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            title:{
                display:true,
                text:"Client Sales & Profit"
            },
            tooltips: {
                mode: 'index',
                intersect: true
            },
            scales: {
                yAxes: [{
                    type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    display: true,
                    position: "left",
                    id: "y-axis-1"
                }, {
                    type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    display: true,
                    position: "right",
                    id: "y-axis-2",
                    gridLines: {
                        drawOnChartArea: false
                    }
                }]
            }
        }
    });

    var month_ctx = document.getElementById("chart-1").getContext("2d");
    window.myBar = new Chart(month_ctx, {
        type: 'bar',
        data: monthlySummary,
        options: {
            responsive: true,
            title:{
                display:true,
                text:"Monthly Sales & Profit"
            },
            tooltips: {
                mode: 'index',
                intersect: true
            },
            scales: {
                yAxes: [{
                    type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    display: true,
                    position: "left",
                    id: "y-axis-1"
                }, {
                    type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    display: true,
                    position: "right",
                    id: "y-axis-2",
                    gridLines: {
                        drawOnChartArea: false
                    }
                }]
            }
        }
    });
};