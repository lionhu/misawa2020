
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//
// Vue.component('postproduct', require('./components/PostProduct.vue'));


var url_getClientList = "{{route('getClientList')}}";

const app= new Vue({
    el: '#shop',
    data:{
        clientlist:[],
        toAllMessage:"",
        sendmessage:""

    },
    filters:{
        currencyFormat: function (num) {
            var result = [ ], counter = 0;
            num = (num || 0).toString().split('');
            for (var i = num.length - 1; i >= 0; i--) {
                counter++;
                result.unshift(num[i]);
                if (!(counter % 3) && i != 0) { result.unshift(','); }
            }
            return result.join('')+"元";
        }
    },
    mounted(){
        var vm=this;
        axios.post("/admin/client/list").then(response => {
            console.log(response.data.clientlist);

    });
    },
    methods:{
    },
    computed:{
    },
    created(){

    }
});

$('.bt-sex').editable({
    prepend: "not selected",
    source: app.clientlist,
    display: function(value, sourceData) {
        // var colors = {"": "gray", 1: "green", 2: "blue"},
        //     elem = $.grep(sourceData, function(o){return o.value == value;});
        //
        // if(elem.length) {
        //     $(this).text(elem[0].text).css("color", colors[value]);
        // } else {
        //     $(this).empty();
        // }
    }
});