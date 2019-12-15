<template>

<radial-menu
  style="margin: auto;z-index:10;position:fixed;bottom:10px;right:10px; background-color: #1ABC9C;color:white"
  :itemSize="50"
  :radius="70"
  :rotate ="0"
  :angle-restriction="90" v-if="ME.username !=undefined ">
    <radial-menu-item 
      v-for="(item, index) in items" 
      :key="index" 
      style="background-color: white;color:#1ABC9C;"
      @click="() => handleClick(item.value)">
      <a :href="item.href"><span v-html="item.icon"></span></a>
    </radial-menu-item>
  </radial-menu>
</template>

<script>

  import { RadialMenu,  RadialMenuItem } from 'vue-radial-menu'


  export default {
    name: 'radiusbuttonmenu',
    components:{
      RadialMenu,
      RadialMenuItem
    },
    data () {
      return {
        items: [{value:'exchange',icon:'<i class="fas fa-comments-dollar"></i>',href:"/exrate/"}, 
                {value:'shop',icon:'<i class="fas fa-store"></i>',href:"/shop/"},
                {value:'user',icon:"<i class='icon-line2-user mr-1 position-relative'></i>",href:"/shop/#/user/home"},
        ],
      }
    },
    computed:{
      ME: function(){
        return this.$store.state.users.ME;
      }
    },
    methods: {
      handleClick (item) {
        console.log(item)
      }
    },
    watch: {
      '$route' (to, from) {
          // const to_id=to.params.catalogue_id
          // const from_id =from.params.catalogue_id
          // if(from_id !== to_id){
          // }
      }
  }
};
</script>

<style lang="scss">
</style>