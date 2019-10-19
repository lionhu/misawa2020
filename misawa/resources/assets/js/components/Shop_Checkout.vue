<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <CheckoutForm ></CheckoutForm>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</template>

<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import CheckoutForm from "./CheckoutForm"

    export default {
        name: "app",
        components:{
            CheckoutForm
        },
        data() {
            return {

            }
        },
    }
</script>

<style scoped>
</style>