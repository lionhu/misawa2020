<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Stylesheets
    ============================================= -->
    {{--<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />--}}
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">

    <!-- Lionhu's Stylesheets
============================================= -->
    <link rel="stylesheet" href="{{asset('mystyle.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}" type="text/css" />

    @yield("head_scripts")

    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <!-- Document Title
    ============================================= -->
    <title></title>

</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    <!-- Content
    ============================================= -->
    @yield("main_content")


    {{--@include("parts.footer")--}}

</div><!-- #wrapper end -->


@yield("jquery_scripts")

<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins.js')}}"></script>

@yield("beforefunction_scripts")
<script type="text/javascript" src="{{asset('js/functions.js')}}"></script>

<script src="{{asset('vendors/wysiwyg/handlebars.runtime.min.js')}}"></script>

@yield("jquery_afterscripts")
<!-- Footer Scripts
============================================= -->
</body>
</html>