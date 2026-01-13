<div class="cart__site">
    <a href="{{route('products.show', ['product'=>$item]) }}" class="img__cart">
        @isset($item->thumbnail[0])
            <img src="{{$item->makeThumbnail($item->thumbnail[0], '620x480', $item->id, 'resize')}}" alt="">
        @endisset
    </a>
    <div class="wrap__cart">
        <h4 class="title__cart"><a href="{{route('products.show', ['product'=>$item]) }}">{{$item->title}}</a></h4>

        <div class="list__cart">
            @foreach($item->optionValues->keyValues() as $key => $values)
                @if($loop->index > 2)
                    @break
                @endif
                <div class="position__list">
                    <span>{{$key}}</span>
                    <div class="values" style="text-align: right;"><span>{{$values[0]->title}}</span></div>
                </div>
            @endforeach
        </div>
        @if($item->price)
            <div class="prices__cart">
                <div class="position__prices">
                    <span>Цена:</span>
                    <span>{{$item->price}}</span>
                </div>
            </div>
        @endif
        @if($item->contact)
            <div class="phone__cart ">
                <div class="front__phone">
                    <div class="wrap__front">
                      <span class="img__front">
                        <svg class="icon-svg">
                          <use xlink:href="#phone_catalog_ico"></use>
                        </svg>
                      </span>
                        <span class="text__front">Показать телефон</span>
                    </div>
                </div>
                <div class="back__phone" style="display: none;">
                    <a href="tel:{{trim_phone($item->contact)}}"
                       class="number__back">{{$item->contact}}</a>
                    <div class="socials__back">

                        @if(isset($item->messenger['whatsapp']) && $item->messenger['whatsapp'])
                            <a target="_blank"
                               href="https://wa.me/{{trim_phone($item->contact)}}"
                               class="item__socials">
                                <img src="{{Vite::image('icons/whatsapp.png')}}" alt="">
                            </a>
                        @endif
                        @if(isset($item->messenger['viber']) && $item->messenger['viber'])
                            <a target="_blank"
                               href="viber://chat?number={{trim_phone($item->contact)}}"
                               class="item__socials">
                                <img src="{{Vite::image('icons/viber.png')}}" alt="">
                            </a>
                        @endif
                        @if(isset($item->messenger['telegram']) && $item->messenger['telegram'])
                            <a target="_blank"
                               href="https://t.me/+{{trim_phone($item->contact)}}"
                               class="item__socials">
                                <img src="{{Vite::image('icons/telegram.png')}}" alt=""></a>
                        @endif


                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

