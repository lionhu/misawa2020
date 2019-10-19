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
        #example tbody tr.odd {
            background-color: lightgray;
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
                    <!-- Post Content
                    ============================================= -->
                    <div class=" nobottommargin col_full">
                        <!-- Shop
============================================= -->
                        <div class="table-responsive">
                            <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>姓名</th>
                                    <th>邮箱</th>
                                    <th>联系方式</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $customer)
                                    <tr id="rowID_{{$customer->id}}">
                                        <th>
                                            @if ($customer->sex)
                                                Mr.
                                            @else
                                                Miss.
                                            @endif
                                            {{$customer->name}}
                                                <a href="" customerid="{{$customer->id}}" data-toggle="modal" data-target="#UserModalLong" class="koun_customer">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="false">({{$customer->id}})</i></a>


                                        </th>
                                        <th>
                                            {{$customer->email}}
                                        </th>
                                        <th>
                                            postcode: {{$customer->postcode}} <br>
                                            {{$customer->address1}} <br>
                                            {{$customer->address2}} <br>
                                            {{$customer->phone}}
                                        </th>
                                        <th>
                                            <a href="#" customerid="{{$customer->id}}" class="delete_customer">
                                                <i class="fa fa-trash-o">({{$customer->id}})</i></a>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- .postcontent end -->

                </div>

                <div class="modal fade" id="UserModalLong" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="single-product shop-quick-view-ajax clearfix">

                                <div class="ajax-modal-title">
                                    <h2>Edit Customer @{{customer.name}}</h2>
                                </div>

                                <div class="product modal-padding clearfix">

                                    <div class="col_full nobottommargin">
                                        <div class="editcustomer_postcode">
                                            <label for="postcode" class="col_half text-right bottommargin-sm">Postcode:</label>
                                            <input type="text" v-model="customer.postcode" class="col_half col_last bottommargin-sm">
                                        </div>

                                        <div class="editcustomer_address1">
                                            <label for="address1" class="col_half text-right bottommargin-sm">Address_1:</label>
                                            <input type="text" v-model="customer.address1" class="col_half col_last bottommargin-sm">
                                        </div>

                                        <div class="editcustomer_address2">
                                            <label for="address2" class="col_half text-right bottommargin-sm">Address_2:</label>
                                            <input type="text" v-model="customer.address2" class="col_half col_last bottommargin-sm">
                                        </div>

                                        <div class="editcustomer_phone">
                                            <label for="phone" class="col_half text-right bottommargin-sm">Phone:</label>
                                            <input type="text" v-model="customer.phone" class="col_half col_last bottommargin-sm">
                                        </div>

                                        <div class="editcustomer_email">
                                            <label for="email" class="col_half text-right bottommargin-sm">Email:</label>
                                            <input type="text" v-model="customer.email" class="col_half col_last bottommargin-sm">
                                        </div>
                                        <div class="clear"></div>

                                        <!-- Product Single - Quantity & Cart Button
                                        ============================================= -->

                                        <div class="col_full text-right">
                                            <a type="button" class="add-to-cart button nomargin" data-dismiss="modal" v-on:click="updateCustomerInfo">
                                                Update CustomerInfo
                                            </a>

                                            <button type="button" class="button button-blue nomargin" data-dismiss="modal" >Close</button>

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

    <script src="{{asset('js/admin_customers.js')}}"></script>
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

    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
@endsection

