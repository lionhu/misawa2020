<template>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="ulogo">
           <a href="index.html">
            <!-- logo for regular state and mobile devices -->
            <span><b>{{ME.user.username}} </b></span>
          </a>
        </div>
         <div class="image" :style="'background-image:url('+ME.avatar+');background-size:cover;border:2px silver solid;border-radius:100%;height:80px;width:80px;margin:auto;'">
        </div>
        <div class="info">
          <router-link :to="{name:'profile',params:{}}"  class="link" data-toggle="tooltip" title="" data-original-title="Settings"><i class="ion ion-gear-b"></i></router-link>
          <a href="javascript:void(0)" @click="changeLang" class="link" data-toggle="tooltip" title="" data-original-title="Lanaguage">
            <i class="fa fa-language"></i>
          </a>
          <a href="javascript:void(0)" @click="logout" class="link" data-toggle="tooltip" title="" data-original-title="Logout">
            <i class="ion ion-power"></i>
          </a>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="nav-devider"></li>

        
        <li class="header nav-small-cap">
          <a class="text-center font-weight-600" href="/shop/" style="background-color:#6d6868">
            <i class="fa fa-shopping-bag text-success" aria-hidden="true"></i>
            LotteryShopping
          </a>
        </li>
        <li class="header nav-small-cap">
          <router-link class="text-center font-weight-600" :to="{ name: 'newdsorder'}" style="background-color:#964848">
            <i class="fa fa-legal" aria-hidden="true"></i>{{$t("m.dsorder")}}</router-link>
        </li>
        <li class="header nav-small-cap">PERSONAL</li>
        <li class="">
          <router-link :to="{ name: 'home', params: { }}">
            <i class="icon-home"></i> <span>Dashboard</span>
          </router-link>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="icon-graph"></i>
            <span v-text="$t('m.my_transactions')"></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li>
              <router-link :to="{ name: 'mydsorderlist', params: {type:'userdsorderlist' }}">{{$t('m.dsorder')}}</router-link>
            </li>
            <li>
              <router-link :to="{ name: 'myorderlist', params: {type:'userorderlist' }}">{{$t('m.order')}}</router-link>
            </li>
            <li><router-link :to="{ name: 'myofferlist', params: { }}">{{$t('m.offer')}}</router-link></li>
          </ul>
        </li>        

        <li class="header nav-small-cap"><i class="fas fa-balance-scale icon-warning"></i>{{$t("m.auction")}}</li>
        <li>
          <a href="/exrate/#/order/list">
            <i class="icon-refresh"></i> <span v-text="$t('m.transactions')"></span>
          </a>
        </li>
        <li>

          <a href="/exrate/#/order/new">
            <i class="icon-equalizer"></i>
            <span v-text="$t('m.new_order')"></span>
          </a>
        </li>


        <li class="header nav-small-cap"></li>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-info-circle"></i>
            <span v-text="$t('m.information')"></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li>
              <router-link :to="{ name: 'law', params: { }}">{{$t('m.law')}}</router-link>
            </li>
<!--             <li>
              <router-link :to="{ name: 'introduction', params: { }}">introduction</router-link>
            </li> -->
          </ul>
        </li>

      </ul>
    </section>
  </aside>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import {setToken,getToken} from "../lib/util.js"

  export default {
    name: 'sidemenu',
    components:{
    },
    data () {
      return {
        ME:{
           user:{
             username:""
           }
        }
      }
    },
    computed:{

    },
    mounted() {
      // this.load_profile()
      var profile = this.$store.state.users.profile
      if (profile){
        this.ME= profile
      }
       
    },
    methods: {
      async changeLang(){
        Swal.fire({
          title: this.$t("m.select_language"),
          input: 'select',
          inputOptions: {
            jp: '日本語<i class="fa fa-language"></i>',
            zh_CN: '中文'
          },
          showCancelButton: true,
          inputPlaceholder: this.$t("m.select_language"),
          confirmButtonText: 'OK',
          showLoaderOnConfirm: true,
          preConfirm: (language) => {
            return axios.post('/api/userprofiles/update_myprofile_info/',{
                "language":language
            }).then((res)=>{
                if(res.data.result){
                  return res.data.data
                }else{
                  throw new Error(res.data.message)
                }
            }).catch(function(error){
                Swal.showValidationMessage(
                  `Request failed: ${error}`
                )
            })
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            this.$i18n.locale = result.value.language;//关键语句
            Swal.fire(this.$t("m.selected_lanaguage")+result.value.language)
        })
      },
      logout(){
        this.$store.dispatch("users/logout")
        window.location.href="/member/#/login"
      }
    }
  };
</script>

<style lang="scss">
.icon-warning{
  color:rgb(251,174,28)
}
</style>