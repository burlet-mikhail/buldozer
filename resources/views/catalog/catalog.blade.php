@extends('layout.app')
@section('class', 'front-page')
@section('content')

    <main id="main" class="main">
        <div
            class="breadcrumbs__site inner breadcrumbs__seller_page breadcrumbs__list_page">
            <ul>
                <li><a href="/">Главная</a></li>
                @if($category || $city)
                    <li><a href="{{route('catalog')}}">Каталог</a></li>
                @endif
                @if($city)
                    <li>
                        <a href="{{route('catalog.city', ['city' => $city->slug])}}">
                            {{$city->name}}</a></li>
                @endif
                @if($category)
                    <li>
                        <a href="{{route('catalog.category', ['category' => $category->slug])}}">
                            {{$category->name}}</a></li>
                @endif
                @if(!$category && !$city)
                    <li>Каталог</li>
                @endif

            </ul>
        </div>
        <div class="title_block__list_page inner ">
            <div class="left__title_block">
                @if($category)
                    <h1 class="h2_title__site h2_black__site">{{$category->name}}</h1>
                @else
                    <h1 class="h2_title__site h2_black__site">Каталог</h1>
                @endif
                @if($categories->count())
                    <div class="select__left">
                        <label class="labelbox" for="select_search"></label>
                        <select name="select_search" id="select_search">


                            @if($city)
                                <option selected
                                        value="{{route('catalog.city', ['city' => $city?->slug])}}">
                                    Категории
                                </option>
                            @else
                                <option selected
                                        value="{{route('catalog')}}">
                                    Категории
                                </option>
                            @endif



                            @foreach($categories as $cat)
                                <option @selected($category?->id === $cat?->id)
                                        value="{{route('catalog.category',   ['category' => $cat, 'city' => $city])}}">
                                    {{$cat->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="text__title_block">

                @if($products)
                    {{$products->total()}}
                    {{trans_choice('объявление|объявления|объявлений', $products->total(),   [], 'ru')}}
                @endif

            </div>
        </div>

        <div class="city_block__list_page inner ">
            @foreach($cities as $i=> $item)
                <div class="item__city @if($city?->name === $item->name) active_item__city @endif">
                    <a href="{{route('catalog.city', ['city' => $item->slug, 'category' => $category?->slug])}}"> {{$item->name}}</a>
                </div>
            @endforeach
            @if($cities->count() > 8)
                <div class="item__city show-all-city d-block">
                    <a href="#">Еще</a>
                </div>
            @endif

        </div>


        <section class="filtres__list_page inner " style="">
            <div class="on_mobile_btn__filtres"><span>Фильтры</span></div>
            <div class="filtres__catalog">


                <form action="" name="filtres__catalog" id="filtres__catalog" style="display: none;">
                    <div class="wrap__filtres">
                        <h4 class="title__filtres">Параметры</h4>
{{--                        @foreach(filters() as $filter)--}}
{{--                            {!! $filter !!}--}}
{{--                        @endforeach--}}


                        {{--                        <div class="item__filtres with_range_slider__filtres">--}}
                        {{--                            <h6 class="title__item">Масса, т</h6>--}}
                        {{--                            <div class="range_slider__item">--}}
                        {{--                                <div class="values__range_slider">--}}
                        {{--                                    <input type="text" id="range_slider_1_min" class="inputbox" data-index="0"--}}
                        {{--                                           value="5"/>--}}
                        {{--                                    <input type="text" id="range_slider_1_max" class="inputbox" data-index="1"--}}
                        {{--                                           value="35"/>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="slider__range_slider" id="range_slider_1"></div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="item__filtres with_range_slider__filtres">--}}
                        {{--                            <h6 class="title__item">Ширина отвала, мм</h6>--}}
                        {{--                            <div class="range_slider__item">--}}
                        {{--                                <div class="values__range_slider">--}}
                        {{--                                    <input type="text" id="range_slider_2_min" class="inputbox" data-index="0"--}}
                        {{--                                           value="5"/>--}}
                        {{--                                    <input type="text" id="range_slider_2_max" class="inputbox" data-index="1"--}}
                        {{--                                           value="35"/>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="slider__range_slider" id="range_slider_2"></div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="item__filtres with_range_slider__filtres">--}}
                        {{--                            <h6 class="title__item">Цена за час, руб</h6>--}}
                        {{--                            <div class="range_slider__item">--}}
                        {{--                                <div class="values__range_slider">--}}
                        {{--                                    <input type="text" id="range_slider_3_min" class="inputbox" data-index="0"--}}
                        {{--                                           value="5"/>--}}
                        {{--                                    <input type="text" id="range_slider_3_max" class="inputbox" data-index="1"--}}
                        {{--                                           value="35"/>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="slider__range_slider" id="range_slider_3"></div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="item__filtres with_range_slider__filtres">--}}
                        {{--                            <h6 class="title__item">Минимальный заказ</h6>--}}
                        {{--                            <div class="range_slider__item">--}}
                        {{--                                <div class="values__range_slider">--}}
                        {{--                                    <input type="text" id="range_slider_4_min" class="inputbox" data-index="0"--}}
                        {{--                                           value="5"/>--}}
                        {{--                                    <input type="text" id="range_slider_4_max" class="inputbox" data-index="1"--}}
                        {{--                                           value="35"/>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="slider__range_slider" id="range_slider_4"></div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="item__filtres">--}}
                        {{--                            <h6 class="title__item">Чекбоксы</h6>--}}
                        {{--                            <div class="checkboxes__item">--}}
                        {{--                                <div class="position__checkboxes">--}}
                        {{--                                    <div class="btn__position">--}}
                        {{--                                        <label class="label-check option">--}}
                        {{--                                            <input name="checkbox_1" type="checkbox" class="label-check__input">--}}
                        {{--                                            <span class="label-check__new-input"></span>--}}
                        {{--                                        </label>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="text__position on_click_checked_neighbour">Характеристика</div>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="position__checkboxes">--}}
                        {{--                                    <div class="btn__position">--}}
                        {{--                                        <label class="label-check option">--}}
                        {{--                                            <input name="checkbox_1" type="checkbox" class="label-check__input">--}}
                        {{--                                            <span class="label-check__new-input"></span>--}}
                        {{--                                        </label>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="text__position on_click_checked_neighbour">Характеристика</div>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="position__checkboxes">--}}
                        {{--                                    <div class="btn__position">--}}
                        {{--                                        <label class="label-check option">--}}
                        {{--                                            <input name="checkbox_1" type="checkbox" class="label-check__input">--}}
                        {{--                                            <span class="label-check__new-input"></span>--}}
                        {{--                                        </label>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="text__position on_click_checked_neighbour">Характеристика</div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="item__filtres">--}}
                        {{--                            <h6 class="title__item">Радиокнопки</h6>--}}
                        {{--                            <div class="radios__item">--}}
                        {{--                                <div class="position__radios">--}}
                        {{--                                    <div class="btn__position">--}}
                        {{--                                        <label class="label-check option">--}}
                        {{--                                            <input name="radio_1" type="radio" class="label-check__input">--}}
                        {{--                                            <span class="label-check__new-input"></span>--}}
                        {{--                                        </label>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="text__position on_click_checked_neighbour">Характеристика</div>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="position__radios">--}}
                        {{--                                    <div class="btn__position">--}}
                        {{--                                        <label class="label-check option">--}}
                        {{--                                            <input name="radio_1" type="radio" class="label-check__input">--}}
                        {{--                                            <span class="label-check__new-input"></span>--}}
                        {{--                                        </label>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="text__position on_click_checked_neighbour">Характеристика</div>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="position__radios">--}}
                        {{--                                    <div class="btn__position">--}}
                        {{--                                        <label class="label-check option">--}}
                        {{--                                            <input name="radio_1" type="radio" class="label-check__input">--}}
                        {{--                                            <span class="label-check__new-input"></span>--}}
                        {{--                                        </label>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="text__position on_click_checked_neighbour">Характеристика</div>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="position__radios">--}}
                        {{--                                    <div class="btn__position">--}}
                        {{--                                        <label class="label-check option">--}}
                        {{--                                            <input name="radio_1" type="radio" class="label-check__input">--}}
                        {{--                                            <span class="label-check__new-input"></span>--}}
                        {{--                                        </label>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="text__position on_click_checked_neighbour">Характеристика</div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                    <button type="submit" class="button button__filtres"><span>Фильтровать</span></button>
                </form>
            </div>
        </section>
        <section id="lately_block__main_page"
                 class="lately_block__main_page lately_block__object_page lately_block__seller_page lately_block__list_page ">
            <div class="inner">
                <div class="catalog__lately">
                    @each('catalog.shared.product', $products, 'item')
                </div>

                @if(count($products) === 0)
                    <p class="">
                        <span>Ничего не найдено</span>
                    </p>
                @endif

                {{$products->withQueryString()->links()}}

            </div>
        </section>

        @if($category?->exists())

            <div class="about">
                <div class="bg-overlay"></div>
                <div class="container">
                    <h2 class="h2-title"><span>{{$category->name}}</span></h2>
                    <div class="text">
                        {{$category->description}}
                    </div>
                </div>
            </div>
        @endif
    </main>

@endsection

@section('script0')

    <script src="/assets/js/rangeslider.min.js"></script>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {

    })
</script>

@stack('scripts')
