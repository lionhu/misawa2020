<div class="widget widget-filter-links hidden-xs clearfix">

    @foreach($global["cats"] as $cat)
        <h4 style="margin-top: 20px;">{{$cat->name}}</h4>
        <ul>
            @foreach($cat->subcatalogues as $subcatalogue)

                    <li>
                        <a href="{{route('shop_catalogueproducts',["id"=>$subcatalogue->id])}}">{{$subcatalogue->name}}</a>
                        <span>{{$subcatalogue->count}}</span>

                    </li>
            @endforeach
        </ul>
    @endforeach
</div>