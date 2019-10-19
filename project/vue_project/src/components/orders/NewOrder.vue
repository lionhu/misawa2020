<template>
  <div>
      <div class="box box-widget widget-user-3">
          <div class="widget-user-header bg-purple" style="background: url('') center center;">
          <div class="info-user">
          <h3 class="widget-user-username">中国银行</h3>
          <h6 class="widget-user-desc">{{todayrate.created}}</h6>
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

      <form class="form-horizontal" @submit.prevent="submitform">
          <div class="box box-solid bg-dark">
            <div class="box-header with-border">
              <h3 class="box-title">{{$t("m.exchange")}}</h3>

              <div class="box-tools pull-right">

              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-12">

                    <div class="form-group control-group row">
                      <div class="col-4 offset-2 controls">
                          <input name="group5" type="radio" @click="select_type_jpy" v-model="order.from_currency" id="radio_30" value="jpy" class="with-gap radio-col-white" checked>
                          <label for="radio_30"><span class="flag-icon flag-icon-jp fa-2x"></span><span style="margin-left:5px;">(万円)</span></label>
                      </div>
                      <div class="col-4 controls">
                          <input name="group5" type="radio" @click="select_type_rmb"  v-model="order.from_currency" id="radio_32" value="rmb" class="with-gap radio-col-red" checked>
                          <label for="radio_32"><span class="flag-icon flag-icon-cn fa-2x"></span><span style="margin-left:5px;">(元)</span></label>
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
                    <div class="form-group control-group row">
                      <label for="example-number-input" class="col-sm-2 col-form-label">{{$t("m.rate")}}</label>
                      <div class="col-sm-3 controls">
                          <h4>{{order.rate}}</h4>
                      </div>
                      <div class="col-sm-7 controls">
                          <div class="btn-group">
                            <button type="button" class="btn btn-warning" @click="adjust_rate(-0.1)">-0.1</button>
                            <button type="button" class="btn btn-warning"  @click="adjust_rate(-0.01)">-0.01</button>
                            <button type="button" class="btn btn-warning"  @click="adjust_rate(-0.001)">-0.001</button>
                            <button type="button" class="btn btn-success"  @click="adjust_rate(0.001)">+0.001</button>
                            <button type="button" class="btn btn-success"  @click="adjust_rate(0.01)">+0.01</button>
                            <button type="button" class="btn btn-success"  @click="adjust_rate(0.1)">+0.1</button>
                          </div>
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


  export default {
    name: 'neworder',
    components:{
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
          user_id:0,
          memo:"....",
          send_notification:false
        }
      }
    },
    computed:{
      // myprofile(){
      //     return this.$store.state.users.profile;
      // },
    },
    mounted() {
      this.ME=this.$store.state.users.profile;
      this.order.user_id= this.ME.user.id;
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
            this.$store.dispatch("orders/post_new_order",this.order).then(
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
      adjust_rate(val){
        var newval=parseFloat(this.order.rate)+val
        this.order.rate =Math.round(newval*10000)/10000
        this.caculate_price()
      },

      select_type_jpy(){
        this.order.from_currency="jpy";
        this.order.to_currency = "rmb";
        this.order.rate = this.todayrate.chao_in
        this.caculate_price()
      },
      select_type_rmb(){
        this.order.from_currency="rmb";
        this.order.to_currency = "jpy";
        this.order.rate = this.todayrate.hui_out

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