<template>
  <div>
    <div class="row">
      <div class="col-xl-12 col-md-6" v-for="summary in active_ordersummaries">
            <div class="box box-body bg-hexagons-white pull-up bg-dark">
              <div class="widget-user-image text-center" style="left: 58%;">
                <span class="flag-icon flag-icon-jp fa-3x" v-if="summary.from_currency=='jpy'"></span> <!---->
                <span class="flag-icon flag-icon-cn fa-3x" v-if="summary.from_currency=='rmb'"></span> <!---->
              </div>
              <div class="mt-5 flexbox flex-justified">
                <div class="border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{summary.count}}</h5> 
                    <span class="description-text">ORDERS</span>
                  </div>
                </div>
                <div class="border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{summary.sum|currency}}</h5>
                    <span class="description-text">AMOUNT</span>
                  </div>
                </div>
                <div class="border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{summary.max_rate}}</h5>
                    <span class="description-text">MAX RATE</span>
                  </div>
                </div>
                <div>
                  <div class="description-block">
                    <h5 class="description-header">{{summary.min_rate}}</h5>
                    <span class="description-text">MIN RATE</span>
                  </div>
                </div>
              </div>
            </div>
      </div>
    </div>
    <span v-text="$t('m.music')"></span>
    <button type="button" class="btn btn-block btn-primary btn-sm"  @click="changeLang">primary</button>

  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'

  import {setToken,getToken} from "../lib/util.js"

  export default {
    name: 'dashboard',
    components:{
    },
    data () {
      return {
        active_ordersummaries: {},
      }
    },
    computed:{
      // token(){
      //         return this.$store.state.system.token;
      // },
    },
    created() {
    },
    methods: {
      async changeLang(){
        /* inputOptions can be an object or Promise */
        const { value: lang } = await Swal.fire({
          title: '<strong style="color:red;">Select Lanaguage</strong>',
          input: 'select',
          inputOptions: {
            jp: '日本語',
            zh_CN: '中文',
            en_US: 'English'
          },
          inputPlaceholder: 'Select a fruit',
          showCancelButton: true,
          // inputValidator: (value) => {
            // console.log(value)
            // return new Promise((resolve) => {
            //   if (value === 'oranges') {
            //     resolve()
            //   } else {
            //     resolve('You need to select oranges :)')
            //   }
            // })
          // }
        })

        if (lang) {
          setToken(lang,"lang");
          this.$i18n.locale = lang;//关键语句
        }
    },
  }
}
</script>

<style lang="scss">
.item-group {
  color: white
}
</style>