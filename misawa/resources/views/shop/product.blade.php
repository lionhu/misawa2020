@extends("layouts.master")

@section("head_scripts")
    <!-- Lionhu's Stylesheets
============================================= -->
<link rel="stylesheet" href="{{asset('mystyle.css')}}" type="text/css" /><!-- WYSIWYG -->

@endsection



@section("main_content")

    <section id="page-title">

        <div class="container clearfix">
            <h1>{{$product->name}}</h1>
            <ol class="breadcrumb">
                <li>{{$product->catalogue->name}}</li>
                <li class="active"><a href="{{route('shop_catalogueproducts',['id'=>$product->subcatalogue->id])}}">{{$product->subcatalogue->name}}</a></li>
            </ol>
        </div>

    </section><!-- #page-title end -->

    <!-- Content
		============================================= -->
    <section >
            <div class="content-wrap" id="shop"  data-productid="{{$product->id}}">

                <div class="container clearfix">



                    <div class="postcontent nobottommargin clearfix col_last">

                        <div class="single-product">

                            <div class="product">

                                <div class="col_half">

                                    <!-- Product Single - Gallery
                                    ============================================= -->
                                    <div class="product-image">
                                        <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                                            <div class="flexslider">
                                                <div class="slider-wrap" data-lightbox="gallery">
                                                    @foreach($product->images as $image)
                                                        <div class="slide" data-thumb="{{asset($image->path_image)}}">
                                                            <a href="{{asset($image->path_image)}}" title="Pink Printed Dress - Front View" data-lightbox="gallery-item">
                                                                <img src="{{asset($image->path_image)}}" alt="Pink Printed Dress">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sale-flash">Sale!</div>
                                    </div><!-- Product Single - Gallery End -->

                                </div>

                                <div class="col_half col_last product-desc">

                                    <!-- Product Single - Price
                                    ============================================= -->
                                    <div class="product-price">
                                        @role(['distributor','customer','customerAdmin','superadmin'])
                                        <ins><span class="money">{{$product->o_price}}</span></ins>
                                        @endrole
                                    </div><!-- Product Single - Price End -->

                                    <!-- Product Single - Rating
                                    ============================================= -->
                                    <div class="product-rating">
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                        <i class="icon-star-half-full"></i>
                                        <i class="icon-star-empty"></i>
                                    </div><!-- Product Single - Rating End -->

                                    <div class="clear"></div>
                                    <div class="line"></div>

                                    <!-- Product Single - Quantity & Cart Button
                                    ============================================= -->
                                    @role(['distributor','customer','customerAdmin','superadmin'])
                                    <form class="cart nobottommargin clearfix" method="post" enctype='multipart/form-data'>
                                        <div class="quantity clearfix">
                                            <button type="button" class="minus" v-on:click="removeItem"> -</button>
                                            <button type="button" class="qty">@{{ qty }}</button>
                                            <button type="button" class="plus" v-on:click="addItem"> +</button>
                                        </div>

                                        <button type="button" class="add-to-cart button nomargin"  product_ID="{{$product->id}}" id="product_add2cart">放入购物车
                                        </button>
                                    </form><!-- Product Single - Quantity & Cart Button End -->

                                    @endrole
                                    <div class="clear"></div>
                                    <div class="line"></div>


                                    <!-- Product Single - Meta
                                    ============================================= -->
                                    <div class="panel panel-default product-meta">
                                        <div class="panel-body">
                                            <span itemprop="productID" class="sku_wrapper">SKU: <span class="sku">{!! $product->product_code !!}</span></span>
                                            <span class="posted_in">类别: <a href="#" rel="tag">{!! $product->subcatalogue->name !!}</a>.</span>
                                            <span class="tagged_as">厂商: <a href="#" rel="tag">{!! $product->manufactory !!}</a></span>
                                        </div>
                                    </div><!-- Product Single - Meta End -->
                                    
                                    @role(['superadmin'])
                                    <div class="shareproduct">
                                        <div class="sendMessageResult">
                                            @if($shareResult != "")
                                                <span>You Message has been sent!</span>
                                            @endif
                                        </div>
                                        <form action="{{route('product_ShareProduct')}}" method="post" role="form" class="notopmargin nobottommargin" novalidate="novalidate">
                                            <label for="email">分享产品信息给好友：{{$shareResult}}</label>
                                            <div class="input-group divcenter">
                                                <input type="text" class="form-control" name="email" placeholder="Enter your Email" required="" aria-required="true">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success" type="submit"><i class="icon-email2"></i></button>
                                                </span>
                                            </div>
                                            {{csrf_field()}}
                                            <input type="text" name="productid" value="{{$product->id}}" hidden>
                                        </form>
                                    </div>
                                    @endrole

                                </div>

                                <div class="col_full nobottommargin">

                                    <div class="tabs clearfix nobottommargin" id="tab-1">

                                        <ul class="tab-nav clearfix">
                                            <li><a href="#tabs-1"><i class="icon-align-left"></i><span class="hidden-xs"> 说明</span></a></li>
                                            <li><a href="#tabs-2"><i class="icon-info-sign"></i><span class="hidden-xs"> 用户评价</span></a></li>
                                        </ul>

                                        <div class="tab-container">

                                            <div class="tab-content clearfix" id="tabs-1">
                                                <h4>疗效</h4>
                                                <p>{!! $product->efficacy !!}</p>

                                                <h4>服用方法</h4>
                                                <p>{!! $product->description !!}</p>

                                                <h4>注意事项</h4>
                                                <p>{!! $product->website !!}</p>
                                            </div>
                                            <div class="tab-content clearfix" id="tabs-2">
                                                <div class="col_full" id="comments">
                                                    <div v-for="comment in productcomments">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title" v-text="comment.user.name">
                                                                </h3>
                                                                <small v-text="comment.created_at"></small>
                                                                @role(['superadmin'])
                                                                    <button class="button button-3d nomargin button-mini" v-on:click="deleteComment(comment.id)" >delete</button>
                                                                @endrole
                                                            </div>
                                                            <div class="panel-body">
                                                                <span v-text="comment.comment" ></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col_full fright">
                                                        <input id="comment" class="sm-form-control"
                                                                  style="background-color: lightgreen;">
                                                        <button class="button button-3d nomargin" v-on:click="sendmessage">Send Message</button>

                                                </div>

                                            </div>
                                            

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- Sidebar
                    ============================================= -->
                    <div class="sidebar nobottommargin">
                        <div class="sidebar-widgets-wrap">

                            @include("parts.shopsidebar_no_subcatalogueID")

                        </div>
                    </div><!-- .sidebar end -->

                </div>

            </div>

        <a href="#" id="adminMessage"></a>
        <a href="#" id="addcartmessage"></a>

    </section><!-- #content end -->


@endsection

@section("jquery_scripts")

    <script src="{{asset('js/productComments.js')}}"></script>

@endsection

@section("jquery_afterscripts")
<script type='text/javascript' src="{{asset('js/currencyFormatter.js')}}"></script>

<script src="{{asset('vendors/wysiwyg/handlebars.runtime.min.js')}}"></script>
<script>
    $(document).ready(function () {
        OSREC.CurrencyFormatter.formatAll(
            {
                selector: '.money',
                currency: 'CNY',
                symbol: '元',
                pattern: '#,##0!;(-#,##0!);0!'
            });
    });

</script>

@endsection

