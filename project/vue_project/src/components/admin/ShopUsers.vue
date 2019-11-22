<template>
  <div>

    <RealtimeAlert visible="true"></RealtimeAlert>

  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import { Table,TableColumn,Pagination,Form,FormItem } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';
  import RealtimeAlert from "./parts/ShopPublicAlert.vue"

  import {setToken,getToken} from "../../lib/util.js"

  export default {
    name: 'admin_home',
    inject:["reload"],
    components:{
      RealtimeAlert,
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