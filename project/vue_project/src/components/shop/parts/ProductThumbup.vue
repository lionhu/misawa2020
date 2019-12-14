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
      }
    },
    mounted() {
    },
    methods: {

    }
};
</script>


<style lang="scss">
</style>