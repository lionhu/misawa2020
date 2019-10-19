<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <Cart></Cart>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import Cart from "./Cart"

    export default {
        name: "app",
        components:{
            Cart
        },
        data() {
            return {

            }
        },
    }
</script>

<style scoped>
</style>