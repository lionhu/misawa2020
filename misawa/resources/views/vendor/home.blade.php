@extends("layouts.master")

@section("head_scripts")
    {{--<link href="//cdn.quilljs.com/1.2.4/quill.snow.css" rel="stylesheet">--}}
@endsection



@section("main_content")


    <!-- Page Sub Menu
		============================================= -->
    @include("parts.pagemenu_vendor")


    <!-- Content
		============================================= -->
    <section id="content" >
            <div class="content-wrap">

                <div class="container clearfix" id="app">

                </div>
            </div>

    </section><!-- #content end -->


@endsection

@section("jquery_scripts")

    <script src="{{asset('js/vendor.js')}}"></script>

@endsection

@section("jquery_afterscripts")

@endsection

