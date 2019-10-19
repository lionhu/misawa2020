<template>
    <div>
        <router-view name="topmenu"></router-view>
        <router-view name="sidemenu"></router-view>

        <section class="content">

            <div class="content-wrapper">
                <router-view name="maincontent"></router-view>
                <router-view v-if="isRouterAlive"></router-view>
           </div>
        </section>

    </div>
</template>

<script>
    export default {
        name: "app",
        provide(){
            return {
                reload:this.reload
            }
        },
        data(){
            return {
                isRouterAlive:true
            }
        },
        methods:{
            reload(){
                this.isRouterAlive=false
                this.$nextTick(function(){
                    console.log("page reload")
                    this.isRouterAlive=true

                    // window.location.reload()
                })
            }
        }
    };
</script>

<style scoped>
</style>