<template>

  <div class="box"  v-if="visible=='true'">
    <div class="box-header with-border">
      <h4 class="box-title">Public Message</h4>
    </div>
    <div class="box-footer">
        <div class="input-group">
          <input type="text" id="chat_message" v-model="message"  name="message" placeholder="Type Message to everyone ..." class="form-control" @keyup.enter="websocketsend"  >
              <span class="input-group-btn">
                <button id="btn_send" class="btn btn-success"　@click="websocketsend">Send</button>
              </span>
        </div>
    </div>
  </div>
</template>
<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'

  export default {
    name: 'char_alert',
    props:["visible"],
    components:{
    },
    data () {
      return {
        websocket:null,
        message:""
      }
    },
    computed:{
      ME(){
              return this.$store.state.users.ME;
      },
    },

    mounted() {
      this.init_websocker()

    },
    methods: {
        init_websocker(){
              var ws_scheme = window.location.protocol=='https'?"wss://www.exrate.world:8001/wss":"ws://www.exrate.world:8001/ws";

              // this.websocket = new ReconnectingWebSocket("ws://" + window.location.host +':8001/ws/systemchannel/public/');

              this.websocket = new ReconnectingWebSocket(ws_scheme + '/systemchannel/public/');
              this.websocket = new ReconnectingWebSocket('wss://www.exrate.world:8001/wss/systemchannel/public/');
              console.log(this.websocket )
              this.websocket.onopen = this.websocketonopen;

　　　　　　　　this.websocket.onerror = this.websocketonerror;

　　　　　　　　this.websocket.onmessage = this.websocketonmessage; 
　　　　　　　　this.websocket.onclose = this.websocketclose;
        },
        websocketonopen(){
            console.log("WebSocket public alert channel连接成功");
        },
        websocketclose(e){
            console.log("connection closed (" + e.code + ")"); 
        },
        websocketonmessage(e){
              var data = JSON.parse(e.data);
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              })
              // console.log(data)
              if(data.message_type=="userstatus"){
                this.notify_userStatus(data)
              }else{
                Toast.fire({
                  type: data.message_type,
                  html: "<a href='/'>"+data.message+"</a>"
                })
              }

        },
        websocketsend(){
          var message_params={
            'message': this.message,
            "message_type":"success"
          }
          this.websocket.send(JSON.stringify(message_params));
          this.message=""
　　　　}, 
        websocketonerror(){
          console.log("WebSocket连接发生错误");
        },
        notify_userStatus(data){
            this.$emit("userstatus",data);
        }
    }
};

</script>

<style>
</style>