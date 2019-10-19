@extends("layouts.blank_master")

@section("head_scripts")
    <link href="https://fonts.googleapis.com/earlyaccess/sawarabimincho.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/earlyaccess/hannari.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <style>

        body {
            background: rgb(255, 255, 255);
            margin: 0 auto;
            width: 21cm;
            height: 29.7cm;
            color: rgb(0, 16, 40);
            font-family: 'Noto Sans JP',Arial, sans-serif;
            position: relative;
            border: solid 2px dimgrey;
            box-shadow: 10px 20px 5px 5px #888888;
        }
    </style>
@endsection



@section("main_content")



    <!-- Content
		============================================= -->
    <section id="content">
        <div class="content-wrap" id="shop" style="padding:5px 10px;">

            <div class="center clearfix">

                <div class="nobottommargin clearfix">
                    <div class="col_half bottommargin-sm">
                        <a href="/">
                            <img class="logo_image" src="{{asset('images/logo.jpg')}}" style="width: 50%;" alt="logo">
                        </a>
                        <DIV>
                            <span class="sub_title">For all the people love you</span> <br>
                            <strong>KPZH Health Management Co.,LTD</strong> <br>
                            <span>8-2, Wealth and Finance Center, 2 fortune Avenue, Chongqing, China</span>
                        </DIV>
                    </div>
                    <div class="col_half col_last purchase_order bottommargin-sm">PURCHASE ORDER</div>
                </div>

                <div id="order_info" >
                    <div class="col_half text-left">
                            <h3 class="nobottommargin">TO: {{$vendor->name}} Pharmacy</h3>
                        <blockquote>
                            <DIV id="company">
                                <DIV><SPAN>P.O. NO:</SPAN> #{{$po->id}}</DIV>
                                <DIV><SPAN>DATE:</SPAN> {{$po->created_at}}</DIV>
                            </DIV>
                        </blockquote>
                    </div>
                    <div class="col_half col_last nobottommargin">
                        <h3 class="nobottommargin text-left">SHIP TO: </h3>
                        <blockquote>
                            <DIV class="item"><SPAN>Name:</SPAN>{!! $customer->sex !!}{!! $customer->name !!}</DIV>
                            <DIV class="item"><SPAN>Zipcode:</SPAN> {!! $customer->postcode !!}</DIV>
                            <DIV class="item"><SPAN>Address:</SPAN>{!! $customer->address1 !!}</DIV>
                            <DIV class="item"><SPAN></SPAN>{!! $customer->address2 !!}</DIV>
                            <DIV class="item"><SPAN>Email:</SPAN> {!! $customer->email !!}</DIV>
                            <DIV class="item"><SPAN>Phone:</SPAN> {!! $customer->phone !!}</DIV>
                        </blockquote>
                        <DIV class="ship_to">
                        </DIV>
                    </div>
                </div>
                <div class="clear"></div>

                <div class="col_full clearfix nobottommargin hidden-xs">
                    <table class="table">
                        <thead>
                        <tr style="background-color: darkseagreen;">
                            <th class="cart-product-thumbnail">&nbsp;</th>
                            <th class="cart-product-name center">Product</th>
                            <th class="cart-product-name center">Price</th>
                            <th class="cart-product-quantity center">Quantity</th>
                            <th class="cart-product-subtotal center">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cart_items as $item)
                            <tr class="cart_item">
                                <td class="print_po_thumbimage">
                                    <a href="#"><img src="{{asset($item->product->thumbImage)}}"
                                                     alt="Pink Printed Dress"></a>
                                </td>

                                <td class="print_po-product-name">
                                    <a href="#">{{$item->product->name_jp}}</a> <br>
                                    SKU: {{$item->product->product_code}} <br>
                                    メーカー： {{$item->product->manufactory}} 
                                </td>
                                
                                
                                <td class="print_po-product-name">
                                    <span class="money_jp">{{$item->product->r_price}}</span>
                                </td>

                                <td class="print_po-product-quantity">
                                    {{$item->qty}}
                                </td>

                                <td class="print_po-product-subtotal">
                                    <span class="money_jp">{{$item->total_r_price}}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3" style="text-align: right;background-color: forestgreen;color: white;">Total</th>
                            <th  style="text-align: right;background-color: forestgreen;color: white;">{{$po->Total_Qty}}</th>
                            <th style="text-align: right;background-color: forestgreen;color: white;">
                                <span class="money_jp">{{$po->cart_R_Price}}</span>
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col_full panel panel-primary text-left nobottommargin">
                    <div class="panel-heading">
                        <h2 class="panel-title ">Memo</h2>
                    </div>
                    <div class="panel-body">
                        {{$po->memo}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- #content end -->


@endsection

@section("jquery_scripts")


@endsection

@section("jquery_afterscripts")
    <script type='text/javascript' src="{{asset('js/currencyFormatter.js')}}"></script>

    <script>
        OSREC.CurrencyFormatter.formatAll(
            {
                selector: '.money_jp',
                currency: 'JPY',
                symbol: '円',
                pattern: '¥#,##0!;(-#,##0!);0!'
            });
    </script>
@endsection
