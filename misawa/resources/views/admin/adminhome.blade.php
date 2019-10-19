@extends("layouts.master_crypto")

@section("head_scripts")

@endsection

@section("main_content")

    <!-- Page Sub Menu
		============================================= -->
{{--    @include("parts.pagemenu_admin")--}}

    <!-- Content
		============================================= -->
    <section id="content_main" >
            <div class="content-wrap" id="app">
            </div>
    </section><!-- #content end -->
@endsection

@section("vue_script")
    <script src="{{asset('js/admin.js')}}" type="text/javascript" ></script>
@endsection

@section("jquery_afterscripts")
@endsection