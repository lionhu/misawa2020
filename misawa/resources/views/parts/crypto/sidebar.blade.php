
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="ulogo">
                <a href="/">
                    <!-- logo for regular state and mobile devices -->
                    <span><b>Misawa </b>Pharmacy</span>
                </a>
            </div>
            <div class="image">
                <img src="../images/user2-160x160.jpg" class="rounded-circle" alt="User Image">
            </div>
            <div class="info">
                <p>Admin Template</p>
                <a href="" class="link" data-toggle="tooltip" title="" data-original-title="Settings"><i class="ion ion-gear-b"></i></a>
                <a href="" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="ion ion-android-mail"></i></a>
                <a href="" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="ion ion-power"></i></a>
            </div>
        </div>
        <!-- sidebar menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="nav-devider"></li>
            <li class="header nav-small-cap">PERSONAL</li>
            <li class="active">
                <a href="{{url('/admin')}}">
                    <i class="icon-home"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="icon-chart"></i>
                    <span>订单管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin#/pos">所有订单</a></li>
                    <li><a href="{{route('admin_download_POList')}}">订单下载</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="icon-chart"></i>
                    <span>最近访客</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/utilities/recentVisit">访客清单</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="icon-compass"></i>
                    <span>用户管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin#/users">所有用户</a></li>
                    <li><a href="/admin#/customers">所有顾客</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="icon-people"></i>
                    <span>产品管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin#/products">所有产品</a></li>
                    <li><a href="/admin#/addproduct">添加产品</a></li>
                    <li><a href="{{route('admin_download_products')}}">下载产品清单</a></li>
                </ul>
            </li>
            <li class="treeview">
        </ul>
    </section>
</aside>