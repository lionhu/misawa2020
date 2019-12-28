<template>

</template>
<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import {DisplayToast,DisplayModal} from "../../../../lib/util.js"
 
  export default {
    name: 'rental_event',
    props:["visible","product_slug"],
    components:{
    },
    data () {
      return {
        websocket:null,
        message:"rentalhouse",
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

    },
    methods: {
        init_websocker(){
             this.websocket = new ReconnectingWebSocket('wss://' + window.location.hostname +':3443/wss/rentalhouse/'+this.$route.params.slug+'/');
              // console.log(this.websocket.url )
              this.websocket.onopen = this.websocketonopen;

　　　　　　　　this.websocket.onerror = this.websocketonerror;

　　　　　　　　this.websocket.onmessage = this.websocketonmessage; 
　　　　　　　　this.websocket.onclose = this.websocketclose;
        },
        websocketonopen(){
            console.log("WebSocket public RentEvent Alert channel连接成功");
        },
        websocketclose(e){
            console.log("connection closed (" + e.code + ")"); 
        },
        websocketonmessage(e){
              var data = JSON.parse(e.data);
              // console.log(data)
              if(data.display_mode=="toast"){
                  DisplayToast(data)
              }else{
                  DisplayModal(data)
              }
              this.$emit("rentalhistory",data)
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
    }
};

</script>

<style>
</style>