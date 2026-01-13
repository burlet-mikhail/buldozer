<header id="header" class="header">
    <div class="pre__header">
        <div class="inner">

            @if ($name = regionName())
                <div class="city__header">Вся спецтехника в <br
                        class="br_city_mobile__header"><a data-fancybox data-src="#modal_city" href="javascript:;"
                                                          class="city__header-js">{{$name}}</a></div>
            @else
                <div class="city__header">
                    <a class="city__header-js" data-fancybox data-src="#modal_city" href="javascript:;">Выбрать
                        город</a>
                </div>
            @endif

            <a href="tel:88009002030" class="phone__header slideInBottomMy ">
            <span class="img__phone">
              <svg class="icon-svg">
                <use xlink:href="#phone_ico"></use>
              </svg>
            </span>
                <span class="text__phone">8 800 900 20 30</span>
            </a>
        </div>
    </div>
    <div class="main__header">
        <div class="inner">
            <a href="{{route('s.home', getSlug())}}" class="logo__header slideInBottomMy my_delay ">
                <img src="{{Vite::image('logo.webp')}}" alt="">
            </a>
            <nav class="menu__header">
                <ul class="ul__menu slideInBottomMy my_delay ">

                    @if($show_in_menu)
                        @foreach($show_in_menu as $item)
                            <li class="li__menu active1">
                                <a class="a__menu"
                                   href="{{route('catalog.category', ['category' => $item->slug, 'city' => isset($city) ? $city?->slug : null])}}">{{$item->name}}</a>
                            </li>
                        @endforeach
                    @endif

                    @if( $show_in_not_popular || $show_in_popular)
                        <li class="li__menu with_sub_menu">
                            @if($show_in_popular->count())
                                <a class="a__menu" href="#">Еще</a>
                            @endif
                            <ul class="sub_ul__menu">
                                <li class="container__sub_ul scrollbar-inner">
                                    <div class="row__sub_ul">
                                        @if($show_in_popular->count())
                                            <div class="title__row"><span>Популярная техника</span></div>
                                            <div class="container__row">

                                                @foreach($show_in_popular as $item)
                                                    <div class="sub_li__menu">
                                                        <a class="sub_a__menu"
                                                           href="{{route('catalog.category', ['category' => $item->slug, 'city' => isset($city) ? $city?->slug : null])}}">
                                                            {{$item->name}}</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    @if($show_in_not_popular->count())
                                        <div class="row__sub_ul">
                                            <div class="title__row"><span>Редкая техника</span></div>
                                            <div class="container__row">
                                                @foreach($show_in_not_popular as $item)
                                                    <div class="sub_li__menu">
                                                        <a class="sub_a__menu"
                                                           href="{{route('catalog.category', ['category' => $item->slug, 'city' => isset($city) ? $city?->slug : null])}}">
                                                            {{$item->name}}</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            </ul>
                        </li>
                    @endif

                </ul>
            </nav>
            <a href="{{route('announcement.index')}}" class="btn_car__header">
            <span class="img__btn_car slideInBottomMy my_delay ">
              <svg class="icon-svg">
                <use xlink:href="#plus_ico"></use>
              </svg>
            </span>
                <span class="text__btn_car slideInBottomMy my_delay ">Добавить машину</span>
            </a>
            <div class="burger__header slideInBottomMy my_delay ">
                <input type="checkbox" id="checkbox_menu" class="checkbox_menu visuallyHidden">
                <label for="checkbox_menu">
                <span class="db hamburger">
                  <span class="bar bar1"></span>
                  <span class="bar bar2"></span>
                  <span class="bar bar3"></span>
                  <span class="bar bar4"></span>
                </span>
                </label>
            </div>
        </div>
    </div>
</header>
