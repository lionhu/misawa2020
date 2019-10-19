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
                            <th>Paid</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="His in Last3MonthSummary">
                            <td>{{His.PO_Month}}</td>
                            <td>{{His.po_count}}</td>
                            <td>{{His.total_R_price | currency_jpy}}</td>
                            <td>{{His.total_paid_vendor | currency_jpy}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--<a href="/vendor#/pos" class="button button-light button-xlarge button-border button-rounded">注文一覧</a>-->
            </div>
        </div>

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
            this.$store.dispatch("pos/get_vendor_monthly_summary")
            this.fillData()
        },
        computed: {
            ...mapGetters({
                monthSummaryDataset: "pos/monthSummary_chartData",
                Last3MonthSummary: "pos/Last3MonthSummary",
            })
        },
        methods: {
            fillData () {
                this.datacollection = {
                    labels: this.monthSummaryDataset.Labels,
                        datasets: [
                            //
                            // {
                            //     label: 'Count',
                            //     backgroundColor: '#23f80d',
                            //     data: this.monthSummaryDataset.Count
                            // },
                            {
                                label: 'Sales(万円)',
                                backgroundColor: '#09f6f8',
                                data: this.monthSummaryDataset.R_Total
                            },
                            {
                                label: '未払(万円)',
                                backgroundColor: '#f80c07',
                                data: this.monthSummaryDataset.Unpaid
                            }
                ]
                }
            },
        }
    }
</script>

<style>
    .small {
        max-width: 600px;
        margin:  150px auto;
    }
</style>