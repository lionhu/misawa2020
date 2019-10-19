@extends("layouts.master")

@section("head_scripts")
    <!-- Lionhu's Stylesheets
============================================= -->
    <link rel="stylesheet" href="{{asset('mystyle.css')}}" type="text/css" />
@endsection


@section("main_content")

<section >
    <div class="content-wrap" id="shop">

        <div class="container clearfix">

            <!-- Post Content
            ============================================= -->
            <div class="postcontent nobottommargin col_last">
                <h2>常见问题解答</h2>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_00" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">关于本网站</h4>
                                        </a>
                                        <div id="collapse_00" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <p>本网站为日本三泽药局连锁店面向中国市场的销售平台，旨在为需要日本药品的在华日本人以及在日本接受过医疗救治而回到中国后无法获得处方药的患者提供便捷的药品国际快递服务。</p>
                                                <p style="color:red;">请在下单前在相关具有医疗资质的机构进行必要的咨询，本网站不进行任何形式的推荐。</p>
                                                <p>日本三泽药局连锁店的官方网站为 <a href="http://www.misawa-jp.com/company/company02.htm">ミサワ薬局</a></p>
                                                <p>日本三泽药局连锁店成立于昭和38年（1963年），有着55年以上历史的老铺连锁药房，在东京地区拥有10家实体店铺，同时在日本的乐天，亚马逊上也有线上店铺的销售。</p>
                                                <p style="margin-top:15px;color:red;">处方药是日本政府严格控制的商品，没有处方而获得处方药在日本属于违法行为。另外，对于中国患者，只针对在中国赴日医疗群体客户，并且有处方的患者提供服务。</p>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_0" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">如何下单</h4>
                                        </a>
                                        <div id="collapse_0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <p style="color:red;">下面是youtube，如果有什么问题，请联系管理员 healthcare68@163.com</p>
                                                <div id="w-video" class="widget clearfix">
                                                    <iframe width="854" height="480" src="https://www.youtube.com/embed/3mHutWI4RWg" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    

                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_1" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">如何快速找到药品</h4>
                                        </a>
                                        <div id="collapse_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <p style="color:red;">如果你没有找到想要的产品，请立即联系介绍你的上家客户。一般收到申请，我们能在24小时内将你需要的产品上架。</p>
                                                <div id="w-video" class="widget clearfix">
                                                    <iframe src="{{asset('images/help/searchproduct.mp4')}}" width="500" height="250" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_2" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">一次能购买的数量有限制吗？</h4>
                                        </a>
                                        <div id="collapse_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                因为属于个人使用目的，因此一次购买的量有以下限制：<br>
                                                （1）一个EMS国际快递包裹内的总数不得超过5件药品。 <br>
                                                （2）一个EMS国际快递包裹内，每一种药品的数量不得超过2件。
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_3" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">快递费用是如何计算的？</h4>
                                        </a>
                                        <div id="collapse_3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                一般来说一个EMS国际快件包裹的统一收费为70元。 <br>
                                                但是特殊情况下，客服人员会与您取得联系，协商运费事宜的。
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_4" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">如何支付运费？</h4>
                                        </a>
                                        <div id="collapse_4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                运费的支付与选择产品一样，可以在 <span class="label label-primary">分类</span><i class="fa fa-arrow-right"></i>
                                                <span class="label label-primary">运费相关</span>中找到运费产品。一般来说选取70元基本运费即可。
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_5" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">如何支付药品的费用？</h4>
                                        </a>
                                        <div id="collapse_5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <p><span class="label label-danger">*****为了您的健康，你可以向各个代理商咨询药品信息以及使用注意事项，因此现阶段请将费用支付给各个代理商*****</span><br>
                                                </p>

                                                我们支持微信以及阿里支付方式。 <br>
                                                下单后订单会停留在<span class="label label-default">new</span>状态，扫描二维码支付相应的订单金额后，请在微信中将订单的订单号发给我们。<br>
                                                在确认款项正确收取后，您的订单会被自动转到MISAWA药局，订单的状态也会相应地变为<span class="label label-primary">运输中</span>，同时你也能看到国际快递EMS的单号，单击单号就能随时看到您的药品运输情况。
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_51" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">如何确认订单的快递状态？</h4>
                                        </a>
                                        <div id="collapse_51" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <p>每一笔订单在发出EMS国际快递小包后，您都能收到一封通知的邮件。在邮件中会有每个小包的快递单号，点击该单号就能在日本邮政网页上查看到每一笔快递的快递日程情况。</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_6" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">高价值产品，万一在运输过程中丢失了怎么办？</h4>
                                        </a>
                                        <div id="collapse_6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <p>
                                                    EMS国际快递服务有损害赔偿制度的。 <br>
                                                    在MISAWA药局采购的产品，我们均会加入EMS损害赔偿服务的。在发生意外的情况下，会根据该赔偿制度进行处理。 <br>
                                                    ※通常可能会是运费的10倍金额。也可以委托我们进行追加保险服务。 <br>
                                                    ※赔偿保险制度可以参见日本邮政的网页 <br>
                                                    <a href="https://www.post.japanpost.jp/int/ems/service/damage.html">https://www.post.japanpost.jp/int/ems/service/damage.html</a>
                                                </p>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_7" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">快递大致需要的时间是多少？</h4>
                                        </a>
                                        <div id="collapse_7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <p>
                                                    正常情况下，从交给快递公司开始，大概一周时间内就可以将您订购的产品快递到您的手中。但是由于节假因素或者海关处理效率原因，一般两周内应该是没有问题的。
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_8" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">购买的药有假药吗？</h4>
                                        </a>
                                        <div id="collapse_8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <p>
                                                    MISAWA药局为日本合法经营的连锁药局，其销售的药品均为日本药剂师管理的正规渠道医药品，不存在假药的可能性。<br>
                                                    MISAWA药局销售的药品均为基于日本国内药剂法规定的药品。
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_9" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">能将处方药交给在日本的朋友吗？</h4>
                                        </a>
                                        <div id="collapse_9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <p>
                                                    按照日本药剂法，在没有处方的情况下，将药品交给没有处方的患者是违法行为。不仅是买的患者，而且连出售的药局都要被取缔。 <br>
                                                    因此我们不能将处方药交给您在日本的朋友，而是直接由药局通过国际快递，安全地送到您的手中。
                                                </p>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_10" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">海关货物清关单上的价格为什么这么便宜？</h4>
                                        </a>
                                        <div id="collapse_10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <p>
                                                    为了能让药品顺利清关，而且不给你产生不必要的关税，一般药局在发货时，会将药品的单价标得非常低。还请谅解。
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapse_11" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">下订单时的注意事项</h4>
                                        </a>
                                        <div id="collapse_11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <img src="{{asset('images/orderform.png')}}" class="img-responsive img-rounded" alt="Responsive image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .postcontent end -->

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
