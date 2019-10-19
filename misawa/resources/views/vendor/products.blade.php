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
        #example tr.odd {
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
    @include("parts.pagemenu_vendor")

    <!-- Content
		============================================= -->
    <section id="content" >
            <div class="content-wrap" id="shop">

                <div class="container clearfix">

                    <!-- Post Content
                    ============================================= -->
                    <div class=" nobottommargin col_full">

                        <!-- Shop
                        ============================================= -->
                        <div class="table-responsive">
                            <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>販売中</th>
                                    <th>種類/次種類</th>
                                    <th>情報</th>
                                    <th>価格</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr id="rowID_{{$product->id}}">
                                        <th style="text-align:center;">
                                            <a href="#" productid="{{$product->id}}" data-toggle="modal" data-target="#exampleModalLong" class="koun_product">{{$product->id}}</a>

                                        </th>
                                        <th>

                                            <img src="{{asset($product->thumbImage)}}" alt="" style="width: 100px;height: 100px;">
                                        </th>
                                        <th class="center">
                                            @if($product->active==1)
                                                <i class="fa fa-bookmark text-red"></i>
                                            @else
                                                <i class="fa fa-bookmark-o"></i>
                                            @endif
                                        </th>
                                        <th>
                                            {{$product->catalogue->name}}
                                            <br>
                                            {{$product->subcatalogue->name}}
                                        </th>
                                        <th>{{$product->name_jp}} <br>
                                            code: {{$product->product_code}}
                                        </th>
                                        <th >
                                            <span class="money_jp">{{$product->r_price}}</span>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- #shop end -->

                    </div><!-- .postcontent end -->

{{--                    @include("parts.adminsidemenu")--}}

                </div>
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="single-product shop-quick-view-ajax clearfix">

                                <div class="ajax-modal-title">
                                    <h2>@{{ product.name_jp }}<small>(ID: @{{ product.id }})</small></h2>
                                    <h4 class="nobottommargin">@{{ product.name }}</h4>

                                </div>

                                <div class="product modal-padding clearfix">

                                    <div class="col_half nobottommargin">
                                        <div class="product-image">
                                            <div class="fslider" data-pagi="false">
                                                <div class="flexslider">
                                                    <div class="slider-wrap ribbon_box3">
                                                        <div class="ribbon_area">
                                                            <span class="ribbon15">NEW</span>
                                                        </div>
                                                        {{--<div class="slide">--}}
                                                        <a  title="">
                                                            <img :src="getimgURL(product.postimage)" alt="">
                                                        </a>
                                                        {{--</div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="panel panel-default product-meta ">
                                            <div class="panel-body">
                                            <span itemprop="productID" class="sku_wrapper">Product Code: @{{ product.product_code }}<span
                                                        class="sku"></span></span>
                                                <span class="posted_in">Category: <a class="tag"> @{{ catalogue.name }}-- </a> <a
                                                            href="http://localhost/offbeat/wp/product-category/shoes/"
                                                            rel="tag">@{{ subcatalogue.name }}</a>.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col_half nobottommargin col_last product-desc">
                                        <div class="product-price">
                                            {{--<span v-text="currencyFormatter(product.r_price)"></span>--}}
                                            <ins>@{{ product.r_price}}円</ins>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="line"></div>
                                        <h4>効果</h4>
                                        <span id="description" >@{{ product.description }}</span>

                                        <div class="clear"></div>
                                        <div class="line"></div>
                                        <h4>服用方法</h4>
                                        <span id="efficacy" >@{{ product.efficacy }}</span>
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

    <script src="{{asset('js/vendor_products.js')}}"></script>
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
    </script>
@endsection

