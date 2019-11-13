<template>
  <div class="box direct-chat direct-chat-success">
    <div class="box-header with-border">
      <h4 class="box-title">Direct Chat</h4>
       <ul class="box-controls pull-right">
          <li><a class="box-btn-close" href="#"></a></li>
          <li><a class="box-btn-slide" href="#"></a></li>   
          <li><a class="box-btn-fullscreen" href="#"></a></li>
           <li><button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
          <i class="fa fa-comments"></i></button></li>
           <li><span data-toggle="tooltip" title="1 New Messages" class="badge bg-success">1</span></li>
        </ul>
    </div>
    <div class="box-body">
      <div class="direct-chat-messages" id="direct-chat">
          <div class="direct-chat-msg" :class="{'right':message.user.username == username}" v-for="message in messages">
            <div class="direct-chat-info clearfix" v-if="message.user.username == username">
              <span class="direct-chat-name pull-left">{{message.user.username}}</span>
              <span class="direct-chat-timestamp pull-right">{{message.created}} </span>
            </div>


            <div class="direct-chat-info clearfix" v-if="message.user.username != username">
              <span class="direct-chat-name pull-right">{{message.user.username}}</span>
              <span class="direct-chat-timestamp pull-left">{{message.created}}</span>
            </div>

            <img class="direct-chat-img" :src="message.user.profile.avatar">
            <div class="direct-chat-text">
              {{ message.message}}
            </div>
          </div>

    </div>

      <!-- Contacts are loaded here -->
      <div class="direct-chat-contacts">
        <ul class="contacts-list">
          <li>
            <a href="#">
              <img class="contacts-list-img" src="/images/user1-128x128.jpg" alt="User Image">

              <div class="contacts-list-info">
                    <span class="contacts-list-name">
                      Pavan kumar
                      <small class="contacts-list-date pull-right">April 14, 2017</small>
                    </span>
                <span class="contacts-list-email">info@.multipurpose.com</span>
              </div>
              <!-- /.contacts-list-info -->
            </a>
          </li>
          <!-- End Contact Item -->
          <li>
            <a href="#">
              <img class="contacts-list-img" src="/images/user7-128x128.jpg" alt="User Image">

              <div class="contacts-list-info">
                    <span class="contacts-list-name">
                      Sonu Sud
                      <small class="contacts-list-date pull-right">March 14, 2017</small>
                    </span>
                <span class="contacts-list-email">sonu@gmail.com</span>
              </div>
              <!-- /.contacts-list-info -->
            </a>
          </li>
          <!-- End Contact Item -->
        </ul>
        <!-- /.contatcts-list -->
      </div>
      <!-- /.direct-chat-pane -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <div class="input-group">
          <input type="text" id="chat_message" v-model="message" name="message" placeholder="Type Message ..." class="form-control"  @keyup.enter="websocketsend" >
              <span class="input-group-btn">
                <button id="btn_send" class="btn btn-success" @click="websocketsend">Send</button>
              </span>
        </div>
    </div>
    <!-- /.box-footer-->
  </div>
  <!--/.direct-chat -->
</template>

<!-- <script type="text/javascript" src='js/reconnecting-websocket.min.js'></script>
 -->
<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  // import Swal from 'sweetalert2'
  // import {setToken,getToken} from "../lib/util.js"

  export default {
    name: 'chat',
    props:["username"],
    components:{
    },
    data () {
      return {
        messages:[],
        websocket:null,
        message:""
      }
    },
    computed:{
      // ME(){
      //         return this.$store.state.users.ME;
      // },
      // token(){
      //         return this.$store.state.system.token;
      // },
    },

    mounted() {
      // this.init_websocker()
      // this.load_chathistory()
    },    
    watch: {
      username:function (to, from) {
          this.init_websocker(to)
          this.load_chathistory(to)
      }
    },
    methods: {
        init_websocker(username){
              // var ws_scheme = window.location.protocol=='https'?"wss://www.exrate.world:8001/wss/":"ws://www.exrate.world:8001/ws";

              // this.websocket = new ReconnectingWebSocket('wss://www.exrate.world:8001/wss/vuechat/'+username+'/');

              this.websocket = new ReconnectingWebSocket('ws://' + window.location.host +':8001/ws/vuechat/'+username+'/');
              this.websocket.onopen = this.websocketonopen;

　　　　　　　　this.websocket.onerror = this.websocketonerror;

　　　　　　　　this.websocket.onmessage = this.websocketonmessage; 
　　　　　　　　this.websocket.onclose = this.websocketclose;
        },
        websocketonopen(){
            console.log("WebSocket连接成功");
        },
        websocketclose(e){
            console.log("connection closed (" + e.code + ")"); 
        },
        websocketonmessage(e){
              var data = JSON.parse(e.data);
              var newmessage={}
              newmessage.user=data.message.user
              newmessage.created=data.message.created
              newmessage.message=data.message.message
              this.messages.push(newmessage)

              $('#direct-chat').scrollTop($('#direct-chat')[0].scrollHeight);
        },
        websocketsend(){
          console.log("new way")
          var message_params={
            'message': this.message
          }
          console.log(message_params)
          this.websocket.send(JSON.stringify(message_params));
          this.message="";
　　　　}, 
        websocketonerror(){
          console.log("WebSocket连接发生错误");
        },
        load_chathistory(username){
          axios.post('/api/chat/chatlist/',{
            "username":username
          }).then((res)=>{
                 this.messages=res.data.messages
            });
        }
    }
};

</script>

<style>
</style>