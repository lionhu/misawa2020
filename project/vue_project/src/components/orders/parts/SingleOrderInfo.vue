<template>
    <div class="box">
      <div class="box-header flexbox flex-justified ">
        <div class="text-left">
          <h6 class="mb-0"  v-if="order.user.id==ME.user.id">
            <i class="fa fa-user text-success mr-5"></i>{{order.user.username}}
          </h6>
          <h6 class="mb-0"  v-if="order.user.id !=ME.user.id">
            <i class="fa fa-user text-success mr-5" ></i>{{order.user.username | filterUsername}}
          </h6>
          <small class="text-warning">
            <i class="fas fa-stopwatch"></i> {{deadline}}
          </small>
        </div>
        <div class="text-right">
          <a class="btn text-success">
            <i class="fab fa-rocketchat" v-if="order.status=='Matching'"></i>
            {{order.status}}
          </a>
        </div>
      </div>
      <div class="box-body">
        <ul class="flexbox flex-justified text-center mt-30">
          <li class="br-1">
            <small>Bid(売り)</small>
            <div class="font-size-20">{{order.amount|currency}}
            {{order.from_currency=="jpy"?"万円":"元"}}</div>
            <small>
              <span class="flag-icon flag-icon-jp fa-2x" v-if="order.from_currency=='jpy'"></span>
              <span class="flag-icon flag-icon-cn fa-2x" v-if="order.from_currency=='rmb'"></span>
            </small>
          </li>

          <li class="br-1">
            <small>
              <i class="fas fa-exchange-alt"></i>
            </small>
            <div class="font-size-20 text-pink">{{order.rate}}</div>
            <small>Rate</small>
          </li>

          <li class="bg-warning">
            <small>Ask(買い)</small>
            <div class="font-size-20 text-white">{{ order.price |currency}}
            {{order.from_currency=="rmb"?"円":"元"}}
            </div>
            <small>
              <span class="flag-icon flag-icon-jp fa-2x" v-if="order.from_currency=='rmb'"></span>
              <span class="flag-icon flag-icon-cn fa-2x" v-if="order.from_currency=='jpy'"></span>Price</small>
          </li>
        </ul>
      </div>
      <div class="box-body">
        <ul class="flexbox flex-justified align-items-center">
          <li class="text-right">
            <div class="font-size-20 text-success">{{offersummary.belowrate}}%</div>
            <small class="text-uppercase">below</small>
          </li>

          <li class="text-center px-2">
            <div class="easypie" :data-percent="offersummary.overrate">
              <span class="percent">{{offersummary.overrate}}</span>
            <canvas height="220" width="220" style="height: 110px; width: 110px;"></canvas></div>
    
          </li>

          <li class="text-left">
            <div class="font-size-20 text-warning">{{offersummary.overrate}}%</div>
            <small class="text-uppercase">over</small>
          </li>
        </ul>
      </div>

      <div class="box-body center" v-if="order.status!=='Matching'">
            <flip-countdown :deadline="deadline"></flip-countdown>
      </div>
    </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import FlipCountdown from 'vue2-flip-countdown'


  export default {
    name: 'singleorderinfo',
    components:{      
      FlipCountdown
    },
    props:["order","offersummary","deadline"],
    inject:["reload"],
    data () {
      return {
      }
    },
    computed:{
      ME(){
          return this.$store.state.users.profile
      },
    },
    mounted(){
    },
    methods: {
    }
  };
</script>

<style lang="scss">
</style>