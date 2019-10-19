<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Misawa Pharmacy</title>
    <link rel="stylesheet" href="{{asset('css/po_style.css')}}" media="all" />
</head>
<body>
<header class="clearfix">
    <div id="logo" style="width:60%;">
        <img src="{{asset('images/misawaheader.jpg')}}"  style="width:80%;">
    </div>
    <div id="company" style="width:40%;">
        <h2 class="name">ミサワ薬局</h2>
        <div>〒113-0022 東京都文京区千駄木2-43-2</div>
        <div>(81) 3-5815-8731</div>
        <div><a href="mailto:kpzh-order@misawa-jp.com">kpzh-order@misawa-jp.com</a></div>
    </div>
</header>
@yield("main_content")
<footer>
    Invoice was created on a computer and is valid without the signature and seal.
</footer>
@yield('jquery_afterscripts')
</body>
</html>