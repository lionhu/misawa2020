@extends("layouts.master_crypto")

@section("head_scripts")

@endsection

@section("main_content")

    <!-- Page Sub Menu
		============================================= -->
{{--    @include("parts.pagemenu_admin")--}}

    <!-- Content
		============================================= -->
    <section id="content_main" >
            <div class="content-wrap">
                <div class="row">

                    <div class="col-12">
                        <div class="box box-inverse box-carousel bg-red bg-hexagons-white pull-up slide" data-ride="carousel">
                            <div class="box-header no-border">
                                <span class="fa fa-google-plus font-size-30"></span>
                                <div class="box-tools pull-right">
                                    <h5 class="box-title box-title-bold">{{$user->name}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">浏览产品</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table id="visitors" class="table table-hover" cellspacing="0" width="100%">
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
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div>
    </section><!-- #content end -->
@endsection

@section("vue_script")
{{--    <script src="{{asset('js/admin.js')}}" type="text/javascript" ></script>--}}
@endsection

@section("jquery_afterscripts")
@endsection