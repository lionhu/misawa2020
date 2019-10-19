@extends("layouts.master")

@section("head_scripts")
    {{--<link href="//cdn.quilljs.com/1.2.4/quill.snow.css" rel="stylesheet">--}}
@endsection



@section("main_content")

    <!-- Page Sub Menu
		============================================= -->
    @include("parts.pagemenu_customerAdmin")

    <!-- Content
		============================================= -->
    <section id="content" >
            <div class="content-wrap" id="shop">

                <div class="container clearfix">
                    <!-- Post Content
                    ============================================= -->
                    <div class=" nobottommargin col_last">
                        <div class="col_half">
                            <h3>Sales & Profit of each Client</h3>
                            <div class="bottommargin divcenter" style="max-width: 750px; min-height: 350px;">
                                <canvas id="chart-0"></canvas>
                            </div>
                        </div>
                        <div class="col_half col_last">

                            <h3>Monthly Sales & Profit summary</h3>
                            <div class="bottommargin divcenter" style="max-width: 750px; min-height: 350px;">
                                <canvas id="chart-1"></canvas>
                            </div>
                        </div>
                    </div><!-- .postcontent end -->

{{--                    @include("parts.adminsidemenu")--}}
                </div>
            </div>
    </section><!-- #content end -->
    {{--<div id="labels" hidden>{!! json_encode($clientnames)  !!}</div>--}}
    {{--<div id="client_B_price" hidden>{!! json_encode($client_B_price)  !!}</div>--}}
    {{--<div id="client_profit" hidden>{!! json_encode($client_profit)  !!}</div>--}}


    {{--<div id="month_date" hidden>{!! json_encode($month_date)  !!}</div>--}}
    {{--<div id="month_po_count" hidden>{!! json_encode($month_po_count)  !!}</div>--}}
    {{--<div id="month_R_total" hidden>{!! json_encode($month_R_total)  !!}</div>--}}
    {{--<div id="month_B_total" hidden>{!! json_encode($month_B_total)  !!}</div>--}}
    {{--<div id="month_O_total" hidden>{!! json_encode($month_O_total)  !!}</div>--}}




@endsection

@section("jquery_scripts")
    <!-- Charts JS
	============================================= -->
    <script type="text/javascript" src="{{asset('js/chart.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/chart-utils.js')}}"></script>

    <script src="{{asset('js/admin_vue.js')}}" type="text/javascript" ></script>
@endsection




@section("jquery_afterscripts")
@endsection