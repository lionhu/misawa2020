<template>
    <div class="container-fluid clearfix">
        <router-view name="maincontent"></router-view>
        <!--<div class="sidebar nobottommargin col_last"></div>-->
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
    }
</script>

<style scoped>
</style>