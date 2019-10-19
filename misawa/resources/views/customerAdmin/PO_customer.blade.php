@extends("layouts.po_template")

@section("head_scripts")
@endsection



@section("main_content")

    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">INVOICE TO:</div>
                <h2 class="name">{!! $customer->sex !!}{!! $customer->name !!}</h2>
                <div class="address">〒{!! $customer->postcode !!} {!! $customer->address1 !!}</div>
                <div class="address">{!! $customer->address2 !!}</div>
                <div class="address">TEL: {!! $customer->phone !!}</div>
                <div class="email">Mail: <a href="mailto:{!! $customer->email !!}">{!! $customer->email !!}</a></div>
            </div>
            <div id="invoice">
                <h2>INVOICE #{{"KPZH01".$po->id}}</h2>
                <div class="date">Date: {{$po->created_at}}</div>
                <div class="date">EMS No: {{$po->delivery_no}}</div>
            </div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th class="no">#</th>
                <th class="desc">IMAGE</th>
                <th class="desc">DESCRIPTION</th>
                <th class="unit">PRICE</th>
                <th class="qty">QTY</th>
                <th class="total">TOTAL</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cart_items as $item)
                <tr>
                    <td class="no">
                        {{$item->product->id}}
                    </td>
                    <td class="desc">
                        <img width="90" src="{{asset($item->product->thumbImage)}}"
                             alt="Pink Printed Dress">
                    </td>
                    <td class="desc">
                        <h4>{{$item->product->name_jp}}</h4><br>
                        <small>SKU: {{$item->product->product_code}}</small> <br>
                        <small>メーカー： {{$item->product->manufactory}}</small>
                    </td>
                    <td class="unit money_jp">
                        {{$item->product->o_price}}
                    </td>
                    <td class="qty">{{$item->qty}}</td>
                    <td class="total money_jp">{{$item->total_o_price}}</td>
                </tr>
            @endforeach



            </tbody>
            <tfoot>
            <tr>
                <td colspan="3"></td>
                <td colspan="2">GRAND TOTAL</td>
                <td><span class="money_jp">{{$po->cart_O_Price}}</span></td>
            </tr>
            </tfoot>
        </table>
        <div id="thanks">いつも弊社のサービスをご利用頂きまして、 誠にありがとうございます。 <br>
            またのご利用を心よりお待ちしております。

        </div>
        <div id="notices">
            <div>NOTICE:</div>
            <div class="notice">
                 (1)ご自宅にお届ける時間について、通常は10日間が必要です。ただし、通関手続きで遅れる場合もございますので、あらかじめご了承下さい。<br>
                 (2)通関の際に、関税等が発生することがございます。その場合、発生した関税等は受取人さまのご負担となりますので、ご了承ください。　<br>
                 (3)個人使用目的となる製品ですが、他人への転売は禁止させていただきます。
            </div>
        </div>
        <hr>

        <div class="nobottommargin clearfix">
            <div class="col_half bottommargin-sm">
                <DIV>
                    <a href="">
                        創業昭和38年、
                        東京都において、薬と健康のプロフェッショナルとして、
                        皆様のために日夜ご奉仕し続けております</a>
                </DIV>
            </div>
        </div>
    </main>


@endsection

@section("jquery_scripts")


@endsection

@section("jquery_afterscripts")
    <script type='text/javascript' src="{{asset('js/currencyFormatter.js')}}"></script>

    <script>
        OSREC.CurrencyFormatter.formatAll(
            {
                selector: '.money_jp',
                symbol: '元',
                pattern: '#,##0!;(-#,##0!);0!'
            });
    </script>
@endsection
