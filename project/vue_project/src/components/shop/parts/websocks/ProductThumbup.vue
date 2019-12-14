<template>
<div></div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'


  export default {
    name: 'ProductThumbupWebsock',
    // props:["product"],
    data () {
      return {
        websocket:null,
        message:"",
        display_mode:"",
        message_type:"success"

      }
    },
    mounted() {
      this.init_websocker()
      console.log("init thumbup websocket")
    },
    methods: {
              init_websocker(){

             this.websocket = new ReconnectingWebSocket('wss://' + window.location.hostname +':3443/wss/shop/product/');
              this.websocket.onopen = this.websocketonopen;

　　　　　　　　this.websocket.onerror = this.websocketonerror;

　　　　　　　　this.websocket.onmessage = this.websocketonmessage; 
　　　　　　　　this.websocket.onclose = this.websocketclose;
        },
        websocketonopen(){
            console.log("WebSocket product thumbup channel连接成功");
        },
        websocketclose(e){
            console.log("connection product thumbup  closed (" + e.code + ")"); 
        },
        websocketonmessage(e){
              var data = JSON.parse(e.data);
              if(data.event=="CRUD"){
                this.event_CRUD(data)
              }

        },
        event_CRUD(data){
          data.message='<i class="fas fa-thumbs-up fa-2x"></i>'
          this.display_toast(data)

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
          console.log("WebSocket product thumbup 连接发生错误");
        },

    }
};
</script>


<style lang="scss">
</style>