<div class="hidden">
    <div class="b-modal" id="modal_city">

        <div class="box_content_modal__page_block modal_callback_class modal_city_class tabs_mb">
            <h2 class="h2_title__site h2_black__site">Выберите город</h2>
            <div id="tabs__modal" class="tabs__modal">
                <div class="top__tabs">
                    <div data-target="city-1" class="item__top active_tab">Все города</div>
                    <div data-target="city-2" class="item__top">Москва и МО</div>
                </div>
                <div class="bot__tabs">
                    <div data-tab="city-1" class="item__bot active_tab">
                        <div class="grid">

                            @foreach($regions as $key => $regionChunk)
                                <div class="position__item">
                                    <div class="title__position">{{$regionChunk['letter']}}</div>
                                    <div class="list__position">
                                        @foreach($regionChunk['regions'] as  $region)
                                            <div class="item__list">
                                                <a href="{{route('region', $region)}}">{{$region->name}}</a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                    <div data-tab="city-2" class="item__bot">


                        <div class="position__item">

                            <div class="list__position">

                                @if($moscow)
                                    @foreach($moscow->cities as $region)
                                        <div class="item__list ">
                                            <a href="{{route('catalog.city', $region)}}">{{$region->name}}</a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="hidden">
    <div class="b-modal" id="modal_callback">
        <div class="box_content_modal__page_block modal_callback_class">
            <h2 class="h2_title__site h2_black__site">Оставить заявку</h2>
            <div class="text__modal">Заполните форму и мы перезвоним вам <br>для уточнения деталей</div>
            <div class="form_box_faq_page_modal">
                <div class="inner">
                    <callback product="{{isset($product) ? $product->id : null}}"
                              user="{{auth()->check() ? auth()->user()->id : null}}">
                    </callback>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hidden">
    <div class="b-modal" id="thanks">
        <div class="box_content_modal__page_block modal_callback_class">
            <h2 class="h2_title__site h2_black__site">Спасибо</h2>
            <div class="text__modal">Ваша заявка отправлена, скоро мы вам перезвоним</div>
        </div>
    </div>
</div>
