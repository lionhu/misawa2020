@component('mail::message')
# まだ処理されていない注文が残っています。お手数をおかけしますが、至急処理のご協力をよろしくお願い申し上げます。

Orders to be processed:

@component('mail::table')
    | id            | status         | created time  |
    | :-------------: |:-------------:| :-------------:|
    @foreach($orders as $order)
    | {{$order->id}} | {{$order->status}} | {{$order->created_at}}|
    @endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
