@component('mail::message')
# Huhaiguang.com Visit lists

Following users visited in the last 6-hour:

@component('mail::table')
    | id            | name         | address  |   platform  | time  |
    | ------------- |:-------------:| --------:|:-------------:|:-------------:|
    @foreach($logs as $log)
    | {{$log->user_id}}      | {{$log->user_name}}       | {{$log->country}} <br> {{$log->province}}<br>{{$log->city}}     |{{$log->platform}}       |{{$log->created_at}}       |
    @endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
