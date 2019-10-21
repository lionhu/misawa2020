<template>
  <div>
    Admin Orders
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
    created() {
    },
    methods: {
      checkIsAdmin(){
        const membership=this.$store.state.users.profile.membership

        if(membership !="Admin"){
          window.location.href="/exrate"
        }
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