<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />


    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('css/responsive.css')}}" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Document Title
    ============================================= -->
    <title>Login| Tokyo Misawa Pharmacy</title>

</head>

<body class="stretched" data-loader="7" data-loader-color="green">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    <!-- Content
    ============================================= -->
    <section id="content">

        <div class="content-wrap nopadding">

            <div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: url({{asset('images/parallax/1.jpg')}}) center center no-repeat; background-size: cover;"></div>

            <div class="section nobg full-screen nopadding nomargin">
                <div class="container vertical-middle divcenter clearfix">


                    <div class="panel panel-default divcenter noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
                        <div class="panel-body" style="padding: 40px;">
                                    <small style="font-size: 8px;">昭和38年から創業、東京都から薬と健康のプロとして、皆様のために日夜ご奉仕し続けております。
                                        <a href="http://www.misawa-jp.com">Misawa Pharmacy Japan</a>
                                    </small>
                            <form id="login-form" name="login-form" class="nobottommargin" action="{{ route('login') }}" method="post">
                                <h3>Misawa Pharmacy</h3>

                                {{ csrf_field() }}

                                <div class="col_full">
                                    <label for="email">用户名:</label>
                                    <input type="text" id="email" name="email" placeholder="email" class="form-control"
                                           value="{{ old('email') }}" required autofocus/>
                                </div>

                                <div class="col_full">
                                    <label for="password">密码:</label>
                                    <input type="password" id="password" name="password" placeholder="password"
                                           class="form-control"/>
                                </div>

                               
                                <div class="col_full nobottommargin">
                                    <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">登录</button>
                                     
                                    <a href="/register" class="fright register_link" >还没有注册?</a>
                                    
                                    <a href="{{url('password/reset')}}" class="fright" style="margin-right: 10px;">忘记密码了?</a> 
                                    
                                </div>
                                
                            </form>
                            <div class="row center">
                                <img src="/images/misawa_wechat.jpg" style="width:80%">
                            </div>
                        </div>
                    </div>

                    <div class="row center dark"><small>Copyrights &copy; All Rights Reserved by Misawa Co., Ltd</small></div>

                </div>
            </div>

        </div>

    </section><!-- #content end -->

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- External JavaScripts
============================================= -->
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins.js')}}"></script>

<!-- Footer Scripts
============================================= -->
<script type="text/javascript" src="{{asset('js/functions.js')}}"></script>
<script>
    // $(".register_link").on("click",function () {
    //     $("#Register-form").removeClass("hidden");
    //     $("#login-form").addClass("hidden");
    // });
    //
    // $(".login_link").on("click",function () {
    //     $("#Register-form").addClass("hidden");
    //     $("#login-form").removeClass("hidden");
    // });
</script>
</body>
</html>
