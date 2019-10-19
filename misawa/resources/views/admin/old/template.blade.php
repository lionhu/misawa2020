@extends("layouts.master")

@section("head_scripts")
    {{--<link href="//cdn.quilljs.com/1.2.4/quill.snow.css" rel="stylesheet">--}}
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
                        <div class="shop product-3 grid-container clearfix">
                            {{--@foreach($products as $product)--}}
                                {{--<div class="product sf-dress clearfix">--}}
                                    {{--<div class="product-image">--}}
                                        {{--@foreach($product->images as $image)--}}
                                            {{--<a href="#"><img src="{{asset($image->path_image)}}" alt="Checked Short Dress"></a>--}}
                                        {{--@endforeach--}}
                                        {{--<a href="#"><img src="{{asset('images/shop/dress/1-1.jpg')}}" alt="Checked Short Dress"></a>--}}
                                        {{--<div class="sale-flash">50% Off*</div>--}}
                                        {{--<div class="product-overlay">--}}
                                            {{--<a  class="add-to-cart add2cart_one" product_ID="{{$product->id}}"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>--}}
                                            {{--<a  class="item-quick-view koun_product" data-toggle="modal" product_ID="{{$product->id}}" data-target="#exampleModalLong">--}}
                                                {{--<i class="icon-zoom-in2"></i><span> Quick View</span>--}}
                                            {{--</a>--}}
                                            {{--<a class="item-quick-view koun_product" product_ID="{{$product->id}}" data-lightbox="ajax">--}}
                                                {{--<i class="icon-zoom-in2"></i><span> Quick View</span>--}}
                                            {{--</a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="product-desc center">--}}
                                        {{--<div class="product-title">--}}
                                            {{--<h3><a href="#">{{$product->name}}</a></h3>--}}
                                            {{--<small>{{$product->name_jp}}</small>--}}
                                        {{--</div>--}}
                                        {{--<div class="product-price"><del>{{$product->o_price}}</del> <ins>{{$product->b_price}}</ins></div>--}}
                                        {{--<div class="product-rating">--}}
                                            {{--@for ($i = 0; $i < $product->rate; $i++)--}}
                                                {{--<i class="icon-star3"></i>--}}
                                            {{--@endfor--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--@endforeach--}}
                        </div><!-- #shop end -->

                    </div><!-- .postcontent end -->

                    @include("parts.adminsidemenu")

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

    <script src="{{asset('js/admin_vue.js')}}"></script>
@endsection



