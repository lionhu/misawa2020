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
            <div class="content-wrap">

                <div class="container clearfix" id="app">
                    <!-- Post Content
                    ============================================= -->
                    {{--<div class=" nobottommargin col_last">--}}
                        {{--<div class="col_half text-center">--}}
                            {{--<h3>我的介绍码</h3>--}}
                            {{--<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(260)->generate('http://shop.misawa-pharmacy.com/register?introcode='.Auth::user()->introcode)) !!} ">--}}
                        {{--</div>--}}
                        {{--<div class="col_half col_last" id="app">--}}
                        {{--</div>--}}
                    {{--</div><!-- .postcontent end -->--}}

                </div>
            </div>
    </section><!-- #content end -->


@endsection

@section("jquery_scripts")
    <!-- Charts JS
	============================================= -->
    {{--<script type="text/javascript" src="{{asset('js/chart.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{asset('js/chart-utils.js')}}"></script>--}}

    {{--<script src="{{asset('js/admin_vue.js')}}" type="text/javascript" ></script>--}}
    <script src="{{asset('js/CustomerAdmin.js')}}" type="text/javascript" ></script>
@endsection




@section("jquery_afterscripts")
@endsection