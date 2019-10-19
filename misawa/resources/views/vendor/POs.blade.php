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
        table.dataTable.stripe tbody tr.odd {
            background-color: #f1f1f1;
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
    @include("parts.pagemenu_vendor")



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
                                        <div class="fancy-title title-center">
                                            <h4>全部注文情報</h4>
                                            <table class="display responsive nowrap" >
                                                <tbody>
                                                <tr>
                                                    <td class="itemtitle">注文数量: </td>
                                                    <td class="itemcontent">{{$total->po_count}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle">販売金額: </td>
                                                    <td class="itemcontent"><span class="money_jp">{{ $total->total_R_price }}</span></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <h4>今月分</h4>
                                            <table class="display responsive nowrap" >
                                                <tbody>
                                                <tr>
                                                    <td class="itemtitle">注文数量: </td>
                                                    <td class="itemcontent">{{$thismonthSummary !=null ?$thismonthSummary->po_count:0}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="itemtitle">販売金額: </td>
                                                    <td class="itemcontent"><span class="money_jp">{{ $thismonthSummary !=null ?$thismonthSummary->total_R_price:0 }}</span></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                                <div class="col_half col_last nobottommargin clearfix">
                                        <div class="col_full center">

                                        </div>
                                        <div class="col_half center">
                                            <div class="rounded-skill nobottommargin" data-color="#DD4B39" data-size="120"
                                                                   data-percent="{{$paidRate}}" data-width="8" data-speed="2500">
                                                <i class="fa fa-user-circle-o" style="color:green;"></i>
                                            </div>
                                            <h4>支払い率:{{$paidRate}}%</h4>
                                            <h4 style="color: darkred;">未支払金額 : <span class="money_jp">{{$unpaidVendor}}</span></h4>
                                        </div>
                                </div>
                            </div>
                        <table id="example" class="display responsive nowrap stripe" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="text-align: center;">日付</th>
                                <th class="center">顧客</th>
                                <th  class="center">数量</th>
                                <th>金額</th>
                                <th class="center">ステータス</th>
                                <th class="center">支払い</th>
                                <th class="center">注文書</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mypos as $mypo)
                                <tr id="rowID_{{$mypo->id}}">
                                    <th><span class="button button-3d button-small button-rounded button-green koun_po">#{{$mypo->id}}</span></th>
                                    <th>{{$mypo->created_at}}</th>
                                    <th class="center">
                                        {{$mypo->customer->name}}<br>
                                        {{$mypo->user->name}}<i class="fa fa-long-arrow-right"></i>{{$mypo->vendor->name}}
                                    </th>
                                    <th class="center" style="text-align: right;">
                                        {{$mypo->cart_Qty}}
                                    </th>
                                    <th style="text-align: right;">
                                        <span class="money_jp">{{$mypo->cart_R_Price}}</span>
                                    </th>
                                    <th class="status center">
                                        @if($mypo->status == "new")
                                            <a  target="_blank" href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1={!! $mypo->delivery_no !!}&x=18&y=11">
                                                <span class="label label-default">{{$mypo->status}}</span>
                                            </a>

                                        @elseif($mypo->status == "processing")
                                            <a  target="_blank" href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1={!! $mypo->delivery_no !!}&x=18&y=11">
                                                <span class="label label-warning">{{$mypo->status}}</span>
                                            </a><br>
                                            <a  href="#" class="bt-editable ems_code_input" data-name="{{$mypo->id}}"
                                               data-placeholder="Require ems code ">{{$mypo->delivery_no}}</a>

                                        @elseif($mypo->status == "Delivering")
                                            <a   target="_blank" href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1={!! $mypo->delivery_no !!}&x=18&y=11">
                                                <span class="label label-primary">{{$mypo->status}}</span>
                                            </a><br>
                                            <a href="#" class="bt-editable ems_code_input" data-name="{{$mypo->id}}"
                                               data-placeholder="Require ems code ">{{$mypo->delivery_no}}</a>
                                        @elseif($mypo->status == "completed")
                                            <a  target="_blank" style="display: block;" href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1={!! $mypo->delivery_no !!}&x=18&y=11">
                                                <span class="label label-success">{{$mypo->status}}</span>
                                            </a><br>
                                            <a href="#">{{$mypo->delivery_no}}</a>
                                        @elseif($mypo->status == "Sendback")
                                            <a   target="_blank" href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1={!! $mypo->delivery_no !!}&x=18&y=11">
                                                <span class="label label-danger">{{$mypo->status}}</span>
                                            </a><br>
                                            <a href="#">{{$mypo->delivery_no}}</a>
                                        @endif
                                    </th>
                                    <th class="paid_customer center">
                                        @if($mypo->paid_vendor==1)
                                            <i class="fa fa-check-circle-o" style="color: green;"></i>
                                        @else
                                            <i class="fa fa-times-circle-o" style="color: red;"></i>
                                        @endif
                                    </th>
                                    <th><a href="{{route('vendor_printPO',["poid"=>$mypo->id])}}" class="button button-border button-rounded button-green"><i class="icon-book3"></i>ダウンロード</a></th>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="8" style="text-align: center;background-color: dimgrey;color: white;">いつものご協力をいただき、誠にありがとうございます！</th>
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
                        <h3 class="modal-title" id="myModalLabel">注文書（＃@{{ po.id }}）</h3>
                    </div>
                    <div class="modal-body">
                        <div class="col_half nobottommargin">
                            <div class="title-block ">
                                <h4>顧客:</h4>
                                <span>@{{customer.name}}</span>
                                <span>@{{customer.postcode}}</span>
                                <span>@{{customer.address1}}</span>
                                <span>@{{customer.address2}}</span>
                            </div>
                        </div>
                        <div class="col_half col_last nobottommargin hidden-xs">
                            <div class="title-block ">
                                <div class="table-responsive">
                                <div class="hidden-xs">
                                    <h4>合計:</h4>
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
                                            <td class="cart-product-name"><strong>金額</strong></td>
                                            <td class="cart-product-name"><strong><span
                                                            class="amount color lead">@{{po.cart_R_Price | currencyFormatter}} </span></strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col_full clear-fix nobottommargin hidden-xs">
                            <table class="table cart">
                                <thead>
                                <tr>
                                    <th class="cart-product-thumbnail">&nbsp;</th>
                                    <th class="cart-product-name">製品</th>
                                    <th class="cart-product-quantity">数量</th>
                                    <th class="cart-product-subtotal">合計</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="cart_item" v-for="poitem in items">
                                    <td class="cart-product-thumbnail">
                                        <a href="#"><img width="64" height="64"
                                                         v-bind:src="poitem.item.thumbimage"
                                                         alt="Pink Printed Dress"></a>
                                    </td>

                                    <td class="cart-product-name">
                                        <a href="#">@{{poitem.item.name_jp}}</a>
                                    </td>

                                    <td class="cart-product-quantity">
                                        <div class="quantity clearfix">
                                            @{{poitem.qty}}
                                        </div>
                                    </td>

                                    <td class="cart-product-subtotal">
                                        <span class="amount">@{{poitem.total_r_price | currencyFormatter}}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col_full clear-fix">
                            <div class="col_half "></div>
                            <div class="col_half col_last nobottommargin">
                                <div><a href="#"  data-dismiss="modal" class="button button-circle">Close</a>
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

    <script src="{{asset('js/po_vendor.js')}}"></script>

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
    <!-- Bootstrap Editable Plugin -->
    <script type="text/javascript" src="{{asset('js/components/bs-editable.js')}}"></script>

    <script type='text/javascript' src="{{asset('js/currencyFormatter.js')}}"></script>

    <script>

        var token = '{{Session::token()}}';
        var url_vendor_setEMScode = "{{route('vendor_setEMScode')}}";

        $(document).ready(function () {
            $('#example').DataTable({
                "order": [[1, "desc"]],
                responsive: true
            });
        });


        var $elems = $('.ems_code_input');
        $elems.editable({
            type:  'text',
            pk:    1,
            url:   url_vendor_setEMScode,
            params:{
                _token: token
            },
            title: 'EMScodeを入力してください'
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
