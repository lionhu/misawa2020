
<!-- Page Sub Menu
============================================= -->
<div id="page-menu">

    <div id="page-menu-wrap">

        <div class="container clearfix">

            <div class="menu-title">customerAdmin</div>

            <nav>
                <ul>
                    <li class="current"><a href="/customerAdmin#/dashboard"><div>管理主页</div></a></li>
                    <li><a href="#"><div>用户</div></a>
                        <ul>
                            <li><a href="/customerAdmin#/users"><div>我的团队</div></a></li>
                            <li><a href="/customerAdmin#/customers"><div>我的客户群</div></a></li>
                        </ul>
                    </li>
                    <li><a href="#"><div>订单</div></a>
                        <ul>
                            {{--<li><a href="/customerAdmin#/mypos"><div>我的订单</div></a></li>--}}
                            <li><a href="/customerAdmin#/teampos"><div>团队订单</div></a></li>
                            <li><a href="{{route('customerAdmin_download_POList')}}"><div>订单下载</div></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <div id="page-submenu-trigger"><i class="icon-reorder"></i></div>

        </div>

    </div>

</div><!-- #page-menu end -->
