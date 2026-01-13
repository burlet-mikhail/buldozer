@extends('layout.app')

@section('content')

    <main id="main" class="main">
        <section data-wow-delay="0.5s" id="object_block__object_page"
                 class="object_block__object_page ">
            <div class="inner">
                <div class="wrap__object_block">
                    <div class="breadcrumbs__site">
                        <ul>
                            <li><a href="/">Главная</a></li>
                            <li>
                                <a href="{{route('catalog')}}">Каталог</a>
                            </li>

                            @if($product->categories)
                                @foreach($product->categories as $cat)
                                    <li>
                                        <a href="{{route('catalog.category', $cat)}}">{{$cat->name}}</a>
                                    </li>
                                @endforeach
                            @endif
                            <li><span>{{$product->title}}</span></li>
                        </ul>
                    </div>
                    <h1 class="h2_title__site h2_black__site">{{$product->title}}</h1>
                    <div class="top__object">
                        @if($product->thumbnail && count($product->thumbnail) > 1)
                            <div class="slider__top">
                                <div class="swiper-container gallery-top-object">
                                    <div class="swiper-wrapper">
                                        @foreach($product->thumbnail as $image)
                                            <div class="swiper-slide">
                                                <a class="fancybox_modal"
                                                   href="{{image()->originalImage($image, $product->id)}}">
                                                    <img
                                                        src="{{$product->makeThumbnail($image, '620x480', $product->id, 'resize')}}"
                                                        alt="{{$product->title}}">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Add Arrows -->
                                    @if($product->thumbnail && count($product->thumbnail) > 1)
                                        <div class="swiper-button-prev my-swiper-button-prev">
                                            <svg class="icon-svg">
                                                <use xlink:href="#arrow_slider"></use>
                                            </svg>
                                        </div>
                                        <div class="swiper-button-next my-swiper-button-next">
                                            <svg class="icon-svg">
                                                <use xlink:href="#arrow_slider"></use>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                @if($product->thumbnail && count($product->thumbnail) > 1)
                                    <div class="swiper-container gallery-thumbs-object">
                                        <div class="swiper-wrapper">
                                            @foreach($product->thumbnail as $image)
                                                <div class="swiper-slide">
                                                    <img
                                                        src="{{$product->makeThumbnail($image, '620x480', $product->id, 'resize')}}"
                                                        alt="">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                        @else
                            @if($product->thumbnail )
                                @foreach($product->thumbnail as $image)
                                    <div class="single-img">
                                        <a class="fancybox_modal"
                                           href="{{image()->originalImage($image, $product->id)}}">
                                            <img
                                                src="{{$product->makeThumbnail($image, '620x480', $product->id, 'resize')}}"
                                                alt="{{$product->title}}">
                                        </a>
                                    </div>

                                @endforeach
                            @endif
                        @endif
                        <div class="info__top">
                            @if($product->price)
                                <div class="prices__info">
                                    <div class="item__prices">Цена: {{$product->price}}</div>
                                </div>
                            @endif
                            @if($product->min)
                                <div class="order__info">Минимальный заказ: <span>{{$product->min}}</span></div>
                            @endif

                            <div class="btns__info">
                                @if($product->contact)
                                    <div class="phone__cart phone__btns">
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
                                            <a href="tel:{{trim_phone($product->contact)}}"
                                               class="number__back">{{$product->contact}}</a>
                                            <div class="socials__back">

                                                @if(isset($product->messenger['whatsapp']) && $product->messenger['whatsapp'])
                                                    <a target="_blank"
                                                       href="https://wa.me/{{trim_phone($product->contact)}}"
                                                       class="item__socials">
                                                        <img src="{{Vite::image('icons/whatsapp.png')}}" alt="">
                                                    </a>
                                                @endif
                                                @if(isset($product->messenger['viber']) && $product->messenger['viber'])
                                                    <a target="_blank"
                                                       href="viber://chat?number={{trim_phone($product->contact)}}"
                                                       class="item__socials">
                                                        <img src="{{Vite::image('icons/viber.png')}}" alt="">
                                                    </a>
                                                @endif
                                                @if(isset($product->messenger['telegram']) && $product->messenger['telegram'])
                                                    <a target="_blank"
                                                       href="https://t.me/+{{trim_phone($product->contact)}}"
                                                       class="item__socials">
                                                        <img src="{{Vite::image('icons/telegram.png')}}" alt=""></a>
                                                @endif


                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <div class="phone__btns callback__btns modal_callback-js">
                                    <div class="front__phone">
                                        <div class="wrap__front" data-src="#modal_callback" data-fancybox="">
                                          <span class="img__front">
                                            <svg class="icon-svg">
                                              <use xlink:href="#mail_ico"></use>
                                            </svg>
                                          </span>
                                            <span class="text__front">Оставить заявку</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            @if($product->name)
                                <div class="company__info">
                                    <div class="name__company">
                                        {{$product->name}}
                                    </div>
                                </div>
                            @endif

                            <div class="docs__info">
                                <div class="num__docs">№ {{$product->id}}</div>
                                <div class="view__docs">{{$product->viewing}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="bot__object">
                        <div class="params__bot">
                            <h4 class="title__params">Характеристики</h4>
                            <div class="list__params">
                                @foreach($product->optionValues->keyValues() as $key => $values)
                                    <div class="position__list">
                                        <span>{{$key}}</span>
                                        <span>@foreach($values as $value)
                                                <span>{{$value->title}} </span>
                                            @endforeach</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="content__bot content_box_site">
                            {!! $product->text !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($upsells && count($upsells))
            <section id="lately_block__main_page" data-wow-delay="0.5s"
                     class="lately_block__main_page lately_block__object_page ">
                <div class="inner">
                    <h2 class="h2_title__site h2_black__site">Похожие объявления</h2>
                    <div class="catalog__lately">
                        @each('catalog.shared.product', $upsells, 'item')
                    </div>
                </div>
            </section>
        @endif
        @if($viewed && count($viewed))
            <section id="lately_block__main_page" data-wow-delay="0.5s"
                     class="lately_block__main_page lately_block__object_page ">
                <div class="inner">
                    <h2 class="h2_title__site h2_black__site">Просмотренные</h2>
                    <div class="catalog__lately">
                        @each('catalog.shared.product', $viewed, 'item')
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection
