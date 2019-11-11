<template>
  <div>
    Admin Home
  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'

  import {setToken,getToken} from "../../lib/util.js"

  export default {
    name: 'admin_home',
    components:{
    },
    data () {
      return {
      }
    },
    computed:{
    },
    mounted() {
      this.checkIsAdmin()
    },
    methods: {
      checkIsAdmin(){
        const membership=this.$store.state.users.profile.membership

        if(membership !="ADMIN"){
          window.location.href="/exrate"
        }
        console.log("pass admin check")
      }
    },
    watch: {
    '$route' (to, from) {
        console.log(to)
        console.log(from)
    }
  }
  };
</script>

<style lang="scss">

</style>