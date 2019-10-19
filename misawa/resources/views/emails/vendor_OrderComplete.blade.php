@extends("emails.layouts.vendor")


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
                                                注文完了通知(#{!! $po->id !!})
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="padding-copy textintenseStyle"
                                                style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #ffffff;">
                                                <p style="margin-top:0;text-indent: 2em;">注文のご協力、ありがとうございました。無事にお客様へお届けしました。今後ともよろしくお願いします。</p>

                                                @include("emails.parts.customer_information_section")

                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="padding-copy textintenseStyle"
                                                style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #ffffff;">
                                                <a target="_new" class="mobile-button"
                                                   style="display: inline-block; font-size: 18px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #3F3D33; text-decoration: none; background-color: #EDE8DA; padding-top: 15px; padding-bottom: 15px; padding-left: 25px; padding-right: 25px; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-bottom: 3px solid #d9ceb1;"
                                                   href="https://trackings.post.japanpost.jp/services/srv/search/direct?searchKind=S004&locale=ja&reqCodeNo1={{$po->delivery_no}}&x=44&y=13">EMS:{{$po->delivery_no}} →</a>
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
