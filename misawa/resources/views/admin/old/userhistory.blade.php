@extends("layouts.master")

@section("head_scripts")
    <!-- Datatables -->
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <style>
        #visitors tbody tr.odd {
            background-color: lightgrey;
        }

        #browseranking tbody tr.odd {
            background-color: lightgrey;
        }

        .itemtitle{
            width:50%;
            text-align: right;
        }
        .itemcontent{
            text-align: right;
        }
        span.money span.money_jp{
            margin-left:5px;
            padding:0 5px;
        }
    </style>
@endsection

@section("main_content")

    <!-- Page Sub Menu
		============================================= -->
    @include("parts.pagemenu_admin")

    <!-- Content
		============================================= -->
    <section id="content" >
        <div class="content-wrap" id="shop">

            <div class="container clearfix">

                <div class="col_full clearfix">
                    <div class="widget clearfix">
                        <h4>Message to <span>Members</span></h4>
                        <div class="input-group divcenter">
                            <input type="text" class="form-control" v-model="toAllMessage" @keyup.enter="sendmessage" placeholder="message to all members" required="">
                            <span class="input-group-btn">
											<button class="btn btn-success" type="button" v-on:click="sendmessage" ><i class="icon-email2"></i></button>
										</span>
                        </div>
                    </div>
                </div><!-- .sidebar end -->

                <div class="col_full">
                    <h2>{!! $user->name !!}</h2>
                    <h3>Recent Browse History</h3>
                    <div class="table-responsive">
                        <table id="visitors" class="display responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>image</th>
                                <th>Product</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($browseitems as $browseitem)
                                <tr>
                                    <th>{{$browseitem->id}}
                                    </th>
                                    <th>{{$browseitem->created_at}}
                                    </th>
                                    <th>
                                        <img src="{{asset($browseitem->product["thumbImage"])}}" width="80">
                                    </th>
                                    <th>
                                        {{$browseitem->product["name"]}}(#{{$browseitem->product["id"]}})
                                    </th>
                                    <th>
                                        <span class="money">{{$browseitem->product["o_price"]}}</span><br>
                                        <span class="money">{{$browseitem->product["b_price"]}}</span><br>
                                        <span class="money_jp">{{$browseitem->product["r_price"]}}</span>

                                    </th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- #content end -->

@endsection

@section("jquery_scripts")

    <!-- Charts JS
	============================================= -->
    <script type="text/javascript" src="{{asset('js/chart.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/chart-utils.js')}}"></script>

    <script src="{{asset('js/admin_vue.js')}}" type="text/javascript" ></script>
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
    <script type='text/javascript' src="{{asset('js/currencyFormatter.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#visitors').DataTable({
                "order": [[1, "desc"]],
                responsive: true
            });
            $('#browseranking').DataTable({
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

        OSREC.CurrencyFormatter.formatAll(
            {
                selector: '.money_jp',
                currency: 'JPY',
                symbol: '円',
                pattern: '#,##0!;(-#,##0!);0!'
            });


    </script>


@endsection