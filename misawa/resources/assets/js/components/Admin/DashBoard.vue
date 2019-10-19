<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-body">
                        <h4 class="box-title">Last 3 <strong>Month Report</strong></h4>
                        <table class="table">
                            <thead>
                            <tr class="bt-3 border-primary">
                                <th>Month</th>
                                <th>Count</th>
                                <th>Sales</th>
                                <th>UnPaid</th>
                                <th>Profit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="His in Last3MonthSummary">
                                <td>{{His.PO_Month}}</td>
                                <td>{{His.po_count}}</td>
                                <td>{{His.total_Dis_price | currency_rmb}}</td>
                                <td>{{His.total_R_price-His.total_paid_vendor | currency_jpy}}</td>
                                <td>{{His.total_Dis_price-parseInt(His.total_R_price*currencyRate/100) | currency_rmb}}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>


        <div class="clear"></div>
<!--        <div class="col_one_third nobottommargin center">-->
<!--            <i class="i-plain i-xlarge divcenter nobottommargin icon-diamond"></i>-->
<!--            <div class="counter counter-large" style="color: #1abc9c;">-->
<!--                <span data-from="0" :data-to="po_count" data-refresh-interval="50" data-speed="2000"></span></div>-->
<!--            <h5>PO Sales</h5>-->
<!--        </div>-->

<!--        <div class="col_one_third nobottommargin center">-->
<!--            <i class="i-plain i-xlarge divcenter nobottommargin icon-user"></i>-->
<!--            <div class="counter counter-large" style="color: #e74c3c;">-->
<!--                <span data-from="0" :data-to="user_count" data-refresh-interval="50" data-speed="2500"></span></div>-->
<!--            <h5>Users</h5>-->
<!--        </div>-->

<!--        <div class="col_one_third col_last nobottommargin center">-->
<!--            <i class="i-plain i-xlarge divcenter nobottommargin icon-gift"></i>-->
<!--            <div class="counter counter-large" style="color: #3498db;">-->
<!--                <span data-from="0" :data-to="customer_count" data-refresh-interval="50" data-speed="3500"></span></div>-->
<!--            <h5>Customers Served</h5>-->
<!--        </div>-->

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
            this.$store.dispatch("pos/get_monthly_summary")
            this.$store.dispatch("system/load_management_info");
            this.fillData()
            console.log(this.monthSummaryDataset)
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
                                label: 'R',
                                backgroundColor: '#09f6f8',
                                data: this.monthSummaryDataset.R_Total
                            },
                            {
                                label: 'Dis',
                                backgroundColor: '#f8c00a',
                                data: this.monthSummaryDataset.Dis_Total
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