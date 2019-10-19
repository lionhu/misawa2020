@extends("layouts.master_crypto")

@section("header_script")

@endsection

@section("main_content")
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