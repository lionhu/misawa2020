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
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">最近访客</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tbody><tr>
                                            <th>User</th>
                                            <th>Location</th>
                                            <th>device</th>
                                            <th>platform</th>
                                            <th>browser</th>
                                            <th>time</th>
                                        </tr>
                                        @foreach($visitors as $visitor)
                                        <tr>
                                            <td><a href="{{'/admin/user/history/'.$visitor->user_id}}">{{$visitor->user_name}}</a></td>
                                            <td>{{$visitor->country}}/{{$visitor->province}}</td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i> {{$visitor->device}}</span> </td>
                                            <td>{{$visitor->platform}}</td>
                                            <td><span class="label label-danger">{{$visitor->browser}}</span></td>
                                            <td>{{$visitor->created_at}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody></table>
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