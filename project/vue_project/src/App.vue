<template>
    <div>
        <router-view name="topmenu"></router-view>
        <router-view name="sidemenu"></router-view>

        <div class="content-wrapper">
            <section class="content">

                <router-view name="maincontent"></router-view>
                <router-view v-if="isRouterAlive"></router-view>

            </section>
       </div>
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
                    this.isRouterAlive=true

                    // window.location.reload()
                })
            }
        }
    };
</script>

<style scoped>
</style>