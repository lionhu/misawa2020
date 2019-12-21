<template>
  <section>
    Hello
<!--     <SingleOrderInfo :order="order" :offersummary="offers_summary" :deadline="deadline"></SingleOrderInfo> -->
  </section>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'
  import FlipCountdown from 'vue2-flip-countdown'
  import SingleOrderInfo from "../parts/SingleOrderInfo.vue"


  export default {
    name: 'DSSingleOrder',
    components:{ 
      SingleOrderInfo
    },
    inject:["reload"],
    data () {
      return {
        isOrderOwner:false,
        todayrate:{},
        order:{},
        deadline:"2019-12-31 23:59:59"
      }
    },
    computed:{
      ME(){
          return this.$store.state.users.profile
      },
    },
    mounted(){
      console.log("SingleOrder DirectSell")
      console.log(this.$route.params.slug)
      // this.$store.dispatch("orders/get_singleorder",this.$route.params.slug).then(res=>{
      //   console.log("public SingleOrder res")
      //   console.log(res)
      //   this.order=res.order;
      //   this.offers=res.offers;
      //   this.total=res.offers.length
      //   this.isOrderOwner=res.order.isOrderOwner

      //   var offerindex=this.offers.findIndex(offer=>offer.follower==this.ME.user.username)
      //   this.hasOffered= offerindex>-1?true:false
      //   if(this.hasOffered){
      //       this.hasOffer_index=offerindex
      //       var off=this.offers[offerindex]
      //       this.hasOffer_id=off.id
      //   }
      //   this.deadline=this.order.due_at.replace("T"," ")
      //   this.prepare_offers_summary()
      //   this.reload()
      // },reject=>{})
    },
    created() {

    },
    methods: {
      format_due_at(row, column, cellValue, index){
        var date_strs=cellValue.split("T")
        return date_strs[0]
      }
    },
    watch:{
      $route:{
        handler(to,from){
          console.log(to.params.slug)
          if(to !==from){

          console.log(to)
          console.log(from)
          }

        }

      }
    }
};

</script>

<style lang="scss">
</style>