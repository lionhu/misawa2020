@extends("layouts.master")

@section("head_scripts")
    <!-- Datatables -->
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/components/bs-switches.css')}}" type="text/css">
    <style>
        #example tbody tr.odd {
            background-color: lightgray;
        }
        .itemtitle{
            width:50%;
            text-align: right;
        }
        .itemcontent{
            text-align: right;
        }
    </style>

@endsection



@section("main_content")

    @include("parts.pagemenu_distributor")

    <!-- Content
		============================================= -->
    <section id="content">
        <div class="content-wrap" id="shop">

            <div class="container clearfix">

                <div class="postcontent nobottommargin clearfix">
                    <div class="table-responsive">
                            <a href="" id="pagemessage"></a>
                        <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="text-align: center;">日期 <br>
                                    {{--<i class="fa fa-user-circle-o"></i> <i class="fa fa-long-arrow-right"></i><i class="fa fa-hospital-o"></i>--}}
                                </th>
                                <th class="center">客户</th>
                                <th  class="center">数量</th>
                                <th>价格</th>
                                <th class="center">状态</th>
                                <th class="center">支付情况</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mypos as $mypo)
                                <tr id="rowID_{{$mypo->id}}">
                                    <th>
                                        <button class="button button-3d button-small button-rounded button-green koun_po"
                                                data-toggle="modal" PO_id="{{$mypo->id}}"
                                                data-target=".bs-example-modal-lg"><i
                                                    class="icon-zoom-in2"></i><span> </span>{{$mypo->id}}</button>
                                    </th>
                                    <th>
                                        {{$mypo->created_at}}

                                    </th>
                                    <th class="center">
                                        {{$mypo->customer->name}}<br>
                                        {{$mypo->user->name}}<i class="fa fa-long-arrow-right"></i>{{$mypo->vendor->name}}
                                    </th>
                                    <th class="center" style="text-align: right;">{{$mypo->cart_Qty}}</th>
                                    <th style="text-align: right;">
                                        <span class="money">{{$mypo->cart_O_Price}}</span>
                                    </th>
                                    <th class="status center">
                                        @if($mypo->status == "new")
                                            <span class="label label-default">{{$mypo->status}}</span>

                                        @elseif($mypo->status == "processing")

                                            <span class="label label-warning">{{$mypo->status}}</span>
                                        @elseif($mypo->status == "Delivering")
                                            <span class="label label-primary">{{$mypo->status}}</span>
                                        @elseif($mypo->status == "completed")
                                            <span class="label label-success">{{$mypo->status}}</span>

                                        @elseif($mypo->status == "sendback")
                                            <span class="label label-danger">{{$mypo->status}}</span>
                                        @endif
                                            <br>
                                            <a  target="_blank" href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1={!! $mypo->delivery_no !!}&x=18&y=11">
                                                <i class="fa fa-truck" aria-hidden="true"></i>{{$mypo->delivery_no}}
                                            </a>

                                    </th>
                                    <th class="paid_customer center">
                                        @if($mypo->paid_customer==1)
                                            <i class="fa fa-check-circle-o" style="color: green;"></i>
                                        @else
                                            <i class="fa fa-times-circle-o" style="color: red;"></i>
                                        @endif
                                    </th>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="7" style="text-align: center;background-color: dimgrey;color: white;">Good Work!</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Sidebar
============================================= -->
                {{--<div class="sidebar nobottommargin col_last clearfix">--}}
                    {{--<div class="sidebar-widgets-wrap">--}}

                        {{--<div class="widget widget_links clearfix">--}}

                            {{--<h4>Shortcodes</h4>--}}
                            {{--<ul>--}}
                                {{--<li><a href="animations.html">--}}
                                        {{--<div>Animations</div>--}}
                                    {{--</a></li>--}}
                                {{--<li><a href="buttons.html">--}}
                                        {{--<div>Buttons</div>--}}
                                    {{--</a></li>--}}
                                {{--<li><a href="icon-lists.html">--}}
                                        {{--<div>Icon Lists</div>--}}
                                    {{--</a></li>--}}
                                {{--<li><a href="tabs.html">--}}
                                        {{--<div>Tabs</div>--}}
                                    {{--</a></li>--}}
                                {{--<li><a href="testimonials-twitter.html">--}}
                                        {{--<div>Testimonials</div>--}}
                                    {{--</a></li>--}}
                                {{--<li><a href="thumbnails-slider.html">--}}
                                        {{--<div>Thumbnails</div>--}}
                                    {{--</a></li>--}}
                                {{--<li><a href="toggles-accordions.html">--}}
                                        {{--<div>Toggles</div>--}}
                                    {{--</a></li>--}}
                            {{--</ul>--}}

                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div><!-- .sidebar end -->--}}

            </div>
        </div>
    </section>
    <!-- #content end -->



    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-body" id="po">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel">订单信息（@{{ po.id }}）</h3>
                    </div>
                    <div class="modal-body">
                        <div class="col_half nobottommargin">
                            <div class="title-block ">
                                <h4>客户信息:</h4>
                                <span>@{{customer.name}}</span>
                                <span>@{{customer.postcode}}</span>
                                <span>@{{customer.address1}}</span>
                                <span>@{{customer.address2}}</span>
                            </div>
                        </div>
                        <div class="col_half col_last nobottommargin hidden-xs">
                            <div class="title-block">
                                <h4>用户: @{{user.name}}</h4>
                                <span>ID: @{{user.id}}</span>
                                <span>邮箱: @{{user.email}}</span>
                            </div>
                        </div>
                        <div class="col_full clear-fix nobottommargin hidden-xs">
                            <table class="table cart">
                                <thead>
                                <tr>
                                    <th class="cart-product-thumbnail">&nbsp;</th>
                                    <th class="cart-product-name">产品</th>
                                    <th class="cart-product-quantity">数量</th>
                                    <th class="cart-product-subtotal">金额</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="cart_item" v-for="poitem in items">
                                    <td class="cart-product-thumbnail">
                                        <a href="#"><img width="64" height="64"
                                                         v-bind:src="getimgURL(poitem.item.thumbimage)"
                                                         alt="Pink Printed Dress"></a>
                                    </td>

                                    <td class="cart-product-name">
                                        <a href="#">@{{poitem.item.name}}</a>
                                    </td>

                                    <td class="cart-product-quantity">
                                        <div class="quantity clearfix">
                                            @{{poitem.qty}}
                                        </div>
                                    </td>

                                    <td class="cart-product-subtotal">
                                        <span class="amount">@{{poitem.total_o_price | currencyFormatter}}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col_full clear-fix">
                            <div class="col_half ">
                            </div>
                            <div class="col_half col_last nobottommargin">
                                <div class="table-responsive">
                                    <div class="hidden-xs">
                                        <h4>订单信息:</h4>
                                        <table class="table cart">
                                            <tbody>
                                            <tr class="cart_item">
                                                <td class="cart-product-name">
                                                    <strong>数量</strong>
                                                </td>
                                                <td class="cart-product-name"><span class="amount">@{{po.cart_Qty}}</span>
                                                </td>
                                            </tr>
                                            <tr class="cart_item">
                                                <td class="cart-product-name"><strong>总额</strong></td>
                                                <td class="cart-product-name"><strong><span
                                                                class="amount color lead">@{{po.cart_O_Price | currencyFormatter}} </span></strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div>
                                    <a href="#" data-dismiss="modal" class="button button-circle button-red po_deleteBtn"  v-on:click="deletePO">订单删除</a>
                                    <a href="#"  data-dismiss="modal" class="button button-circle">关闭</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:0 solid red;">
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section("jquery_scripts")

    <script src="{{asset('js/po.js')}}"></script>

@endsection

@section("jquery_afterscripts")
    <!-- Datatables -->
    <script src="{{asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>


    <script type="text/javascript" src="{{asset('js/components/bs-switches.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/selectsplitter.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/currencyFormatter.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "order": [[1, "desc"]],
                responsive: true
            });

        });
        OSREC.CurrencyFormatter.formatAll(
            {
                selector: '.money',
                currency: 'CNY',
                symbol: '元',
                pattern: '#,##0!;(-#,##0!);0!'
            });
    </script>
@endsection
