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
                            <div id="summary">

                                <div class="col_half">
                                    <div class="well well-lg nobottommargin">
                                        <div class="fancy-title title-center">
                                            <h3>All Orders</h3>
                                            <table class="display responsive nowrap" >
                                                <tbody>
                                                <tr>
                                                    <td class="itemtitle">Total Qty: </td>
                                                    <td class="itemcontent">{{$summary_all->po_count}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle">Total Sales Amount: </td>
                                                    <td class="itemcontent"><span class="money">{{ $summary_all->O_price }}</span></td>
                                                </tr>
                                                <tr style="margin-top: 1em;">
                                                    <td class="itemtitle"><strong>Total Customer Pay:</strong></td>
                                                    <td class="itemcontent"><span class="money">{{ $summary_all->B_price }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle">Paid: </td>
                                                    <td class="itemcontent"><span class="money">{{ $summary_all->Paid_Customer }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle">Unpaind: </td>
                                                    <td class="itemcontent"><strong><span class="money" style="color: red;">{{ $summary_all->Unpaid_Customer }}</span></strong></td>
                                                </tr>
                                                <tr style="margin-top: 1em;">
                                                    <td class="itemtitle"><strong>Total Vendor Pay:</strong></td>
                                                    <td class="itemcontent"><span class="money_jp">{{ $summary_all->R_price }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle">Paid: </td>
                                                    <td class="itemcontent"><span class="money_jp">{{ $summary_all->Paid_Vendor }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle">Unpaind: </td>
                                                    <td class="itemcontent"><strong><span class="money_jp" style="color: red;">{{ $summary_all->Unpaid_Vendor }}</span></strong></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col_half col_last clearfix">
                                        <div class="col_full center">

                                            <h3>This Month</h3>
                                            <table style="margin:0 auto;" class="display responsive nowrap" >
                                                <tbody>
                                                <tr>
                                                    <td class="itemtitle">Total Qty: </td>
                                                    <td class="itemcontent">{{$summary_thismonth->po_count}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle">Total Sales Amount: </td>
                                                    <td class="itemcontent"><span class="money">{{ $summary_thismonth->O_price }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle"> <strong>Total Customer Pay:</strong> </td>
                                                    <td class="itemcontent"><span class="money">{{ $summary_thismonth->B_price }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle">Paid: </td>
                                                    <td class="itemcontent"><span class="money">{{ $summary_thismonth->Paid_Customer }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle">Unpaind: </td>
                                                    <td class="itemcontent"> <strong><span class="money" style="color: red;">{{ $summary_thismonth->Unpaid_Customer }}</span></strong> </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col_half center">
                                            <div class="rounded-skill nobottommargin" data-color="#DD4B39" data-size="120"
                                                                   data-percent="{{$all_payrate_customer}}" data-width="8" data-speed="2500">
                                                <i class="fa fa-user-circle-o" style="color:green;"></i>
                                            </div>
                                            <h4>Customer Paid Rate: <br> {{$all_payrate_customer}}%</h4>
                                        </div>
                                        <div class="col_half col_last center clearfix">

                                            <div class="rounded-skill nobottommargin" data-color="#DD4B39" data-size="120"
                                                 data-percent="{{$all_payrate_vendor}}" data-width="8" data-speed="2500">
                                                <i class="fa fa-hospital-o" style="color:green;"></i>
                                            </div>
                                            <h4>Vendor Paid Rate: <br> {{$all_payrate_vendor}}%</h4>
                                        </div>
                                </div>
                            </div>
                        <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                            
                                <th  class="center">#</th>
                                <th style="text-align: center;">Date</th>
                                <th class="center">Customer</th>
                                <th  class="center">Qty</th>
                                <th>Price</th>
                                <th class="center">Status</th>
                                <th class="center">Pay Customer</th>
                                <th class="center">Pay Vendor</th>
                                <th class="center">Pay Margin</th>
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
                                        {{$mypo->customer["name"]}}<br>
                                        {{$mypo->user["name"]}}<i class="fa fa-long-arrow-right"></i>{{$mypo->vendor["name"]}}
                                    </th>
                                    <th class="center" style="text-align: right;">{{$mypo->cart_Qty}}</th>
                                    <th style="text-align: right;">
                                        <span class="money">{{$mypo->cart_O_Price}}</span>
                                        <h5 class="nobottommargin"><span class="money">{{$mypo->cart_B_Price}}</span></h5>
                                        <h5 class="nobottommargin"><span class="money_jp">{{$mypo->cart_R_Price}}</span></h5>
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
                                        <a  target="_blank" class="btn btn-primary btn-sm" href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1={!! $mypo->delivery_no !!}&x=18&y=11">
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
                                            <span class="money">{!! $mypo->cart_Dis_Price !!}</span> <br>
                                            @if($mypo->paid_margin==1)
                                                <i class="fa fa-check-circle-o" style="color: green;"></i>
                                            @else
                                                <i class="fa fa-times-circle-o" style="color: red;"></i>
                                            @endif
                                                
                                                <span class="money" style="color:red;">{!! $mypo->cart_Dis_Price - $mypo->cart_B_Price !!}</span>
                                        @endif

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
                        <h2 class="modal-title" id="myModalLabel">Order Information</h2>
                        <h4 class="modal-title">Order ID: #<span id="poid">@{{ po.id }}</span>, By User: @{{user.name}}(#@{{user.id}})</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col_half nobottommargin">
                            <div class="title-block ">
                                <h4>Customer:@{{customer.name}}</h4>
                                <span>@{{customer.postcode}}</span>
                                <span>@{{customer.address1}}</span>
                                <span>@{{customer.address2}}</span>
                                <span>@{{customer.email}}</span>
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
                                                         v-bind:src="'/'.getimgURL(poitem.item.thumbimage)"
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
                                        <option value="OrderåCompleted">Complete</option>
                                    </select>
                                    <select id="resentMailReceiver" class="col_full">
                                        <option value="">请选择接受人</option>
                                        <option value="customer">Customer</option>
                                        <option value="vendor">Vendor</option>
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
                                <a href="#" class="button button-circle" v-on:click="updatePOPayment">Update Payment</a>
                                
                                <div class="col_full clear-fix fright">
                                    <a href="#" data-dismiss="modal" class="button button-circle button-red" v-on:click="deletePO">Delete PO</a>
                                    <a href="#"  data-dismiss="modal" class="button button-circle">Close</a>
                                </div>
                            </div>
                            <div class="col_one_third col_last nobottommargin">
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
