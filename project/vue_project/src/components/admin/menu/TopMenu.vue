<template>
  <header class="main-header">
    <!-- Logo -->


    <a href="javascript:void(0)" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels 
    <b class="logo-mini">
      <span class="light-logo"><img src="{% static "img/logo-dark.png" %}" alt="logo"></span>
      <span class="dark-logo"><img src="{% static "img/logo-dark.png" %}" alt="logo"></span>
    </b> 
    -->
    
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
        <img src="/static/img/logo-dark.png" alt="logo" class="light-logo">
        <img src="/static/img/logo-dark.png" alt="logo" class="dark-logo">
    </span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <img src="/static/img/nichiei_text.svg" style="height:40px;" alt="logo" class="dark-logo mr-2"> 
    </nav>
  </header>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"

  export default {
    name: 'topmenu',
    components:{
    },
    data () {
      return {
      }
    },
    computed:{
      // token(){
      //         return this.$store.state.system.token;
      // },
    },
    created() {

      // this.$store.dispatch("users/get_myprofile").then(
      //     resolved=>{

      //       console.log("output from  get_myprofile, home vue");
      //     },rejectd=>{}
      //   )
    },
    methods: {
      
    }
  };
</script>

<style lang="scss">
</style>