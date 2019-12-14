<template>
  <div>
      <BOCRate></BOCRate>
      <form class="form-horizontal" @submit.prevent="submitform">
          <div class="box box-solid bg-dark">
            <div class="box-header with-border">
              <h3 class="box-title">{{$t("m.exchange")}}</h3>
              <h3 class="box-title pull-right text-warning">
                  <router-link :to="{ name: 'mydsorderlist'}"><i class="fa fa-fw fa-list"></i></router-link>
              </h3>
              <div class="box-tools pull-right">

              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-12">

                    <div class="form-group control-group row">
                      <div class="col-6" v-if="systemEnvs.market_jr">
                        <a class="box box-link-shadow text-center pull-up" href="javascript:void(0)" @click="select_type_jpy">
                          <div class="box-body py-25 bg-light">
                            <p class="font-weight-600"><span class="flag-icon flag-icon-jp fa-2x"></span><i class="fa fa-fw fa-arrow-circle-right"></i><span class="flag-icon flag-icon-cn fa-2x"></span></p>
                          </div>
                          <div class="box-body">
                            <p class="font-size-40 text-cyan">{{traderate_jr}}
                            </p>
                          </div>
                        </a>
                      </div>
                      <div class="col-6"  v-if="systemEnvs.market_rj">
                        <a class="box box-link-shadow text-center pull-up" href="javascript:void(0)" @click="select_type_rmb">
                          <div class="box-body py-25 bg-light">
                            <p class="font-weight-600"><span class="flag-icon flag-icon-cn fa-2x"></span><i class="fa fa-fw fa-arrow-circle-right"></i><span class="flag-icon flag-icon-jp fa-2x"></span></p>
                          </div>
                          <div class="box-body">
                            <p class="font-size-40 text-pink">{{traderate_rj}}
                            </p>
                          </div>
                        </a>
                      </div>

                    </div>

                    <div class="form-group control-group row">
                      <label for="example-number-input" class="col-sm-2 col-form-label">
                        {{$t("m.amount")}}
                      </label>
                      <div class="col-sm-10 controls">
                          <input class="form-control" type="number" @change="caculate_price" v-model="order.amount" name="amount" id="amount" min="10" required>
                          <p class="help-block">
                            <span v-if="order.from_currency=='jpy'">{{$t("m.amount_jp")}}</span>
                            <span v-if="order.from_currency=='rmb'">{{$t("m.amount_cn")}}</span>
                          </p>

                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="example-date-input" class="col-sm-2 col-form-label">{{$t("m.due")}}
                      </label>
                      <div class="col-sm-10">
                          <input class="form-control" @blur="confirm_selectDate" type="date" v-model="order.due_at" id="example-date-input">
                          <p class="help-block">(例：2019-8-29)</p>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>{{$t("m.memo")}}</label>
                      <textarea class="form-control" rows="3" v-model="order.memo"></textarea>
                    </div>
                    <div class="box box-body pull-up bg-primary bg-deathstar-white">
                      <div class="flexbox">

                        <span class="flag-icon flag-icon-jp fa-2x" v-if="order.from_currency=='rmb'"></span>
                        <span class="flag-icon flag-icon-cn fa-2x" v-if="order.from_currency=='jpy'"></span>
                        <span class="font-size-40 font-weight-200">{{order.price |currency}}
                          <span style="margin-right:5px;">{{ order.from_currency=='rmb'?"円":"元"}}</span>
                        </span>
                      </div>
                      <div class="text-right font-size-24">
                        {{$t("m.afterchange")}}
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="checkbox" id="notify_order" class="filled-in chk-col-orange" v-model="order.send_notification">
                      <label for="notify_order">{{$t("m.send_notification")}}</label>
                      <p class="help-block">{{$t('m.send_notification_introduction')}}</p>
                    </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">{{$t("m.submit")}}</button>
            </div>
          </div>
      </form>
  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import BOCRate from "./parts/BOCRate.vue"

  export default {
    name: 'neworder',
    components:{
      BOCRate
    },
    inject:["reload"],
    data () {
      return {
        ME:null,
        todayrate:{},
        order:{
          amount:10,
          rate:0,
          from_currency:"jpy",
          to_currency:"rmb",
          due_at:"",
          price:6200,
          user:0,
          memo:"....",
          send_notification:false
        }
      }
    },
    computed:{
      systemEnvs(){
          return this.$store.state.system.systemEnvs.params.fixed_rate;
      },
      traderate_rj(){
          var rj=parseFloat(this.systemEnvs.offset_rj)+parseFloat(this.todayrate.hui_out)
          return rj.toFixed(4);
      },
      traderate_jr(){
          var jr=parseFloat(this.systemEnvs.offset_jr)+parseFloat(this.todayrate.chao_in)
          return jr.toFixed(4);
      }
    },
    mounted() {
      this.ME=this.$store.state.users.profile;
      this.order.user= this.ME.user.id;
      this.$store.dispatch("system/get_systemEnvs")
      this.$store.dispatch("system/get_todayrate").then(
        resolve=>{
          this.todayrate=resolve.todayrate
          this.select_type_jpy()
          this.reload()
        },reject=>{})
    },
    methods: {
      submitform(){
        if (this.confirm_selectDate()){
            this.order.due_at +=" 23:59:59"
            this.$store.dispatch("orders/post_new_dsorder",this.order).then(
              resolve=>{
                Swal.fire({
                  type: 'success',
                  title: 'Congratulation!',
                  text: 'You have successfully placed a new order!'
                })
              },reject=>{})
        }
      },
      confirm_selectDate(){
        var ds = new Date()
        var selectds=new Date(this.order.due_at)

        if (this.order.due_at =="" || selectds < ds){
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: '选择将来的日期作为有效期!'
          })
          this.order.due_at=""
          return false
        }else{
          return true
        }
      },
      select_type_jpy(){
        this.order.from_currency="jpy";
        this.order.to_currency = "rmb";
        this.order.rate = this.traderate_jr
        this.caculate_price()
      },
      select_type_rmb(){
        this.order.from_currency="rmb";
        this.order.to_currency = "jpy";
        this.order.rate = this.traderate_rj

        this.caculate_price()
      },
      caculate_price(){
        if (this.order.from_currency =="jpy"){
            if(this.order.amount>1000){
              this.order.amount=1000;
              Swal.fire({
                type:"error",
                title:"Oops...",
                text:this.$t("m.amount_tradelimit_jp")
              })
            }

            this.order.price =  parseInt(Math.round(this.order.amount*this.order.rate*100000)/1000)
        }else{
            if(this.order.amount>600000){
              this.order.amount=600000;
              Swal.fire({
                type:"error",
                title:"Oops...",
                text:this.$t("m.amount_tradelimit_cn")
              })
            }

            this.order.price = Math.round(this.order.amount/this.order.rate*100)

        }
      }
    }
};

</script>

<style lang="scss">
</style>