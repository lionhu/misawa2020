@extends("layouts.master")

@section("head_scripts")
    <!-- Datatables -->
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/components/bs-switches.css')}}" type="text/css">

    <!-- Bootstrap Editable Plugin -->
    <link rel="stylesheet" href="{{asset('css/components/bs-editable.css')}}" type="text/css" />
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

    <!-- Page Sub Menu
		============================================= -->
    @include("parts.pagemenu_admin")

    <!-- Content
		============================================= -->
    <section id="content">
        <div class="content-wrap" id="shop">

            <div class="container clearfix">

                <div class="nobottommargin clearfix">
                    <div class="table-responsive">
                        <a href="" id="pagemessage"></a>
                        <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="text-align: center;">Date <br>
                                    {{--<i class="fa fa-user-circle-o"></i> <i class="fa fa-long-arrow-right"></i><i class="fa fa-hospital-o"></i>--}}
                                </th>
                                <th class="center">Customer</th>
                                <th  class="center">Qty</th>
                                <th>Price</th>
                                <th class="center">Status</th>
                                <th class="center">Pay Customer</th>
                                <th class="center">Pay Vendor</th>
                                <th class="center">Pay Margin</th>
                                <th class="center">Operation</th>
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
                                        <a href="{{route('admin_printPO',['poid'=>$mypo->id])}}">
                                            <i class="fa fa-file-powerpoint-o fa-2" aria-hidden="true"></i></a>
                                        <a href="{{route('admin_print_VendorPO',['poid'=>$mypo->id])}}" style="color: red;">
                                            <i class="fa fa-file-powerpoint-o fa-2" aria-hidden="true"></i></a>
                                    </th>
                                    <th>
                                        {{$mypo->created_at}}

                                    </th>
                                    <th class="center">
                                        {{$mypo->customer["name"]}}<br>
                                        {{$mypo->user["name"]}}<i class="fa fa-long-arrow-right"></i>
                                        <span class="vendor">{{$mypo->vendor["name"]}}</span>

                                    </th>
                                    <th class="center" style="text-align: right;">{{$mypo->cart_Qty}}</th>
                                    <th style="text-align: right;">
                                        <span class="money">{{$mypo->cart_O_Price}}</span>
                                        <h5 class="nobottommargin"><span class="money">{{$mypo->cart_B_Price}}</span></h5>
                                        <h5 class="nobottommargin"><span class="money_jp">{{$mypo->cart_R_Price}}</span></h5>
                                    </th>
                                    <th class="status center">
                                        <a  target="_blank" class="btn btn-sm" href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1={!! $mypo->delivery_no !!}&x=18&y=11">
                                            
                                            @if($mypo->status == "new")
                                                <span class="label label-default">{{$mypo->status}}</span>
    
                                            @elseif($mypo->status == "processing")
    
                                                <span class="label label-warning">{{$mypo->status}}</span>
                                            @elseif($mypo->status == "Delivering")
                                                <span class="label label-primary">{{$mypo->status}}</span>
                                            @elseif($mypo->status == "completed")
                                                <span class="label label-success">{{$mypo->status}}</span>
                                                
    
                                            @elseif($mypo->status == "Sendback")
                                                <span class="label label-danger">{{$mypo->status}}</span>
                                            @endif
                                            <br>
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
                                    <th class="paid_vendor center">
                                        @if($mypo->paid_vendor==1)
                                            <i class="fa fa-check-circle-o" style="color: green;"></i>
                                        @else
                                            <i class="fa fa-times-circle-o" style="color: red;"></i>
                                        @endif
                                    </th>


                                    <th class="center">
                                        @if($mypo->cart_Dis_Price > $mypo->cart_B_Price)
                                            <span class="paid_margin">
                                                @if($mypo->paid_margin==1)
                                                    <i class="fa fa-check-circle-o" style="color: green;"></i><br>
                                                @else
                                                    <i class="fa fa-times-circle-o" style="color: red;"></i><br>
                                                @endif
                                            </span>
                                            <span class="money">{!! $mypo->cart_Dis_Price !!}</span> <br>

                                            <span class="money">{!! $mypo->cart_Dis_Price - $mypo->cart_B_Price !!}</span>
                                        @endif

                                    </th>
                                    <th>
                                        <a href="{{route('admin_editPO',['poid'=>$mypo->id])}}">Edit</a>
                                    </th>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="9" style="text-align: center;background-color: dimgrey;color: white;">Good Work!</th>
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
                        <h2 class="modal-title" id="myModalLabel">Order Information <small>(# <span id="poid"> @{{po.id }}</span>)</small> </h2>
                        <h4 class="modal-title">渠道商: @{{user.name}}(@{{user.email}})</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col_half nobottommargin">
                            <div class="title-block ">
                                <h4>Customer:@{{customer.name}}</h4>
                                <span>Postcode: @{{customer.postcode}}</span>
                                <span>Address: @{{customer.address1}}</span>
                                <span>@{{customer.address2}}</span>
                                <span>TEL: @{{customer.phone}}</span>
                                <span>Mail: @{{customer.email}}</span>
                            </div>
                        </div>
                        <div class="col_half col_last nobottommargin hidden-xs">

                            <div class="table-responsive">
                                <div class="hidden-xs">
                                    <h4>Cart Totals:</h4>
                                    <table class="table cart">
                                        <tbody>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Item Count</strong>
                                            </td>
                                            <td class="cart-product-name"><span class="amount">@{{po.cart_Qty}}</span>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td class="cart-product-name"><strong>Total</strong></td>
                                            <td class="cart-product-name"><strong><span
                                                            class="amount color lead">@{{po.cart_O_Price | currencyFormatter}} </span></strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                        <div class="col_full clear-fix nobottommargin hidden-xs">
                            <table class="table cart">
                                <thead>
                                <tr>
                                    <th class="cart-product-thumbnail">&nbsp;</th>
                                    <th class="cart-product-name">Product</th>
                                    <th class="cart-product-quantity">Quantity</th>
                                    <th class="cart-product-subtotal">Total</th>
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
                            <div class="col_one_third ">
                                <div class="col_full nobottommargin clear-fix">
                                    <label for="status" >重发通知邮件</label>
                                    <select id="resentMailType" class="col_full">
                                        <option value="">请选择信息种类</option>
                                        <option value="new">New Order</option>
                                        <option value="Order2Vendor">Place Order to vendor</option>
                                        <option value="OrderDeliverPackage">Delivering</option>
                                        <option value="Sendback">Sendback</option>
                                        <option value="OrderCompleted">Complete</option>
                                        <option value="notificationPayBill">支付通知</option>
                                    </select>
                                    <select id="resentMailReceiver" class="col_full">
                                        <option value="">请选择接受人</option>
                                        <option value="superadmin">超级管理员</option>
                                        <option value="customer">最终客户</option>
                                        <option value="distributor">渠道商</option>
                                        <option value="vendor">药房</option>
                                    </select>
                                </div>
                                <span style="color: red;" id="returnMessage"></span>
                                <a href="#"  class="button button-circle" id="resentMailButton" v-on:click="resentPOMail">Resend Mail</a>
                            </div>
                            <div class="col_one_third">
                                <div class="col_half nobottommargin">
                                    <label for="paid_vendor">Pay Vendor:</label>
                                    <div class="switch center">
                                        <input id="paid_vendor" class="switch-toggle switch-rounded switch-toggle-round"
                                               v-model="po.paid_vendor" name="paid_vendor" type="checkbox">
                                        <label for="paid_vendor">@{{ po.paid_vendor }}</label>
                                    </div>
                                </div>
                                <div class="col_half col_last nobottommargin">
                                    <label>Pay Customer:</label>
                                    <div class="switch center">
                                        <input id="paid_customer"
                                               class="switch-toggle switch-rounded switch-toggle-round"
                                               v-model="po.paid_customer" name="paid_customer"  type="checkbox">
                                        <label for="paid_customer">@{{ po.paid_customer }}</label>
                                    </div>
                                </div>
                                <div class="col_half  nobottommargin">
                                    <label>Pay margin:</label>
                                    <div class="switch center">
                                        <input id="paid_margin"
                                               class="switch-toggle switch-rounded switch-toggle-round"
                                               v-model="po.paid_margin" name="paid_margin"  type="checkbox">
                                        <label for="paid_margin">@{{ po.paid_margin }}</label>
                                    </div>
                                </div>
                                <a href="#" class="button button-circle" v-on:click="updatePOPayment">Update Payment</a>

                                <div class="col_full clear-fix fright">
                                    <a href="#" data-dismiss="modal" class="button button-circle button-red" v-on:click="deletePO">Delete PO</a>
                                    <a href="#"  data-dismiss="modal" class="button button-circle">Close</a>
                                </div>
                            </div>
                            <div class="col_one_third col_last nobottommargin">
                                <div class="col_full nobottommargin clear-fix">
                                    <select v-model="po.vendor_id" name="vendor" class="col_full">
                                        <option disabled>请选择</option>
                                        <option value="1">KOUN</option>
                                        <option value="2">Misawa</option>
                                        <option value="3">Misawa OTC</option>
                                    </select>

                                    <a href="#" data-dismiss="modal" class="button button-circle" v-on:click="updatePOVendor">改变供应商</a>

                                </div>
                                <div class="col_full nobottommargin clear-fix">
                                    <label for="status" >改变订单状态</label>
                                    <select v-model="po.status" name="status" class="col_full">
                                        <option disabled>请选择</option>
                                        <option value="new">New</option>
                                        <option value="processing">Place Order</option>
                                        <option value="Delivering">Delivering</option>
                                        <option value="Sendback">Sendback</option>
                                        <option value="completed">Complete</option>
                                    </select>
                                    <a href="#" data-dismiss="modal" class="button button-circle" v-on:click="updatePOStatus">Update PO</a>

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
    <!-- Bootstrap Editable Plugin -->
    <script type="text/javascript" src="{{asset('js/components/bs-editable.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "order": [[1, "desc"]],
                responsive: true
            });


            var token = '{{Session::token()}}';
            var url_vendor_setEMScode = "{{route('admin_setEMScode')}}";

            var $elems = $('.ems_code_input');
            $elems.editable({
                type:  'text',
                pk:    1,
                url:   url_vendor_setEMScode,
                params:{
                    _token: token
                },
                title: 'Enter EMS code'
            });
        });



        OSREC.CurrencyFormatter.formatAll(
            {
                selector: '.money',
                currency: 'CNY',
                symbol: '元',
                pattern: '#,##0!;(-#,##0!);0!'
            });
        OSREC.CurrencyFormatter.formatAll(
            {
                selector: '.money_jp',
                currency: 'JPY',
                symbol: '円',
                pattern: '#,##0!;(-#,##0!);0!'
            });
    </script>
@endsection
