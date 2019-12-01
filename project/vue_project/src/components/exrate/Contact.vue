<template>
<div class="row">
  <div class="col-md-6 col-lg-3">
    <div class="box box-inverse box-carousel bg-hexagons-white pull-up slide" style="background-color: #1da738">
      <div class="flexbox align-items-center px-20 pt-20">
        <label class="toggler toggler-danger font-size-16">
          <input type="checkbox" checked="">
          <i class="fa fa-heart"></i>
        </label>
<!--         <div class="dropdown">
          <a data-toggle="dropdown" href="#" aria-expanded="false"><i class="ti-more-alt rotate-90 text-muted"></i></a>
          <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(12px, 17px, 0px); top: 0px; left: 0px; will-change: transform;">
            <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>
            <a class="dropdown-item" href="#"><i class="fa fa-picture-o"></i> Shots</a>
            <a class="dropdown-item" href="#"><i class="ti-check"></i> Follow</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#"><i class="fa fa-ban"></i> Block</a>
          </div>
        </div> -->
      </div>
      <div class="box-body text-center pt-1 pb-50">
        <a href="#">
          <img class="avatar avatar-xxxl" src="/static/img/exrate_wechat.jpg" style="margin:auto;">
        </a>
        <h5 class="mt-3 mb-1">
            <!-- <a class="hover-primary" href="#">Wechat</a> -->
        </h5>
        <h4 class="text-fade">Wechat</h4>
      </div>
    </div>
  </div>
<!--   <div class="col-md-6 col-lg-3">
    <div class="box box-inverse box-carousel bg-hexagons-white pull-up slide" style="background-color: #3b5998">
      <div class="flexbox align-items-center px-20 pt-20">
        <label class="toggler toggler-danger font-size-16">
          <input type="checkbox" checked="">
          <i class="fa fa-heart"></i>
        </label>
      </div>
      <div class="box-body text-center pt-1 pb-50">
        <a href="#">
          <img class="avatar avatar-xxl" src="/images/avatar/2.jpg" style="margin:auto;">
        </a>
        <h5 class="mt-3 mb-1"><a class="hover-primary" href="#">FaceBook</a></h5>
      </div>
    </div>
  </div> -->
<!--   <div class="col-md-6 col-lg-3">
    <div class="box box-inverse box-carousel bg-hexagons-white pull-up slide" style="background-color: #3b5998">
      <div class="flexbox align-items-center px-20 pt-20">
        <label class="toggler toggler-danger font-size-16">
          <input type="checkbox" checked="">
          <i class="fa fa-heart"></i>
        </label>
      </div>
      <div class="box-body text-center pt-1 pb-50">
        <a href="#">
          <img class="avatar avatar-xxl" src="/images/avatar/2.jpg" style="margin:auto;">
        </a>
        <h5 class="mt-3 mb-1"><a class="hover-primary" href="#">FaceBook</a></h5>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="box box-inverse box-carousel bg-hexagons-white pull-up slide" style="background-color: #3b5998">
      <div class="flexbox align-items-center px-20 pt-20">
        <label class="toggler toggler-danger font-size-16">
          <input type="checkbox" checked="">
          <i class="fa fa-heart"></i>
        </label>
      </div>
      <div class="box-body text-center pt-1 pb-50">
        <a href="#">
          <img class="avatar avatar-xxl" src="/images/avatar/2.jpg" style="margin:auto;">
        </a>
        <h5 class="mt-3 mb-1"><a class="hover-primary" href="#">FaceBook</a></h5>
      </div>
    </div>
  </div> -->
</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'

  export default {
    name: 'app',
    components:{
    },
    data () {
      return {
      }
    }
};

</script>

<style lang="scss">
table tr th{
  width:110px;
  background-color:rgb(47,47,47);
}

table tr td{
  background-color:rgb(47,47,47);
}
</style>