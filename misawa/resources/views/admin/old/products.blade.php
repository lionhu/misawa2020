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
                    <!-- Post Content
                    ============================================= -->
                    <div class="nobottommargin col_full">

                        <!-- Shop
                        ============================================= -->
                        <div class="table-responsive">
                            <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Active</th>
                                    <th>Catalogue</th>
                                    <th>Information</th>
                                    <th>R_Price</th>
                                    <th>B_Price</th>
                                    <th>O_Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr id="rowID_{{$product->id}}">
                                        <th>
                                            <a href="{{route('admin_Product_postEdit',['productid'=>$product->id])}}">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true">{{$product->id}}</i></a>

                                        </th>
                                        <th>
                                            <a href="{{route("shop_product",["id"=>$product->id])}}">
                                                <img src="{{asset($product->thumbImage)}}" alt="" style="width: 100px;height: 100px;">
                                            </a>
                                        </th>
                                        <th class="center">
                                            @if($product->active==1)
                                                <i class="fa fa-bookmark text-red"></i>
                                            @else
                                                <i class="fa fa-bookmark-o"></i>
                                            @endif
                                        </th>
                                        <th>
                                            {{$product->vendor->name}} <br>
                                            {{$product->catalogue->name}} <br>
                                            {{$product->subcatalogue->name}}
                                        </th>
                                        <th>{{$product->name}} <br>
                                            code: {{$product->product_code}}
                                        </th>
                                        <th >
                                            <span class="money_jp text-red">{{$product->r_price}}</span>
                                        </th>
                                        <th >
                                            <span class="money text-blue">{{$product->b_price}}</span>
                                        </th>
                                        <th >
                                            <span class="money">{{$product->o_price}}</span>
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
                                    <h2></h2>
                                </div>

                                <div class="product modal-padding clearfix">

                                    <div class="col_half nobottommargin">
                                        <div class="product-image">
                                            <div class="fslider" data-pagi="false">
                                                <div class="flexslider">
                                                    <div class="slider-wrap">
                                                            {{--<div class="slide">--}}
                                                                <a  title="">
                                                                    <img src="" alt="">
                                                                </a>
                                                            {{--</div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sale-flash">Sale!</div>
                                        </div>
                                    </div>
                                    <div class="col_half nobottommargin col_last product-desc">
                                        <div class="product-price">
                                            <del></del>
                                            <ins>200</ins>
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
                                            <button type="button" class="minus" v-on:click=""> -</button>
                                            <button type="button" class="qty"></button>
                                            <button type="button" class="plus" v-on:click=""> +</button>

                                        </div>
                                        <button type="button" class="add-to-cart button nomargin" data-dismiss="modal" id="add2cart">Add to
                                            cart
                                        </button>
                                        </form><!-- Product Single - Quantity & Cart Button End -->

                                        <div class="clear"></div>
                                        <div class="line"></div>
                                        <p id="efficacy"></p>
                                        <ul class="iconlist">
                                            <li><i class="icon-caret-right"></i> Dynamic Color Options</li>
                                            <li><i class="icon-caret-right"></i> Lots of Size Options</li>
                                            <li><i class="icon-caret-right"></i> 30-Day Return Policy</li>
                                        </ul>
                                        <div class="panel panel-default product-meta nobottommargin">
                                            <div class="panel-body">
                                        <span itemprop="productID" class="sku_wrapper">Product Code: <span
                                                    class="sku"></span></span>
                                                <span class="posted_in">Category: <a class="tag"> -- </a> <a
                                                            href="http://localhost/offbeat/wp/product-category/shoes/"
                                                            rel="tag"></a>.</span>
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
                        </div>
                    </div>
                </div>
            </div>
    </section><!-- #content end -->
@endsection

@section("jquery_scripts")

    <script src="{{asset('js/admin_products.js')}}"></script>
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

