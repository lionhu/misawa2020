<template>
<!-- DIRECT CHAT DANGER -->
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
  <!-- /.box-header -->
  <div class="box-body">
    <!-- Conversations are loaded here -->

    <!-- Conversations are loaded here -->
    <div class="direct-chat-messages" id="direct-chat">
        <div class="direct-chat-msg" :class="{'right':message.user.username == ME.username}" v-for="message in messages">
          <div class="direct-chat-info clearfix" v-if="message.user.username == ME.username">
            <span class="direct-chat-name pull-left">{{message.user.username}}</span>
            <span class="direct-chat-timestamp pull-right">{{message.created}} </span>
          </div>


          <div class="direct-chat-info clearfix" v-if="message.user.username != ME.username">
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
        <input type="text" id="chat_message" name="message" placeholder="Type Message ..." class="form-control">
            <span class="input-group-btn">
              <button id="btn_send" class="btn btn-success">Send</button>
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
    props:["room_name"],
    components:{
    },
    data () {
      return {
        messages:[]
      }
    },
    computed:{
      ME(){
              return this.$store.state.users.ME;
      },
      // token(){
      //         return this.$store.state.system.token;
      // },
    },

    mounted() {
      this.init_websocker()
      this.load_chathistory()
    },
    methods: {
        utf16to8(str) { //二维码编码前把字符串转换成UTF-8
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
        },
        init_websocker(){
              var vm=this
              var roomName = this.room_name;
              var chatSocket = new ReconnectingWebSocket('ws://' + window.location.host +'/ws/vuechat/lionhu/');

              console.log(chatSocket)
              // console.log(JSON.parse({{chat_messages}}))
              chatSocket.onmessage = function (e) {
                console.log("inside")
                  var data = JSON.parse(e.data);
                  var newmessage={}
                  newmessage.user=data.message.user
                  newmessage.created=data.message.created
                  newmessage.message=data.message.message


                  vm.messages.push(newmessage)

                  $('#direct-chat').scrollTop($('#direct-chat')[0].scrollHeight);
                  };
                  chatSocket.onclose = function (e) {
                      console.error('Chat socket closed unexpectedly');
                  };
                  $("#chat_message").focus();
                  $("#chat_message").keyup(function(e){
                    if (e.keyCode === 13) {  // enter, return
                          $("#btn_send").click();
                      }
                  });
                  $("#btn_send").click(function() {
                    var message = $('#chat_message').val();
                    chatSocket.send(JSON.stringify({
                          'message': message
                    }));
                    $('#chat_message').val('');
                  });
        },
        load_chathistory(){
          axios.get('/api/chat/')
            .then((res)=>{
                 this.messages=res.data
            });
        }
    }
};

</script>

<style>
</style>