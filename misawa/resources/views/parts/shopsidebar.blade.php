<div class="widget widget-filter-links hidden-xs clearfix">

    @foreach($global["cats"] as $cat)
            <h4 style="margin-top: 20px;font-weight: 700;">{{$cat->name}}</h4>
            <ul>
                @foreach($cat->subcatalogues as $subcatalogue)
    
                    @if($sub_now_id==$subcatalogue->id)
    
                        <li style="border-bottom: solid 2px #1ABC9C;">
                            <a href="{{route('shop_catalogueproducts',["id"=>$subcatalogue->id])}}"
                            >{{$subcatalogue->name}}</a>
                            <span style="background-color: #1ABC9C;color: white;">{{$subcatalogue->count}}</span>
    
                        </li>
                    @else
                        <li>
                            <a href="{{route('shop_catalogueproducts',["id"=>$subcatalogue->id])}}">{{$subcatalogue->name}}</a>
                            <span>{{$subcatalogue->count}}</span>
    
                        </li>
                    @endif
                @endforeach
            </ul>
        
    @endforeach

        @role(['customer','distributor','customerAdmin','superadmin'])
            <div class="topmargin-lg">
                <p class="nomargin">如果有任何需求，请联系我们</p>
                <img style="width: 100%;" src="{{asset('/images/wechatpay.jpg')}}" alt="">
            </div>
        @endrole
</div>