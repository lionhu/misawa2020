<template>
  <div class="box card-inverse bg-img" style="background-image: url(/static/images/gallery/2.jpg); padding-top: 275px">
    <div class="flexbox align-items-center px-20" data-overlay="4">
      <div class="flexbox align-items-center mr-auto">
<!--         <a href="#">
          <img class="avatar avatar-xl avatar-bordered" src="/static/images/gallery/4.jpg" alt="">
        </a> -->
        <div class="pl-10 d-none d-md-block">
          <h5 class="mb-0"><a class="hover-primary text-white" href="#">Roben Clark</a></h5>
          <span>Designer</span>
        </div>
      </div>

      <ul class="flexbox flex-justified text-center py-20">
<!--         <li class="px-10">
          <span class="opacity-60">Followers</span><br>
          <span class="font-size-20">9.6K</span>
        </li>
        <li class="px-10">
          <span class="opacity-60">Following</span><br>
          <span class="font-size-20">9845</span>
        </li> -->
        <li class="pl-10">
          <!-- <span class="opacity-60">Tweets</span><br> -->
          <span class="font-size-20">We are working hard on it</span>
        </li>
      </ul>
    </div>

  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'

  export default {
    name: 'bonus',
    components:{
    },
    data () {
      return {
        // ME:null,
        // profile:{
        //   avatar:"",
        //   imageUrl:"",
        //   wechat:"",
        //   wechatUrl:"",
        //   line:"",
        //   lineUrl:"",
        //   id_image:"",
        //   id_imageUrl:"",

        //   postcode:"",
        //   address1:"",
        //   address2:"",
        //   telephone:"08043608496",

        //   father:"",
        //   grandfather:"",
        //   partner:""
        // }
      }
    },
    computed:{

    },
    created() {


    },
    methods: {

    }
};

</script>

<style lang="scss">

</style>