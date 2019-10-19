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
                    <div class=" nobottommargin col_full">
                        <!-- Shop
============================================= -->
                        <div class="table-responsive">
                            <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>姓名</th>
                                    <th>邮箱</th>
                                    <th>类型</th>
                                    <th>团体</th>
                                    <th>其他</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr id="rowID_{{$user->id}}">
                                        <td>
                                            <img src="{{asset($user->image)}}" alt="" style="height: 60px;">
                                        </td>
                                        <td>
                                            {{$user->name}}
                                            <a href="" userid="{{$user->id}}" data-toggle="modal" data-target="#UserModalLong" class="koun_user">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true">({{$user->id}})</i></a>
                                            
                                        </td>
                                        <td>{{$user->email}}</th>
                                        <td>
                                            @if($user->hasRole("customer"))
                                                <p>
                                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                                    customer
                                                </p>
                                            @elseif($user->hasRole("customerAdmin"))
                                                <p style="color:red;">
                                                    <i class="fa fa-users" aria-hidden="true"></i>
                                                    customerAdmin
                                                </p>
                                            @elseif($user->hasRole("superadmin"))
                                                <p style="color:red;">
                                                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                                                    superAdmin
                                                </p>
                                            @elseif($user->hasRole("vendor"))
                                                <p style="color:#1abc9c;">
                                                    <i class="fa fa-university" aria-hidden="true"></i>
                                                    vendor
                                                </p>
                                            @elseif($user->hasRole("distributor"))
                                                <p style="color:blue;">
                                                    <i class="fa fa-universal-access" aria-hidden="true"></i>
                                                    distributor({!! $user->rate * 100 !!})%
                                                </p>
                                            @endif
                                            
                                        </td>
                                
                                        <td>{{$user["client"]->name}}</td>
                                        <td><a href="{{route('user_sendWelcomeRegister',['id'=>$user->id])}}">Send Welcome</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>


                        <!-- Shop
                        ============================================= -->
                        {{--<div class="grid-container clearfix">--}}
                            {{--@foreach($users as $user)--}}

                                {{--<div class="testimonial col_one_third center" id="user_{{$user->id}}">--}}
                                    {{--<div class="testi-image col_full">--}}
                                        {{--<a href="#"><img src="{{asset('images/testimonials/3.jpg')}}" alt="Customer Testimonails"></a>--}}
                                    {{--</div>--}}
                                    {{--<div class="testi-content col_full clearfix">--}}
                                        {{--<p>{{$user->email}} </p>--}}
                                            {{--@foreach($user->roles as $role)--}}
                                                {{--<p class="nobottommargin">Role: {{$role->name}} </p>--}}
                                            {{--@endforeach--}}

                                        {{--<div class="testi-meta">--}}
                                            {{--{{$user["name"]}}--}}
{{--                                            <span>client:  {{$user["client"]->name}}</span>--}}
                                        {{--</div>--}}
                                        {{--<div class="buttonarea">--}}
                                            {{--<a type="button" v-on:click="deleteUser({{$user->id}})" class="button button-mini button-circle button-red">Delete</a>--}}
                                                {{--<a type="button" class="button button-mini button-circle button-green editUser" v-on:click="loadEditUserModal({{$user->id}})" data-toggle="modal" data-target="#UserModalLong">Edit</a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--@endforeach--}}
                        {{--</div><!-- #shop end -->--}}

                    </div><!-- .postcontent end -->

                </div>

                <div class="modal fade" id="UserModalLong" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="single-product shop-quick-view-ajax clearfix">

                                <div class="ajax-modal-title">
                                    <h2>Edit User : @{{ user.name }}</h2>
                                </div>

                                <div class="product modal-padding clearfix">

                                    <div class="col_full nobottommargin">
                                        <div id="client" class=" ">
                                            <label for="clientname" class="col_half text-right bottommargin-sm">Belongs to Client:</label>
                                            <select name="clientname" class="col_half col_last bottommargin-sm" v-model="user.client.id">
                                                <option disabled value="">请选择</option>
                                                @foreach($clients as $client)
                                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="role" class="">
                                            <label for="rolename" class="col_half text-right bottommargin-sm">User Role:</label>
                                            <select name="rolename" v-model="roleid" class="col_half col_last bottommargin-sm">
                                                <option disabled value="">请选择</option>
                                                @foreach($roles as $role)
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="edituser_email">
                                            <label for="useremail" class="col_half text-right bottommargin-sm">Email:</label>
                                            <input type="text" v-model="user.email" class="col_half col_last bottommargin-sm">
                                        </div>
                                        <div class="edituser_introcode">
                                            <label for="introcode" class="col_half text-right bottommargin-sm">Introcode:</label>
                                            <input type="text" v-model="user.introcode" class="col_half col_last bottommargin-sm">
                                        </div>
                                        <div class="edituser_phone">
                                            <label for="phone" class="col_half text-right bottommargin-sm">Phone:</label>
                                            <input type="text" v-model="user.phone" class="col_half col_last bottommargin-sm">
                                        </div>
                                        <div class="edituser_rate">
                                            <label for="rate" class="col_half text-right bottommargin-sm">Rate:</label>
                                            <input type="text" v-model="user.rate" class="col_half col_last bottommargin-sm">
                                        </div>
                                        <div class="clear"></div>

                                        <!-- Product Single - Quantity & Cart Button
                                        ============================================= -->

                                        <div class="col_full text-right">
                                            <a type="button" class="add-to-cart button nomargin" data-dismiss="modal" v-on:click="updateUserInfo">
                                                Update UserInfo
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

    <script src="{{asset('js/admin_edituser.js')}}"></script>
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

