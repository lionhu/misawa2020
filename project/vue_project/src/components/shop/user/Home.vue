<template>
<div class="container clearfix">


  <SideMenu></SideMenu>
  <div class="postcontent nobottommargin col_last">
    <div class="col_full">
      <span class="title">Language:</span>
      <el-select v-model="selectedLanguage" @change="ChangeLanguage" placeholder="请选择">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
    </div>
  </div>
</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'

  import SideMenu from "./parts/SideMenu.vue"

import {setToken,getToken} from "../../../lib/util.js"
  import { Radio,RadioGroup,RadioButton,Select,Option } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';

  export default {
    name: 'UserOrderDetail',
    components:{
      SideMenu,
      elSelect:Select,
      elOption:Option
    },
    data () {
      return {
        ME:null,
        options: [{
          value: 'jp',
          label: '日本語'
        }, {
          value: 'zh_CN',
          label: '中文'
        }],
        selectedLanguage:""
      }
    },
  computed: {
    // catalogue_products:function(){
    //   return this.$store.state.lotteryshop.catalogue_products
    // },
    // subcatalogues_now:function(){
    //   const catalogue = this.$store.state.lotteryshop.catalogue_now
    //   return catalogue.subcatalogues
    // },
  },
    mounted() {
      // this.loadOrderDetail()
    },
    methods: {
      ChangeLanguage(){
            axios.post('/api/userprofiles/update_myprofile_info/',{
                "language":this.selectedLanguage
            }).then((res)=>{
                if(res.data.result){
                   this.$i18n.locale = this.selectedLanguage;
                   setToken(this.selectedLanguage,"lang")
                }else{
                  throw new Error(res.data.message)
                }
            }).catch(function(error){
                Swal.showValidationMessage(
                  `Request failed: ${error}`
                )
            })
       }
    },
    watch: {
      '$route' (to, from) {
          // const to_id=to.params.slug
          // const from_id =from.params.slug
          // if(from_id !== to_id){
          //   this.loadOrderDetail(to_id)
          // }
      }
  }
};
</script>

<style lang="scss">
 .title{
  display:inline-block;
  width:100px;
}
</style>