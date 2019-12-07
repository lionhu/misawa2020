<template>

<radial-menu
  style="margin: auto;z-index:10;position:fixed;top:120px;right:10px; background-color: #1ABC9C;color:white"
  :itemSize="50"
  :radius="80"
  :rotate ="-90"
  :angle-restriction="90">
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
        ME:null,
        items: [{value:'order',icon:"<i class='fas fa-list'></i>",href:"http://www.baidu.com"}, 
                {value:'new',icon:"<i class='fas fa-list'></i>",href:""},
                {value:'user',icon:"<i class='icon-line2-user mr-1 position-relative'></i>",href:""},
        ],
      }
    },
    methods: {
      handleClick (item) {
        console.log(item)
      }
    },
    watch: {
      '$route' (to, from) {
          console.log("watch route222")
          const to_id=to.params.catalogue_id
          const from_id =from.params.catalogue_id
          if(from_id !== to_id){
            // this.loadCatalogueProducts(to_id)
          }
      }
  }
};
</script>

<style lang="scss">
</style>