@extends("layouts.master_print")

@section("head_scripts")

    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="{{asset('css/components/bs-select.css')}}" type="text/css" />
@endsection

@section("main_content")

    <!-- Content
		============================================= -->
    <section id="content">

        <div class="content-wrap">
            <div class="container clearfix" id="app">
            </div>
        </div>

    </section><!-- #content end -->

@endsection

@section("jquery_scripts")
    <script src="{{asset('js/cart.js')}}"></script>
@endsection



