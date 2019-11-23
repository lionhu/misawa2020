<template>

  <div class="box"  v-if="visible=='true'">
    <div class="box-header with-border">
      <h4 class="box-title">Public Message</h4>
    </div>
    <div class="demo-radio-button">
		<input name="display_mode" type="radio" id="radio_1" value="toast" v-model="display_mode">
		<label for="radio_1">Toast</label>
		<input name="display_mode" type="radio" id="radio_2" value="modal" v-model="display_mode">
		<label for="radio_2">Modal</label>
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
        message:"hello",
        display_mode:"",
        message_type:"success"
      }
    },
    computed:{
      ME(){
              return this.$store.state.users.ME;
      },
    },

    mounted() {
      this.init_websocker()
      console.log("shop init_websocker")
    },
    methods: {
        init_websocker(){

             this.websocket = new ReconnectingWebSocket('wss://' + window.location.hostname +':3443/wss/shop/public/');
              // console.log(this.websocket )
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
              // console.log(e)
              var data = JSON.parse(e.data);
              
              if(data.message_type=="userstatus"){
                this.notify_userStatus(data)
              }else{
                if(data.display_mode=="toast"){
                    this.display_toast(data)
                }else{
                    this.display_modal(data)
                }
              }

        },
        display_toast(data){
                const Toast = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000
                    })
                    // console.log(data)
                Toast.fire({
                  type: data.message_type,
                  html: "<a href='/'>"+data.message+"</a>"
                })
        },
        display_modal(data){
                let timerInterval
                Swal.fire({
                  title: 'Message from Admin',
                  html: "<b></b><br> "+data.message,
                  timer: 3000,
                  timerProgressBar: true,
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
        },
        websocketsend(){
          if (this.message !=""){
              var message_params={
                'message': this.message,
                "message_type":this.message_type,
                "display_mode":this.display_mode
              }
              this.websocket.send(JSON.stringify(message_params));
              this.message=""
          }

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