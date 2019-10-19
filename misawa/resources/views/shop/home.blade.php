@extends("layouts.master")

@section("head_scripts")
    <!-- Lionhu's Stylesheets
============================================= -->
<link rel="stylesheet" href="{{asset('mystyle.css')}}" type="text/css" />
@endsection



@section("main_content")

    <!-- Content
		============================================= -->
    <section >
            <div class="content-wrap" id="app">

            </div>


    </section><!-- #content end -->


@endsection

@section("jquery_scripts")

    <script src="{{asset('js/misawashop.js')}}"></script>

@endsection

@section("jquery_afterscripts")

@endsection

