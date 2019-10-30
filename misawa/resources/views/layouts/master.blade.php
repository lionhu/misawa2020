<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Stylesheets
    ============================================= -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">



    @yield("head_scripts")
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('mystyle.css')}}" type="text/css" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <!-- Document Title
    ============================================= -->
    <title>Misawa Pharmacy</title>

</head>

<body class="stretched" data-loader="7" data-loader-color="green">
	<div class="body-overlay"></div>

	<div id="side-panel" class="dark">

		<div id="side-panel-trigger-close" class="side-panel-trigger"><a href="#"><i class="icon-line-cross"></i></a></div>

		<div class="side-panel-wrap">

			<div class="widget clearfix" id="TopCatalogueMenu">
			</div>
		</div>

	</div>
<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    <!-- Top Bar
============================================= -->
    <div id="top-bar" class="dark hidden-print">

        <div class="container-fullwidth static-sticky clearfix ">

            <div class="col_half nobottommargin hidden-xs">

                <p class="nobottommargin">
                    @role(['customer',"guest","viewer",'distributor','customerAdmin','superadmin'])
                        <strong>三澤薬局
                            <span class="flag-icon flag-icon-gr flag-icon-squared"></span>
                        </strong>
                    @endrole

                    @role(['customer','distributor','customerAdmin','superadmin'])
                            <a href="#ContactAdmin" data-lightbox="inline">
                                <span style="color: white;font-size: 1.3rem;font-weight: bolder;font-family: 'Lato', sans-serif;background-color: red;border-radius: 5px;padding: 5px;">{{env('SYSMESSAGE')}}</span>
                            </a>
                        @endrole    
                    
                </p>
            </div>

            <div class="col_half col_last fright nobottommargin">

                <!-- Top Links
                ============================================= -->
                <div class="top-links">
                    <ul style="text-align: right;display: flex;">
                        @role(['viewer','guest','customer','distributor','customerAdmin','superadmin'])
                        <li><a href="/faq" ><i class="fa fa-question fa-2x"></i>FAQ</a></li>
                        @endrole

                        <li class="top-links-language"><a href="#"><i class="i-plain icon-globe"></i></a>
                            <ul>
                                <li><a href="/language/ch"><img src="{{asset('images/flags/cn.svg')}}" alt="China"> 中文</a></li>
                                <li><a href="/language/jp"><img src="{{asset('images/flags/jp.svg')}}" alt="Japan"> 日本語</a></li>
                                <li><a href="/language/en"><img src="{{asset('images/flags/um.svg')}}" alt="USA"> ENG</a></li>
                            </ul>
                        </li>

                        @role(['viewer','guest','customer','distributor','customerAdmin','superadmin'])
                        <li><a href="#" class="side-panel-trigger">{{trans("app.Menu")}}</a></li>
                        @endrole

                        @role([ 'customer','distributor','customerAdmin','superadmin'])
                        <li>
                            <a href="/#/cart"><i class="icon-shopping-cart"></i><span style="background-color: green;" class="cart_total badge badge-pill badge-success"></span></a>
                        </li>
                        @endrole
                        <li>
                            @if(!Auth::user())
                            <a href="#">Login</a>
                            <div class="top-link-section">
                                <form id="top-login" role="form" action="{{ route('login') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="input-group" id="top-login-username">
                                        <span class="input-group-addon"><i class="icon-user"></i></span>

                                        <label for="email"></label>
                                        <input type="text" id="email" name="email" class="form-control"
                                               value="{{ old('email') }}" required autofocus/>
                                    </div>
                                    <div class="input-group" id="top-login-password">
                                        <span class="input-group-addon"><i class="icon-key"></i></span>
                                        <label for="password"></label>
                                        <input type="password" id="password" name="password"
                                               class="form-control"/>
                                    </div>
                                    <label class="checkbox">
                                        <input type="checkbox" id="password" name="password" value="remember-me"> Remember me
                                    </label>
                                    <button class="btn btn-danger btn-block" type="submit">Sign in</button>
                                </form>
                            </div>
                            @else
                                <a href="#" onclick="return false;">{{Auth::user()->name}}</a>

                                <div class="top-link-section" style="text-align: right; width: 180px;">
                                    <a href="/logout" style="display: block;">Logout</a>
                                    @role("superadmin")
                                        <a href="{{url("/admin/")}}"  style="display: block;">{{trans("app.Dashboard")}}</a>
                                        {{--<a href="{{route("admin_last3month")}}"  style="display: block;">Last 3 monthes</a>--}}
                                    @endrole
                                    @role("customerAdmin")
                                        <a href="{{route("customerAdmin_home")}}">{{trans("app.Dashboard")}}</a>
                                    @endrole
                                    @role("vendor")
                                        <a href="/vendor#/pos">{{trans("app.Dashboard")}}</a>
                                    @endrole
                                </div>

                            @endif
                        </li>
                    </ul>
                </div><!-- .top-links end -->

            </div>

        </div>

    </div><!-- #top-bar end -->

    @include("parts.header")
    <!-- Content
    ============================================= -->
    @yield("main_content")


    {{--@include("parts.footer")--}}

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>


    <!-- Modal -->
    <div class="modal1 mfp-hide subscribe-widget" id="ContactAdmin">
        <div class="block dark divcenter" style="background: url('/images/contactadmin.jpg') no-repeat; background-size: cover; max-width: 700px;" data-height-xl="400">
            <div style="color: #757272;padding: 50px;">
                <div class="heading-block nobottomborder bottommargin-sm" style="max-width:500px;">
                </div>
                <div class="widget-subscribe-form-result"></div>

                
                <p class="nobottommargin" style="color: #757272;margin-top: 220px;"><small><em></em></small></p>
            </div>
        </div>
    </div>



<a href="#" id="adminMessage"></a>
    <span id="site_url" style="display: none;">{{env("APP_URL")}}</span>
<!-- External JavaScripts
============================================= -->


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