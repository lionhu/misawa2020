<!-- Page Sub Menu
============================================= -->
<div id="page-menu">

    <div id="page-menu-wrap">

        <div class="container clearfix">

            <div class="menu-title">Vendor</div>

            <nav>
                <ul>
                    <li><a href="/vendor#/dashboard"><div>DashBoard</div></a></li>
                    <li><a href="#"><div>注文管理</div></a>
                        <ul>
                            <li><a href="/vendor#/pos"><div>注文リスト</div></a></li>
                            <li><a href="{{route('vendor_download_POList')}}"><div>注文ダウンドード</div></a></li>
                        </ul>
                    </li>
                    <li><a href="/vendor#/products"><div>製品管理</div></a></li>
                    <!-- <li><a href="{{route('vendor_download_CustomerList')}}"><div>顧客リスト</div></a></li> -->

                </ul>
            </nav>

            <div id="page-submenu-trigger"><i class="icon-reorder"></i></div>

        </div>

    </div>

</div><!-- #page-menu end -->