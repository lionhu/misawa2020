<template lang="html">
    <div class="chat-composer">
        <input type="text" placeholder="start typing your message" @keyup.enter="sendMessage" v-model="messageText" id="message">
        <button class="btn btn-primary" @click="sendMessage">Send</button>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                messageText:"default"
            }
        },
        methods:{
            sendMessage(){
                this.$emit("messagesent",{
                    message:this.messageText,
                    user:"lionhu"
                });
                console.log("input:"+this.messageText);
                this.messageText="";
            }
        }
    }
</script>

<style lang="css">
    .chat-composer{
        display: flex;
    }

    .chat-composer input{
        flex:1 auto;
    }

    .chat-composer button{
        -webkit-border-radius:0;
        -moz-border-radius:0;
        border-radius:0;
    }

</style>