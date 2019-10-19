@extends("layouts.master")

@section("head_scripts")
    <!-- Bootstrap Switch CSS -->
<link rel="stylesheet" href="{{asset('css/components/bs-switches.css')}}" type="text/css" />

<!-- Radio Checkbox Plugin -->
<link rel="stylesheet" href="{{asset('css/components/radio-checkbox.css')}}" type="text/css" />

    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="{{asset('css/components/bs-select.css')}}" type="text/css" />
@endsection

@section("main_content")

    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix" id="checkout">
                <div class="style-msg successmsg" style="display: none;">
                    <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>你好棒!</strong> <span id="checkresult"></span></div>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
                
                <div class="row clearfix">
                    <div class="col-md-12" style="text-align:right;">
                        <a href="{{route('cart_clearCart')}}" class="button button-3d button-large button-rounded button-red">清空购物车</a>
                    </div>
                </div>

                <div id="app"></div>
                {{--<checkoutform total_o_price="{{$cart->Total_O_Price}}"--}}
                              {{--total_dis_price="{!! $cart->Total_B_Price +($cart->Total_O_Price-$cart->Total_B_Price)*Session::get("user_rate") !!}"--}}
                              {{--qty="{{$cart->Total_Qty}}">--}}

                {{--</checkoutform>--}}
                {{--<checkoutform Total_O_Price="{{$cart->Total_O_Price}}"  qty="{{$cart->Total_Qty}}"></checkoutform>--}}
                <hr>
                <div class="row clearfix" id="cartsection">
                    <div class="clear bottommargin"></div>
                    <div class="col-md-6">
                        <div class="table-responsive clearfix">
                            <h4>您的订单</h4>
                            <table class="table cart">
                                <thead>
                                <tr>
                                    <th class="cart-product-thumbnail">&nbsp;</th>
                                    <th class="cart-product-name ">产品</th>
                                    <th class="cart-product-quantity hidden-xs">数量</th>
                                    <th class="cart-product-subtotal hidden-xs">总计</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cart->items as $item)
                                    <tr class="cart_item">
                                        <td class="cart-product-thumbnail">
                                            <a href="{{route("shop_product",["id"=>$item['item']->id])}}"><img width="64" height="64" src="{{asset($item['item']->thumbimage)}}" alt="Pink Printed Dress"></a>
                                        </td>

                                        <td class="cart-product-name">
                                            <a href="{{route("shop_product",["id"=>$item['item']->id])}}">{{$item["item"]->name}}</a> <br>
                                            <div class="quantity visible-xs clearfix">
                                                qty:{{$item["qty"]}} <br>
                                                subtotal: <span class=" money">{{$item["total_o_price"]}}</span>
                                            </div>
                                        </td>

                                        <td class="cart-product-quantity hidden-xs">
                                            <div class="quantity clearfix">
                                                {{$item["qty"]}}
                                            </div>
                                        </td>

                                        <td class="cart-product-subtotal hidden-xs">
                                            <span class=" money">{{$item["total_o_price"]}}</span>
                                            @role(['customerAdmin','superadmin'])
                                            <br><span class=" money" style="color: forestgreen;">{{$item["total_b_price"]}}</span>
                                            @endrole
                                            @role(['distributor'])
                                            <br><span class=" money" style="color: forestgreen;">{!! $item["total_b_price"] +($item["total_o_price"]-$item["total_b_price"])*Session::get("user_rate") !!}</span>
                                            @endrole

                                            @role(['superadmin'])
                                            <br><span class=" money_jp" style="color: red;">{{$item["total_r_price"]}}</span>
                                            @endrole
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="fright"></td>
                                        <td colspan="3" class="fright"></td>
                                        <td colspan="3" class="fright">Total:</td>
                                        <td >
                                            市场销售价格：<span class="money" style="color: green;">{{$cart->Total_O_Price}}</span> <br>


                                            @role(['customerAdmin','superadmin'])
                                            一级代理商价格：<ins><span class="money" style="color: green;">{{$cart->Total_B_Price}}</span></ins>
                                            @endrole


                                            @role(['distributor'])
                                            渠道商价格：<ins><span class="money" style="color: green;">{!! $cart->Total_B_Price +($cart->Total_O_Price-$cart->Total_B_Price)*Session::get("user_rate") !!}</span></ins>
                                            @endrole


                                            @role(['superadmin'])
                                            平台进货价格：<br><ins><span class="money_jp" style="color: darkred;">{{$cart->Total_R_Price}}</span></ins>
                                            @endrole
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                    <div class="col-md-6 center">
                        @role(['distributor','customerAdmin','customer','superadmin'])
                            <img style="width: 360px;" src="{{asset('/images/wechatpay.jpg')}}" alt="">
                        @endrole
                    </div>
                </div>
            </div>

        </div>


        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">订单处理中，请稍候......</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="orderprocessing">
                            <img width="200" src="{{asset('images/orderprocessing.gif')}}" class="img-responsive center-block">
                        </div>
                        <div id="thanksfororder" style="display: none;">
                            <img width="200" src="{{asset('images/thanksfororder.png')}}" class="img-responsive center-block" >
                        </div>
                    </div>
                    <div class="modal-footer">

                        <a href="/" id="close_btn" type="button" class="btn btn-primary" data-dismiss="modal" style="display: none;">Close</a>
                    </div>
                </div>
            </div>
        </div>

    </section><!-- #content end -->

@endsection

@section("jquery_scripts")

    <script src="{{asset('js/checkout.js')}}"></script>


@endsection
@section("jquery_afterscripts")

    <!-- Bootstrap Switch Plugin -->
    <script type="text/javascript" src="{{asset('js/components/bs-switches.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/currencyFormatter.js')}}"></script>
    <script>
        $(document).ready(function () {
                $(".bt-switch").bootstrapSwitch({
                    onSwitchChange : function(event, state) {
                        if(state==true){
                            $("#sex").val("Mr.");
                        }else{
                            $("#sex").val("Miss.");
                        }
                    }
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

