<a href="{{route('catalog.category', $item->slug)}}" class="item__catalog">
    @if($item->thumbnail)
        <span class="img__item">
            <img src="{{$item->makeThumbnail($item->thumbnail, '130x130', $item->id, 'resize')}}" alt="">
    </span>
    @endif
    <h3 class="h3_title__site h3_black__site alCenter">{{$item->name}}</h3>
</a>
