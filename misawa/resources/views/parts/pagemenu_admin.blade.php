
<!-- Page Sub Menu
============================================= -->
<div id="page-menu">

    <div id="page-menu-wrap">

        <div class="container clearfix">

            <div class="menu-title">Misawa Pharmacy, Tokyo</div>

            <nav class="hidden-print">
                <ul>
                    <li class="current"><a href="{{url('/admin')}}"><div>Dashboard</div></a></li>
                    <li ><a href="/admin#/cartviewer"><div>Cart</div></a></li>
                    <li><a href="#"><div>产品管理</div></a>
                        <ul>
                            <li><a href="/admin#/products"><div>所有产品</div></a></li>
                            <li><a href="/admin#/addproduct"><div>添加产品</div></a></li>
                            <li><a href="{{route('admin_download_products')}}"><div>下载产品清单</div></a></li>
                        </ul>
                    </li>
                    <li><a href="#"><div>用户管理</div></a>
                        <ul>
                            <li><a href="/admin#/users"><div>所有用户</div></a></li>
                            <li><a href="/admin#/customers"><div>所有顾客</div></a></li>
                        </ul>
                    </li>
                    <li><a href="#"><div>订单管理</div></a>
                        <ul>
                            <li><a href="/admin#/pos"><div>所有订单</div></a></li>
                            <li><a href="{{route('admin_download_POList')}}"><div>订单下载</div></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <div id="page-submenu-trigger"  class="hidden-print"><i class="icon-reorder"></i></div>

        </div>

    </div>

</div><!-- #page-menu end -->
