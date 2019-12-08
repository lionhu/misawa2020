<template>
  <div class="groupon" v-if="product.hasGroupon">
    <span class="fright leftmargin-10">{{product.groupon_applicants_count}} / {{product.groupon_target}}</span>
    <span class="fright text-info"><i class="fas fa-thumbs-up fa-2x"></i></span>
  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'


  export default {
    name: 'product_thumbup',
    props:["product"],
    data () {
      return {
        websocket:null,
        message:"hello",
        display_mode:"",
        message_type:"success"

      }
    },
    mounted() {
      this.init_websocker()
    },
    methods: {
              init_websocker(){

             this.websocket = new ReconnectingWebSocket('wss://' + window.location.hostname +':3443/wss/shop/product/');
              // console.log(this.websocket )
              this.websocket.onopen = this.websocketonopen;

　　　　　　　　this.websocket.onerror = this.websocketonerror;

　　　　　　　　this.websocket.onmessage = this.websocketonmessage; 
　　　　　　　　this.websocket.onclose = this.websocketclose;
        },
        websocketonopen(){
            console.log("WebSocket product channel连接成功");
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


<style lang="scss">
</style>