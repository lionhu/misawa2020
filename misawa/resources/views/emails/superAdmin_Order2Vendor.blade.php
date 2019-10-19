@extends("emails.layouts.superadmin")


@section("message_block")
    {{--message block--}}
    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_onecolumnBlock_9">
        <tbody>
        <tr class="row-b" style=";">
            <td bgcolor="#1ABC9C" align="center" class="section-padding"
                style="padding-top: 30px; padding-left: 15px; padding-bottom: 30px; padding-right: 15px;">
                <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td>
                                        <!-- COPY -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td align="center" colspan="2" class="padding-copy"
                                                    style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; padding-top: 0px;">
                                                    订单状态通知(#{!! $po->id !!}) - Order2Vendor
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left" colspan="2" class="padding-copy"
                                                    style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; padding-top: 0px;">
                                                    <p style="margin-top:0;text-indent: 2em;">老板，您的订单已经派送到药方，我们将在24小时内通过国际快件EMS将你选定的产品快递到您的手中。</p>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="padding-copy textintenseStyle"
                                                    style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #ffffff;">
                                                    @include("emails.parts.customer_information_section")
                                                </td>
                                                <td align="left" class="padding-copy textintenseStyle"
                                                    style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #ffffff;">
                                                    <p style="margin:0;padding: 10px;">
                                                        客服：{{$po->user->name}} (#{{$po->user->id}}) <br>
                                                        邮件：{{$po->user->email}} <br>
                                                        电话：{{$po->user->phone}}

                                                    </p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection

@section("message_footer")
    {{--total information--}}
    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_titleBlock_4" style="border-top: 10px solid rgb(237, 232, 218);">
        <tbody>
        <tr class="row-a">
            <td bgcolor="#1ABC9C" align="center" class="section-padding" style="padding: 30px 15px 0px 15px;">
                <table border="0" cellpadding="0" cellspacing="0" width="500" style="padding: 0 0 20px 0;"
                       class="responsive-table"><!-- TITLE -->
                    <tbody>
                    <tr>
                        <td align="center" class="padding-copy" colspan="2"
                            style="padding: 0 0 10px 0px; font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff;">
                            总计数量：{{$po->cart_Qty}} <br>
                            进价：<span class="money_jp">{{$po->cart_R_Price}} </span>円/ 卖价：<span class="money">{{$po->cart_B_Price}} 元</span><br>
                            R_利润：<span class="money_jp">{{round($po->cart_B_Price*env("CURRENCY_RATE") - $po->cart_R_Price,-1)}}円</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection