@extends("layouts.master")

@section("head_scripts")
    {{--<link rel="stylesheet" href="{{asset('vendors/DataTables/jquery.dataTables.min.css')}}" type="text/css"/>--}}
    {{--<link rel="stylesheet" href="{{asset('vendors/DataTables/Responsive-2.2.0/css/responsive.dataTables.min.css')}}"--}}
    {{--type="text/css"/>--}}
    {{--<link rel="stylesheet" href="{{asset('vendors/DataTables/Select-1.2.3/css/select.dataTables.min.css')}}" type="text/css"/>--}}
    {{----}}
    {{----}}

    <!-- Datatables -->
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">



    <link rel="stylesheet" href="{{asset('css/components/bs-switches.css')}}" type="text/css">
    <style>
        table.dataTable.stripe tbody tr.odd {
            background-color: lightgreen;
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

    <!-- Content
		============================================= -->
    <section id="content" >
        <div class="content-wrap" id="shop">

            <div class="container clearfix">

                <!-- Post Content
                ============================================= -->
                <div class="postcontent nobottommargin col_last">

                    <!-- Shop
                    ============================================= -->
                    {{--<div class="table-responsive">--}}
                        {{--<table id="example" class="display responsive nowrap center" cellspacing="0" width="100%">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th>#</th>--}}
                                {{--<th></th>--}}
                                {{--<th>有效</th>--}}
                                {{--<th>分类</th>--}}
                                {{--<th>信息</th>--}}
                                {{--@role(['viewer','customer','customerAdmin','superadmin'])--}}
                                {{--<th>价格</th>--}}
                                {{--@endrole--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--@foreach($products as $product)--}}

                                    {{--<tr id="rowID_{{$product->id}}">--}}
                                        {{--<th>{{$product->id}}</th>--}}
                                        {{--<th>--}}
                                            {{--@role(['viewer','distributor','customer','customerAdmin','superadmin'])--}}
                                            {{--<a href="#" data-toggle="modal" product_ID="{{$product->id}}" class="koun_product" data-target="#exampleModalLong">--}}
                                                {{--<img src="{{asset($product->thumbImage)}}" alt="" style="width: 100px;height: 100px;">--}}
                                            {{--</a>--}}
                                            {{--@endrole--}}
                                            {{--@role(['vendor'])--}}
                                                {{--<img src="{{asset($product->thumbImage)}}" alt="" style="width: 100px;height: 100px;">--}}
                                        {{----}}
                                            {{--@endrole--}}
                                            {{--@role(['guest'])--}}
                                            {{--<img src="{{asset($product->thumbImage)}}" alt="" style="width: 100px;height: 100px;">--}}
                                            {{--@endrole--}}


                                        {{--</th>--}}
                                        {{--<th class="center">--}}
                                            {{--@if($product->active==1)--}}
                                                {{--<i class="fa fa-bookmark text-red"></i>--}}
                                            {{--@else--}}
                                                {{--<i class="fa fa-bookmark-o"></i>--}}
                                            {{--@endif--}}
                                                {{--<br>--}}
                                                {{--<a href="{{route("shop_product",["id"=>$product->id])}}" class="btn btn-default  bt-sm" style="background-color: #1ABC9C;color: white;">详细介绍--}}

                                                {{--</a>--}}
                                        {{--</th>--}}
                                        {{--<th>--}}
                                            {{--{{$product->vendor->name}} <br>--}}
                                            {{--{{$product->catalogue->name}} <br>--}}
                                            {{--{{$product->subcatalogue->name}}--}}
                                        {{--</th>--}}
                                        {{--<th>{{$product->name}} <br>--}}
                                            {{--SKU: {{$product->product_code}}--}}
                                        {{--</th>--}}
                                        {{--@role(['viewer','customer','customerAdmin','superadmin'])--}}
                                        {{--<th>--}}
                                                {{--<span class="money">{{$product->o_price}}</span>--}}

                                            {{--@role(['customerAdmin','superadmin'])--}}
                                            {{--/--}}
                                            {{--<span class="money text-blue">{{$product->b_price}}</span>--}}
                                            {{--@endrole--}}
                                        {{--</th>--}}
                                        {{--@endrole--}}
                                    {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}

                    <!-- #shop end -->

                </div><!-- .postcontent end -->


                <!-- Sidebar
                ============================================= -->
                <div class="sidebar nobottommargin">
                    <div class="sidebar-widgets-wrap">

                        @include("parts.shopsidebar_no_subcatalogueID")

                        <div class="widget widget-filter-links clearfix">
                            <span id="addcartmessage" data-notify-type="info" data-notify-msg=""></span>
                            <h4>Sort By</h4>
                            <ul class="shop-sorting">
                                <li class="widget-filter-reset active-filter"><a href="#" data-sort-by="original-order">Clear</a></li>
                                <li><a href="#" data-sort-by="name">Name</a></li>
                                <li><a href="#" data-sort-by="price_lh">Price: Low to High</a></li>
                                <li><a href="#" data-sort-by="price_hl">Price: High to Low</a></li>
                            </ul>

                        </div>

                    </div>
                </div><!-- .sidebar end -->

            </div>

            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="single-product shop-quick-view-ajax clearfix">

                            <div class="ajax-modal-title">
                                <h2>@{{productname}}</h2>
                            </div>

                            <div class="product modal-padding clearfix">

                                <div class="col_half nobottommargin">
                                    <div class="product-image">
                                        <div class="fslider" data-pagi="false">
                                            <div class="flexslider">
                                                <div class="slider-wrap">
                                                    <a  title="">
                                                        <img :src="getimageurl(postimage)" :alt="getimageurl(postimage)">
                                                    </a>
                                                    <div class="panel panel-default product-meta nobottommargin">
                                                        <div class="panel-body">
                                            <span itemprop="productID" class="sku_wrapper">Product Code: @{{productcode}}<span
                                                        class="sku"></span></span>
                                                            <span class="posted_in">Category: <a class="tag">@{{catalogue}} -- </a> <a
                                                                        href="http://localhost/offbeat/wp/product-category/shoes/"
                                                                        rel="tag">@{{subcatalogue}}</a>.</span>
                                                            <span class="tagged_as">Tags: <a
                                                                        href="http://dante.swiftideas.net/product-tag/barena/" rel="tag">Barena</a>, <a
                                                                        href="http://dante.swiftideas.net/product-tag/blazers/" rel="tag">Blazers</a>, <a
                                                                        href="http://dante.swiftideas.net/product-tag/tailoring/" rel="tag">Tailoring</a>, <a
                                                                        href="http://dante.swiftideas.net/product-tag/unconstructed/"
                                                                        rel="tag">Unconstructed</a>.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sale-flash">Sale!</div>
                                    </div>
                                </div>
                                <div class="col_half nobottommargin col_last product-desc">
                                    <div class="product-price">
                                        <ins> @{{ o_price | currencyFormat}}</ins>
                                    </div>
                                    <div class="product-rating">
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                        <i class="icon-star-half-full"></i>
                                        <i class="icon-star-empty"></i>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="line"></div>

                                    <!-- Product Single - Quantity & Cart Button
                                    ============================================= -->
                                    <form class="cart nobottommargin clearfix" method="post" enctype='multipart/form-data'>
                                        <div class="quantity clearfix">
                                            <button type="button" class="minus" v-on:click="removeItem"> -</button>
                                            <button type="button" class="qty">@{{ qty }}</button>
                                            <button type="button" class="plus" v-on:click="addItem"> +</button>

                                        </div>
                                        <button type="button" class="add-to-cart button nomargin" data-dismiss="modal" id="add2cart">Add to
                                            cart
                                        </button>
                                    </form><!-- Product Single - Quantity & Cart Button End -->

                                    <div class="clear"></div>
                                    <div class="line"></div>
                                    <p id="efficacy">@{{efficacy}}</p>

                                    <button type="button" class="button button-3d nomargin button-black" data-dismiss="modal" >Close</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- #content end -->
@endsection

@section("jquery_scripts")

    <script src="{{asset('js/shop.js')}}"></script>
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
    {{--<script src="{{asset('vendors/jszip/dist/jszip.min.js')}}"></script>--}}
    {{--<script src="{{asset('vendors/pdfmake/build/pdfmake.min.js')}}"></script>--}}
    {{--<script src="{{asset('vendors/pdfmake/build/vfs_fonts.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('js/components/bs-switches.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/selectsplitter.js')}}"></script>



    <script type='text/javascript' src="{{asset('js/currencyFormatter.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });

        OSREC.CurrencyFormatter.formatAll(
            {
                selector: '.money_jp',
                currency: 'JPY',
                symbol: '円',
                pattern: '#,##0!;(-#,##0!);0!'
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

