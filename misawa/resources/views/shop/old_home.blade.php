@extends("layouts.master")

@section("head_scripts")
    <!-- Lionhu's Stylesheets
============================================= -->
<link rel="stylesheet" href="{{asset('mystyle.css')}}" type="text/css" />
@endsection



@section("main_content")

    <!-- Content
		============================================= -->
    <section >
            <div class="content-wrap" id="shop">

                <div class="container clearfix">
                    <!-- Page Title
============================================= -->

                    <!-- Post Content
                    ============================================= -->
                    <div class="postcontent nobottommargin col_last">

                        @role(['customer','distributor','customerAdmin','superadmin'])

                            <div class="row mt-5 clearfix">
                            <div class="col-12">
                                <div class="fancy-title title-dotted-border title-center mb-4">
                                    <h4>销量排行榜 Top5</h4>
                                </div>
                                <ul class="clients-grid grid-8 nobottommargin fadeInUp animated clearfix" data-animation="fadeInUp" >
                                    @foreach($top5 as $product)
                                        <li><a href="{{route("shop_product",["id"=>$product->product_id])}}"><img src="{{asset('/'.$product->product_image)}}" alt="Clients"></a></li>
                                    @endforeach
                                </ul>
                                <div class="fancy-title title-dotted-border title-center mb-4"><h4>- END -</h4></div>
                            </div>
                        </div>
                        @endrole
                        <!-- Shop
                        ============================================= -->
                        <div class="shop product-3 grid-container clearfix">
                            @foreach($products as $product)
                                <div class="product sf-dress clearfix">
                                        <div class="product-image ribbon_box3">
                                            <div class="ribbon_area">
                                                <span class="ribbon15">NEW</span>
                                            </div>
                                        @foreach($product->images as $image)
                                            <a href="#" onclick="return false;"><img src="{{asset($image->path_image)}}" alt="Checked Short Dress"></a>
                                        @endforeach
                                        {{--<div class="sale-flash">50% Off*</div>--}}
                                        <div class="product-overlay">
                                            @role(['customer','distributor','customerAdmin','superadmin'])

                                                <a  class="add-to-cart add2cart_one" product_ID="{{$product->id}}"><i class="icon-shopping-cart"></i><span> 加入购物车</span></a>

                                            <a  class="item-quick-view koun_product" data-toggle="modal" product_ID="{{$product->id}}" data-target="#exampleModalLong">
                                                <i class="icon-zoom-in2"></i><span> 快速浏览</span>
                                            </a>
                                            @endrole
                                        </div>
                                    </div>
                                    <div class="product-desc center">
                                        <div class="product-title">
                                            <h3>{{$product->name}}</h3>
                                                <small>{{$product->name_jp}}</small>

                                        </div>
                                        <div class="product-price">
                                            <a href="{{route("shop_product",["id"=>$product->id])}}" class="btn btn-default  bt-sm" style="background-color: #1ABC9C;color: white;">详细介绍</a>
                                            <br>
                                            @role(['customer','distributor','customerAdmin','superadmin'])
                                            <ins> <span class="money">{{$product->o_price}}</span> </ins>/
                                            @endrole

                                            @role(['customerAdmin','superadmin'])
                                            <ins><span class="money" style="color: green;">{{$product->b_price}}</span></ins>
                                            @endrole

                                            @role(['distributor'])
                                            <ins><span class="money" style="color: green;">{!! $product->b_price +($product->o_price-$product->b_price)*Session::get("user_rate") !!}</span></ins>
                                            @endrole

                                            @role(['superadmin'])
                                            <br><ins><span class="money_jp" style="color: darkred;">{{$product->r_price}}</span></ins>
                                            @endrole
                                        </div>
                                        <div class="product-rating">
                                            @for ($i = 0; $i < $product->rate; $i++)
                                                <i class="icon-star3"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div><!-- #shop end -->

                    </div><!-- .postcontent end -->

                    <!-- Sidebar
                    ============================================= -->
                    <div class="sidebar nobottommargin">
                        <div class="sidebar-widgets-wrap">

                            @include("parts.shopsidebar")

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
                                    <small>产品ID: @{{productID}}</small>
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
                                                            <img :src="'/'+postimage">
                                                        </a>
                                                        {{--</div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="panel panel-default product-meta ">
                                            <div class="panel-body">
                                            <span itemprop="productID" class="sku_wrapper">SKU: @{{productcode}}<span
                                                        class="sku"></span></span>
                                                <span class="posted_in">类别: <a class="tag">@{{catalogue}} -- </a> <a
                                                            href="http://localhost/offbeat/wp/product-category/shoes/"
                                                            rel="tag">@{{subcatalogue}}</a>.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col_half nobottommargin col_last product-desc">
                                        @role(['guest','distributor','customer','customerAdmin','superadmin'])
                                                <div class="product-price">
                                                        <ins> @{{ o_price |currencyFormat}}</ins>
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

                                                 <div class="quantity clearfix">
                                                    <button type="button" class="minus" v-on:click="removeItem"> -</button>
                                                    <button type="button" class="qty">@{{ qty }}</button>
                                                    <button type="button" class="plus" v-on:click="addItem"> +</button>

                                                </div>
                                                <button type="button" class="add-to-cart button nomargin" data-dismiss="modal" id="add2cart">放入购物车
                                                </button>
                                                {{--</form><!-- Product Single - Quantity & Cart Button End -->--}}

                                                <div class="clear"></div>
                                                <div class="line"></div>
                                        @endrole
                                        <h4>效果</h4>
                                        <span id="efficacy" ></span>
                                        <button type="button" class="button button-3d nomargin button-black" data-dismiss="modal" >关闭</button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <a href="#" id="adminMessage"></a>
        <a href="#" id="addcartmessage"></a>

    </section><!-- #content end -->


@endsection

@section("jquery_scripts")

    <script src="{{asset('js/shop.js')}}"></script>

@endsection

@section("jquery_afterscripts")
<script type='text/javascript' src="{{asset('js/currencyFormatter.js')}}"></script>

<script>

        jQuery(document).ready( function($){
            var elementParent = $('.floating-contact-wrap');
            $('.floating-contact-btn').off( 'click' ).on( 'click', function() {
                elementParent.toggleClass('active');
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
        });

</script>

@endsection

