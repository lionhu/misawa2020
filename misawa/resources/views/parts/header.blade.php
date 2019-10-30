
<header id="header" class="hidden-print">

    <div id="header-wrap">

        <div class="container clearfix">

            <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

            <!-- Logo
            ============================================= -->
            <div id="logo">
                
                @role(['distributor','viewer','guest','customerAdmin','customer','superadmin'])
                    <a href="{{route('shop_home')}}" class="standard-logo" data-dark-logo="images/logo-dark.png">
                        <img src="{{asset('images/misawaheader.jpg')}}" alt="Canvas Logo" style="height:60px;">
                        {{--<img src="{{asset('images/misawaheader.jpg')}}"  style="width:80%;">--}}
                    </a>
                    <a href="{{route('shop_home')}}" class="retina-logo" data-dark-logo="images/logo-dark@2x.png">
                        <img src="{{asset('images/misawaheader.jpg')}}" alt="Canvas Logo" style="height:60px;">
                        {{--<img src="{{asset('images/misawaheader.jpg')}}"  style="width:80%;">--}}
                    </a>
                @endrole
                @role('vendor')
                    <a href="{{route('shop_home')}}" class="standard-logo" data-dark-logo="images/logo-dark.png">
                        <img src="{{asset('images/logo@2x.png')}}" style="height: 60px;">
                    </a>
                    <a href="{{route('shop_home')}}" class="retina-logo" data-dark-logo="images/logo-dark@2x.png">
                        <img src="{{asset('images/logo@2x.png')}}" style="height: 60px;">
                    </a>
                @endrole
                
                
                
            </div><!-- #logo end -->

            <!-- Primary Navigation
            ============================================= -->
            <nav id="primary-menu">

                <ul>

                    @role(['distributor','customerAdmin','customer','superadmin'])
                    <li>
                        <a href="#" data-toggle="modal"  data-target=".bs-example-modal-sm">
                            <i class="fa fa-qrcode" aria-hidden="true"></i>微信支付QR
                        </a>
                    </li>
                    <li>
                        <a href="{{route('shop_faq')}}" >
                            <i class="fa fa-question" aria-hidden="true"></i>常见问题FAQ
                        </a>
                    </li>
                    @endrole

                    @role("customer")
                        <li><a href="{{route('getMyPOs_customer')}}"><div>我的订单</div></a></li>
                    @endrole
                    {{--@role(["customerAdmin"])--}}
                        {{--<li><a href="/customerAdmin#/mypos"><div>我的订单</div></a></li>--}}
                    {{--@endrole--}}
                    @role(['distributor'])
                        <li><a href="/#/pos"><div>我的订单</div></a></li>
                    @endrole
                    {{--@role("superadmin")--}}
                        {{--<li><a href="/#/pos"><div>我的订单</div></a></li>--}}
                    {{--@endrole--}}

                </ul>


                @role(['customer','distributor','customerAdmin','superadmin'])
                <div id="menucart" class="hidden-print">
                    {{--<a href="/cart"><i class="icon-shopping-cart"></i><span class="cart_total"></span></a>--}}
                </div>

                @endrole

<!--                 @role(['guest','customer','distributor','customerAdmin','superadmin'])
                <div id="top-search" class="hidden-print">
                    <a href="/#/products"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>

                </div>
                @endrole -->




            </nav><!-- #primary-menu end -->

        </div>

    </div>



    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-body">
                <div class="modal-content">
                        <div class="col-md-12 center">
                            <img style="width: 200px;" src="{{asset('/images/wechatpay.jpg')}}" alt="">

                        </div>
                </div>
            </div>
        </div>
    </div>


</header><!-- #header end