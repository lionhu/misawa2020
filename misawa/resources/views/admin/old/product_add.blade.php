@extends("layouts.master")

@section("head_scripts")

    {{--<link href="//cdn.quilljs.com/1.2.4/quill.snow.css" rel="stylesheet">--}}
    <!-- Bootstrap File Upload CSS -->
    <link rel="stylesheet" href="{{asset('css/components/bs-filestyle.css')}}" type="text/css" />
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="{{asset('css/components/bs-select.css')}}" type="text/css" />
    <!-- WYSIWYG -->
    <link rel="stylesheet" href="{{asset('vendors/wysiwyg/bootstrap3-wysihtml5.min.css')}}" type="text/css" />
    <!-- Bootstrap Switch CSS -->
    <link rel="stylesheet" href="{{asset('css/components/bs-switches.css')}}" type="text/css" />

    <!-- Radio Checkbox Plugin -->
    <link rel="stylesheet" href="{{asset('css/components/radio-checkbox.css')}}" type="text/css" />

    <style>
        /*要因此wysiwyg上面的toolbar必须后期进行处理*/
        .Efficacy ul{
            display: none;
        }
        .file-input{
            min-height: 300px;
        }
        .fileinput-upload-button{
            display: none;
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
        <div class="content-wrap" id="product">

            <div class="container clearfix">

                <!-- Post Content
                ============================================= -->
                <div class="postcontent nobottommargin col_last">

                    <!-- Shop
                    ============================================= -->
                    <div class="shop product-3 grid-container clearfix">

                        <div class="single-product">

                            <form  enctype="multipart/form-data" role="form" method="POST"
                                   action="{{route('admin_Product_postAddNew')}}">
                                    {{csrf_field()}}
                                <div class="col_half product-desc">
                                    <div class="col_full nobottommargin">
                                        <div class="col_half bottommargin-sm">
                                            <label for="billing-form-name">Active:</label>
                                            <input type="text" id="active" name="active" value="0" hidden/>
                                            <input class="bt-switch" type="checkbox" checked data-off-text="Active" data-on-text="NO Active"
                                                   data-on-color="danger" data-off-color="success">
                                        </div>
                                    </div>
                                    <div class="col_full nobottommargin">
                                        <div class="white-section">
                                            <select class="col_half " name="vendor">
                                                <option value="1">KOUN</option>
                                                <option value="2">MISAWA</option>
                                            </select>
                                            <label class="col_half col_last clearfix text-left">Pharmacy</label>
                                        </div>
                                    </div>
                                    <div class="col_full nobottommargin">
                                        <div class="white-section">
                                            <select class="col_half " name="catalogue" v-model="product.catalogue" v-on:change="loadSubcatalogues">
                                                <option v-for="catalogue in catalogues" :value="catalogue.id" v-text="catalogue.name" ></option>
                                            </select>
                                            <label class="col_half col_last clearfix text-left">Catalogue</label>
                                        </div>
                                    </div>
                                    <div class="col_full nobottommargin">
                                        <div class="white-section">
                                            <select class="col_half clearfix" name="subcatalogue" v-model="product.subcatalogue">
                                                <option v-for="subcatalogue in subcatalogues" :value="subcatalogue.id" v-text="subcatalogue.name" ></option>
                                            </select>
                                            <label class="col_half col_last text-left">Subcatalogue:</label>
                                        </div>
                                    </div>
                                    <div class="col_full">
                                        <label for="manufactory">Manufactory:</label>
                                        <input type="text" id="manufactory" name="manufactory"  value="{{old('manufactory')}}" class="sm-form-control">
                                    </div>
                                    <div class="col_full">
                                        <label for="product_code">Product Code:</label>
                                        <input type="text" id="product_code" name="product_code"  value="{{old('product_code')}}" class="sm-form-control">
                                    </div>

                                    <div class="col_full">
                                        <label for="product_name">Product Name:</label>
                                        <input type="text" id="name" name="name"  value="{{old('name')}}" class="sm-form-control">
                                    </div>

                                    <div class="col_full">
                                        <label for="name_jp">Product Japanese Name:</label>
                                        <input type="text" id="name_jp" name="name_jp"  value="{{old('name_jp')}}" class="sm-form-control">
                                    </div>

                                    <div class="col_half">
                                        <label for="unit">Unit:</label>
                                        <input type="text" id="unit" name="unit"  value="{{old('unit')}}" class="sm-form-control">
                                    </div>

                                    <div class="col_half col_last clearfix">
                                        <label for="tablets">Tablets:</label>
                                        <input type="text" id="tablets" name="tablets"  value="{{old('tablets')}}" class="sm-form-control">
                                    </div>
                                    <div class="col_full clearfix">
                                        <div class="col_one_fourth">
                                            <label for="o_price">O_Price:</label>
                                            <input type="text" id="o_price" name="o_price"  value="{{old('o_price')}}" class="sm-form-control">
                                        </div>
                                        <div class="col_one_fourth">
                                            <label for="b_price">B_Price:</label>
                                            <input type="text" id="b_price"  value="{{old('b_price')}}" name="b_price" class="sm-form-control">
                                        </div>
                                        <div class="col_one_fourth">
                                            <label for="r_price">R_Price:</label>
                                            <input type="text" id="r_price" name="r_price"  value="{{old('r_price')}}" class="sm-form-control">
                                        </div>

                                    </div>

                                    <div class="col_full">
                                        <label for="efficacy">Efficacy:</label>
                                        <textarea  id="efficacy" name="efficacy" class="sm-form-control wysiwyg_text" v-model="product.efficacy" v-on:keyup="test" style="background-color: darkseagreen;"></textarea>

                                    </div>

                                    <div class="col_full">
                                        <label for="description">Description:</label>
                                        <textarea  id="description" name="description" class="sm-form-control wysiwyg_text" v-model="product.efficacy" v-on:keyup="test" style="background-color: darkseagreen;"></textarea>

                                    </div>

                                    <div class="col_full">
                                        <label for="website">Notice:</label>
                                        <textarea  id="website" name="website" class="sm-form-control wysiwyg_text" v-model="product.efficacy" v-on:keyup="test" style="background-color: darkseagreen;"></textarea>

                                    </div>
                                {{--<div class="col_full">--}}
                                {{--<div id="textEfficacy">textEfficacy</div>--}}
                                {{--</div>--}}



                                {{--<div class="clear"></div>--}}
                                {{--<div class="line"></div>--}}

                                <!-- Product Single - Quantity & Cart Button
                                            ============================================= -->
                                    {{--<a class="add-to-cart button nomargin" v-on:click="test">Add to cart</a>--}}

                                </div>
                                <div class="col_half col_last">
                                    <div class="col_full">
                                        @if(count($errors)>0)
                                            <div class="style-msg errormsg">
                                                <div class="sb-msg">
                                                @foreach($errors->all() as $error)
                                                        <i class="icon-remove"></i><strong>{{$error}}</strong> <br>
                                                @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col_full">
                                        <label>Post Image (as default thumbimage):</label><br>
                                        <input id="postimage_1" name="postimage_1" type="file" accept="image/*" class="file-loading loadingimage" data-allowed-file-extensions='[]'>
                                    </div>
                                    <div class="col_full clearfix">
                                        <label>Post Image (as default thumbimage):</label><br>
                                        <input id="postimage_2" name="postimage_2" type="file" accept="image/*" class="file-loading loadingimage" data-allowed-file-extensions='[]'>
                                    </div>

                                    <button name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d nomargin">Submit Comment</button>


                                </div>


                            </form>

                        </div>
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

    <script src="{{asset('js/admin_new_product.js')}}"></script>
    <script src="{{asset('vendors/wysiwyg/wysihtml5x-toolbar.min.js')}}"></script>
@endsection

@section("beforefunction_scripts")

    <!-- Bootstrap File Upload Plugin -->
    <script type="text/javascript" src="{{asset('js/components/bs-filestyle.js')}}"></script>

    <!-- Bootstrap Switch Plugin -->
    <script type="text/javascript" src="{{asset('js/components/bs-switches.js')}}"></script>


    <script src="{{asset('vendors/wysiwyg/handlebars.runtime.min.js')}}"></script>
    <script src="{{asset('vendors/wysiwyg/bootstrap3-wysihtml5.min.js')}}"></script>
    <script  type="text/javascript">
        $(document).on('ready', function() {
            $(".loadingimage").fileinput({
                mainClass: "input-group-md",
                showUpload: true,
                previewFileType: "image",
                browseClass: "btn btn-success",
                browseLabel: "Pick Image",
                browseIcon: "<i class=\"icon-picture\"></i> ",
                removeClass: "btn btn-danger",
                removeLabel: "Delete",
                removeIcon: "<i class=\"icon-trash\"></i> ",
                uploadClass: "btn btn-info",
                uploadLabel: "Upload",
                uploadIcon: "<i class=\"icon-upload\"></i> "
            });

        });
        $(".bt-switch").bootstrapSwitch({
            onSwitchChange : function(event, state) {
                if(state){
                    $("#active").val(0);
                }else{

                    $("#active").val(1);
                }
            }
        });
        $('.wysiwyg_text').wysihtml5({
            toolbar: {
                fa: true
            }
        });
    </script>


@endsection


@section("jquery_afterscripts")

@endsection