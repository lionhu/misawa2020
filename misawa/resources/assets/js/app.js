
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

// Vue.component('chatcomposer', require('./components/ChatComposer.vue'));
// Vue.component('notification', require('./components/Notification.vue'));
// Vue.component('task-list', require('./components/Tasks.vue'));
// Vue.component('task', require('./components/Task.vue'));
// Vue.component('tabs', require('./components/Tabs.vue'));
// Vue.component('tab', require('./components/Tab.vue'));


const app = new Vue({
    el: '#app',
    data:{
        serverMessage:[],
        responseMessage:"Hello world",
        names:["lionhu","kinghu"],
        newname:"input new one",
        isLoading:true
    },
    methods:{
        addname:function (event) {
            this.names.push(this.newname);
        }
    },
    mounted(){
        console.log("hello");
    },
    computed:{
        reverseMessage(){
            return this.responseMessage.split('').reverse().join('');
        }
    },
    created(){
        Echo.channel('PlaceNewOrder')
            .listen('OrderPlacedEvent',(e)=>{
                this.serverMessage.push("hello "+e.message);
            })
            .listen('eventTrigger',(e)=>{
                this.serverMessage.push("hello "+e.message);
            })
            .listen("private-channel-admin",(e)=>{
                console.log("recieve from channer-admin");
                console.log(e.message);
            });
    }
});
