<template>
    <div>
        <div class="promo parallax promo-dark promo-flat promo-full bottommargin" style="background-image: url('images/parallax/7.jpg');" data-bottom-top="background-position:0px 300px;" data-top-bottom="background-position:0px -300px;">
            <div class="container clearfix">
                <div class="card color">
                    <!-- Default panel contents -->
                    <h3 class="card-header color">Last 3 Month Report</h3>

                    <!-- Table -->
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th>Count</th>
                            <th>Sales</th>
                            <th class="hidden-xs">UnPaid</th>
                            <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="His in Last3MonthSummary">
                            <td>{{His.PO_Month}}</td>
                            <td>{{His.po_count}}</td>
                            <td>{{His.total_O_price | currency_rmb}}</td>
                            <td class="hidden-xs">{{His.total_B_price-His.total_paid_customer | currency_rmb}}</td>
                            <td>{{His.profit | currency_rmb}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="clear"></div>
        <div class="col_one_third nobottommargin center">
            <i class="i-plain i-xlarge divcenter nobottommargin icon-diamond"></i>
            <div class="counter counter-large" style="color: #1abc9c;">
                <span data-from="0" :data-to="po_count" data-refresh-interval="50" data-speed="2000"></span></div>
            <h5>PO Sales</h5>
        </div>

        <div class="col_one_third nobottommargin center">
            <i class="i-plain i-xlarge divcenter nobottommargin icon-user"></i>
            <div class="counter counter-large" style="color: #e74c3c;">
                <span data-from="0" :data-to="user_count" data-refresh-interval="50" data-speed="2500"></span></div>
            <h5>Users</h5>
        </div>

        <div class="col_one_third col_last nobottommargin center">
            <i class="i-plain i-xlarge divcenter nobottommargin icon-gift"></i>
            <div class="counter counter-large" style="color: #3498db;">
                <span data-from="0" :data-to="customer_count" data-refresh-interval="50" data-speed="3500"></span></div>
            <h5>Customers Served</h5>
        </div>

        <div class="clear"></div>

        <LineChart :chart-data="datacollection" :options="options"></LineChart>
    </div>
</template>


<script>

    import {mapActions, mapState,mapGetters} from "vuex"
    import LineChart from './parts/LineChart'

    export default {
        components: {
            LineChart
        },
        data () {
            return {
                datacollection:{},
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        },
        mounted () {
            this.$store.dispatch("pos/get_customeradmin_teampos");
            this.$store.dispatch("pos/get_monthly_summary");
            this.$store.dispatch("users/get_customeradmin_users");
            this.$store.dispatch("customers/get_customeradmin_customers");
            this.fillData()
        },
        computed: {
            ...mapGetters({
                monthSummaryDataset: "pos/monthSummary_chartData",
                Last3MonthSummary: "pos/Last3MonthSummary",
                po_count:"pos/po_count",
                user_count:"users/user_count",
                customer_count:"customers/customer_count",

            }),

            ...mapState({
            // catalogues:state =>state.catalogues.catalogues
            //     po_count: state =>state.system.po_count,
            //     count_user: state =>state.system.count_user,
            //     customer_count: state=>state.system.customer_count

            }),
            currencyRate(){
                return this.$store.state.system.rate;
            }
        },
        methods: {
            fillData () {
                this.datacollection = {
                    labels: this.monthSummaryDataset.Labels,
                        datasets: [

                            {
                                label: 'Profit',
                                backgroundColor: '#23f80d',
                                data: this.monthSummaryDataset.Profit
                            },
                            {
                                label: 'B',
                                backgroundColor: '#f8c00a',
                                data: this.monthSummaryDataset.B_Total
                            }, {
                                label: 'O',
                                backgroundColor: '#f87979',
                                data: this.monthSummaryDataset.O_Total
                            }
                ]
                }
            }
        }
    }
</script>

<style>
    .small {
        max-width: 600px;
        margin:  150px auto;
    }
</style>