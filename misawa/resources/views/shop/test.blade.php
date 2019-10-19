@extends("layouts.master")

@section("head_scripts")
    <!-- Bootstrap Switch CSS -->
    <link rel="stylesheet" href="{{asset('css/components/bs-switches.css')}}" type="text/css" />

    <!-- Radio Checkbox Plugin -->
    <link rel="stylesheet" href="{{asset('css/components/radio-checkbox.css')}}" type="text/css" />

    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="{{asset('css/components/bs-select.css')}}" type="text/css" />
@endsection

@section("main_content")

    <!-- Content
		============================================= -->
    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">

                <label>Customized with Labels:</label>
                <select class="selectpicker">
                    <option data-content="<span class='label label-success'>Mustard</span>">Mustard</option>
                    <option data-content="<span class='label label-warning'>Ketchup</span>">Ketchup</option>
                    <option data-content="<span class='label label-danger'>Relish</span>">Relish</option>
                </select>


                <div class="bottommargin divcenter" style="max-width: 40%; min-height: 350px;">
                    <canvas id="chart-0"></canvas>
                </div>

                <div class="toolbar center">
                    <button class="btn btn-default btn-sm" id="randomizeData">Randomize Data</button>
                    <button class="btn btn-default btn-sm" id="addDataset">Add Dataset</button>
                    <button class="btn btn-default btn-sm" id="removeDataset">Remove Dataset</button>
                    <button class="btn btn-default btn-sm" id="addData">Add Data</button>
                    <button class="btn btn-default btn-sm" id="removeData">Remove Data</button>
                </div>
                <!-- Charts Area End -->

            </div>

        </div>

    </section><!-- #content end -->

@endsection

@section("foot_scripts")

    <script src="{{asset('js/cart.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/chart.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/chart-utils.js')}}"></script>

    <script type="text/javascript">

        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100);
        };

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                    backgroundColor: [
                        window.chartColors.red,
                        window.chartColors.orange,
                        window.chartColors.yellow,
                        window.chartColors.green,
                        window.chartColors.blue,
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    "Red",
                    "Orange",
                    "Yellow",
                    "Green",
                    "Blue"
                ]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Doughnut Chart'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("chart-0").getContext("2d");
            window.myDoughnut = new Chart(ctx, config);
        };
    </script>

@endsection
@section("jquery_scripts")

@endsection



