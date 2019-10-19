<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
{{--    <link rel="icon" href="../images/favicon.ico">--}}

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Crypto Admin - Dashboard</title>

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{asset('/crypto/assets/vendor_components/bootstrap/dist/css/bootstrap.css')}}">

    <!-- Bootstrap-extend -->
    <link rel="stylesheet" href="{{asset('/crypto/css/bootstrap-extend.css')}}">

    <!-- theme style -->
    <link rel="stylesheet" href="{{asset('/crypto/css/master_style.css')}}">

    <!-- Crypto_Admin skins -->
    <link rel="stylesheet" href="{{asset('/crypto/css/skins/_all-skins.css')}}">

    @yield("header_script")


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">

    @include("parts.crypto.header")

    @include("parts.crypto.sidebar")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield("main_content")
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
        @include("parts.crypto.footer")

    @include("parts.crypto.sidebar_control")

</div>
<!-- ./wrapper -->

@yield("vue_script")


<!-- jQuery 3 -->
<script src="{{asset(('/crypto/assets/vendor_components/jquery/dist/jquery.js'))}}"></script>

<!-- popper -->
<script src="{{asset(('/crypto/assets/vendor_components/popper/dist/popper.min.js'))}}"></script>

<!-- Bootstrap 4.0-->
<script src="{{asset(('/crypto/assets/vendor_components/bootstrap/dist/js/bootstrap.js'))}}"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset(('/crypto/assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js'))}}"></script>

<!-- Slimscroll -->
<script src="{{asset(('/crypto/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js'))}}"></script>

<!-- FastClick -->
<script src="{{asset(('/crypto/assets/vendor_components/fastclick/lib/fastclick.js'))}}"></script>


<!-- Crypto_Admin App -->
<script src="{{asset(('/crypto/js/template.js'))}}"></script>

<!-- Crypto_Admin dashboard demo (This is only for demo purposes) -->
{{--<script src="{{asset(('/crypto/js/pages/dashboard.js'))}}"></script>--}}
{{--<script src="{{asset(('/crypto/js/pages/dashboard-chart.js'))}}"></script>--}}

<!-- Crypto_Admin for demo purposes -->
{{--<script src="{{asset(('/crypto/js/demo.js'))}}"></script>--}}

@yield("footer_script")


</body>
</html>
