@extends("emails.layouts.customer")


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
                                            <td align="center" class="padding-copy"
                                                style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; padding-top: 0px;">
                                                新订单通知(#{!! $po->id !!})
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="padding-copy textintenseStyle"
                                                style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #ffffff;">
                                                <p style="margin-top:0;text-indent: 2em;">谢谢你选择MISAWA健康咨询的服务！您的订单已经申请，我们将在72小时内完成备货并通过国际快件直接送到您的手中。</p>
                                                @include("emails.parts.customer_information_section")
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


@section("message_cartitems")
{{--cartitems--}}
    @foreach($po->cartitems as $cartitem)
        <table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_compactarticlerightBlock_6">
            <tbody>
            <tr class="row-a">
                <td bgcolor="#EDE8DA" align="center" class="section-padding" style="padding: 0px 15px 0px 15px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="500" style="padding: 0 0 20px 0;"
                           class="responsive-table">
                        <tbody>
                        <tr>
                            <td valign="top" style="padding: 40px 0 0 0;" class="mobile-hide"><img alt="{{asset($cartitem->product->thumbImage)}}" width="105" border="0"
                                                                                                   style="display: block; font-family: Arial; color: #3F3D33; font-size: 14px; width: 105px;"
                                                                                                   src="{{asset($cartitem->product->thumbImage)}}">
                            </td>
                            <td style="padding: 40px 0 0 0;" class="no-padding">
                                <!-- ARTICLE -->
                                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                    <tr>
                                        <td align="right" class="padding-meta"
                                            style="padding: 0 25px 5px 0px; font-size: 13px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #3F3D33;">
                                            {{$cartitem->product->manufactory}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" class="padding-copy"
                                            style="padding: 0 25px 5px 0px; font-size: 22px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #3F3D33;">
                                            {{$cartitem->product->name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" class="padding-copy articletextlightStyle"
                                            style="padding: 10px 25px 15px 0px; font-size: 16px; line-height: 24px; font-family: Helvetica, Arial, sans-serif; color: #3F3D33;">
                                            <p style="margin-top:0px">
                                                数量：{{$cartitem->qty}}
                                            </p></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>

                        </tr>
                        @if($cartitem->product->id !="221")
                            <tr>
                                <td colspan="2">
                                    <p style="font-size: 1.5em;">效果</p>
                                    {!! $cartitem->product->efficacy !!}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p style="font-size: 1.5em;">服用方法</p>
                                    {!! $cartitem->product->description !!}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p style="font-size: 1.5em;">效果</p>
                                    {!! $cartitem->product->website !!}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    @endforeach
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
                        style="padding: 0 0 10px 0px; font-size: 25px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff;">
                        总计数量：{{$po->cart_Qty}}
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
@endsection