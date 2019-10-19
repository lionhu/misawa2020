<template>

    <div class="content-wrap">
        <div class="container clearfix">
            <router-view name="maincontent" :key="key"></router-view>

            <router-view name="sidebar"></router-view>
        </div>

    </div>
</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"

    export default {
        name: "app",
        data() {
            return {
            }
        },
        mounted(){
            this.$store.dispatch("system/load_management_info")
        },
        computed:{
            key(){
                return this.$route.name !== undefined? this.$route.name +new Date(): this.$route +new Date()
            }
        }
    }
</script>

<style scoped>
</style>