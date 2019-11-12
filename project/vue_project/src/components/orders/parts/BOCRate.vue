<template>
      <div class="box box-widget widget-user-3">
          <div class="widget-user-header bg-purple" style="background: url('') center center;">
          <div class="info-user">
          <h3 class="widget-user-username">中国银行</h3>
          <h6 class="widget-user-desc">{{todayrate.time}}@{{todayrate.day}}</h6>
              </div>
              <div class="widget-user-image clearfix">
                <img class="rounded-circle" src="/static/img/boc.png" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav d-block nav-stacked">
                <li class="nav-item"><a href="#" class="nav-link">{{$t("m.chao_in")}} <span class="pull-right badge bg-blue">{{todayrate.chao_in}}</span></a></li>
                <li class="nav-item"><a href="#" class="nav-link">{{$t("m.chao_out")}} <span class="pull-right badge bg-green">{{todayrate.chao_out}}</span></a></li>
                <li class="nav-item"><a href="#" class="nav-link">{{$t("m.hui_in")}} <span class="pull-right badge bg-yellow">{{todayrate.hui_in}}</span></a></li>
                <li class="nav-item"><a href="#" class="nav-link">{{$t("m.hui_out")}} <span class="pull-right badge bg-red">{{todayrate.hui_out}}</span></a></li>
              </ul>
            </div>
          </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'


  export default {
    name: 'neworder',
    components:{
    },
    inject:["reload"],
    data () {
      return {
        todayrate:{},
      }
    },
    computed:{

    },
    mounted() {
      this.$store.dispatch("system/get_todayrate").then(
        resolve=>{
          this.todayrate=resolve.todayrate
          this.reload()
        },reject=>{})
    },
    methods: {
    }
};

</script>

<style lang="scss">
</style>