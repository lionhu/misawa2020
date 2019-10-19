@extends("layouts.master")

@section("head_scripts")
    {{--<link href="//cdn.quilljs.com/1.2.4/quill.snow.css" rel="stylesheet">--}}
@endsection



@section("main_content")

    <!-- Page Sub Menu
		============================================= -->
    @include("parts.pagemenu_customerAdmin")

    <!-- Content
		============================================= -->
    <section id="content" >
            <div class="content-wrap" id="shop">

                <div class="container clearfix">
                    <h3>我的团队</h3>
                <div class="row">
                    @foreach($users as $user)
                        <div class="col-md-4 col-sm-6 bottommargin">

                            <div class="panel panel-primary">
                                <div class="panel-heading" style="color: white;">
                                    {{$user->name}}

                                    @if($user->hasRole("distributor"))
                                        <span class="badge badge-secondary float-left" style="margin-top: 3px;color: green;">
                                             <i class="fa fa-user"></i> 渠道代理</span>
                                    @elseif($user->hasRole("customerAdmin"))
                                        <span class="badge badge-secondary float-left" style="margin-top: 3px;color: red;">
                                           <i class="fa fa-user"></i> 一级代理</span>
                                    @else
                                        <span class="badge badge-secondary float-left" style="margin-top: 3px;color: blueviolet;">
                                           <i class="fa fa-user"></i> 用户</span>
                                    @endif


                                    <a href="{{'/customerAdmin/user/history/'.$user->id}}">

                                    <span class="badge badge-success float-right" style="margin-top: 3px;color: green;">
                                             <i class="fa fa-list"></i> 浏览履历</span>
                                    </a>

                                </div>
                                <div class="panel-body center">
                                    <div class="team">
                                        <div class="team-desc">
                                            <p>{{$user->email}} <br>
                                            Rate: {!! $user->rate*100 !!}%</p>
                                            <a href="" userid="{{$user->id}}" data-toggle="modal" data-target="#UserModalLong" class="koun_user">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true">({{$user->id}})</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                    @endforeach
                </div>

                </div>


                <div class="modal fade" id="UserModalLong" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                                <div class="ajax-modal-title">
                                    <h2>编辑用户: @{{ user.name }}</h2>
                                </div>

                                <div class="modal-padding clearfix">

                                    <div class="col_full nobottommargin">
                                        <div class="edituser_rate">
                                            <label for="rate" class=" bottommargin-sm">Rate:</label>
                                            <input type="text" v-model="user.rate" class="bottommargin-sm">
                                            <p>*注意：10%的情况，请输入0.1。</p>
                                        </div>

                                        <!-- Product Single - Quantity & Cart Button
                                        ============================================= -->

                                        <div class="col_full text-right">
                                            <a type="button" class="add-to-cart button nomargin" data-dismiss="modal" v-on:click="updateUserInfo">
                                                更新客户信息
                                            </a>

                                            <button type="button" class="button button-blue nomargin" data-dismiss="modal" >关闭</button>

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

    <script src="{{asset('js/customeradmin_edituser.js')}}"></script>
@endsection




@section("jquery_afterscripts")
@endsection