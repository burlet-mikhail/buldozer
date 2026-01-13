@extends('layout.app')
@section('class', 'front-page')
@section('content')
    <main id="main" class="main">
        <section id="first_block__main_page" class="first_block__main_page">
            <div class="bg__first_block"><img src="{{Vite::image('dest/backgrounds/bg_first.jpg')}}" alt=""></div>
            <div class="inner">
                <div data-delay="0.8s" class="asset__first_block  ">
                    <img src="{{Vite::image('dest/assets/tractor_asset.png')}}" alt="">
                </div>
                <h1 data-delay="0.5s" class="h1_title__site alLeft  ">


                    Аренда спецтехники
                    @if ($name = regionName())
                        в <br><a class="city__header-js" data-fancybox data-src="#modal_city">{{$name}}</a>
                    @endif


                </h1>
                <p data-delay="0.6s" class="text__first_block  ">Аренда спецтехники на выгодных
                    условиях на нужный вам период спецтехники <br>условиях на нужный вам период спецтехники на выгодных
                    условиях</p>
                <a data-delay="0.7s" href="/catalog" class="btn__site scroll_click  "><span>Поиск техники</span></a>
            </div>
        </section>

        @if(count($premiumProducts))
            <section id="order_block__main_page" class="order_block__main_page"
                     style="background-image: url('{{Vite::image('dest/backgrounds/bg_second.jpg')}}');">
                <div data-delay="0.9s" id="top__order" class="top__order  ">
                    <div class="inner">
                        <h2 class="h2_title__site alCenter">Ждут заказа</h2>
                        <div class="catalog__top">
                            @each('catalog.shared.product', $premiumProducts, 'item')
                            <div class="item__catalog">
                                <h3 class="h3_title__site h3_black__site m0a alCenter">Здесь могла бы быть <br>ваша
                                    техника
                                </h3>
                                <a href="{{route('announcement.index')}}" class="btn__site m0a"><span>Разместить</span></a>
                                <div class="abs_img__item">
                                    <img src="{{Vite::image('dest/assets/tractor_place_asset.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-delay="0.5s" id="bot__order" class="bot__order  " style="display: none;">
                    <div class="inner">
                        <h2 class="h2_title__site alCenter">Подбор по параметрам</h2>
                        <div class="on_mobile_btn_bot__order"><span>Фильтры</span></div>
                        <div class="catalog__bot">
                            <div class="filtres__catalog">
                                <form action="#" name="filtres__catalog" id="filtres__catalog">
                                    <div class="wrap__filtres">
                                        <h4 class="title__filtres">Параметры</h4>
                                        <div class="item__filtres">
                                            <h6 class="title__item">Тип спецтехники</h6>
                                            <div class="list__item scrollbar-inner">
                                                <div class="position__list separate_title__list">Популярная техника
                                                </div>
                                                <div class="position__list">Автовышки</div>
                                                <div class="position__list">Грейдеры</div>
                                                <div class="position__list active">Ассинизаторы</div>
                                                <div class="position__list">Асфальтоукладчики</div>
                                                <div class="position__list">Автовышки</div>
                                                <div class="position__list">Грейдеры</div>
                                                <div class="position__list">Ассинизаторы</div>
                                                <div class="position__list separate_title__list">Редкая техника</div>
                                                <div class="position__list">Асфальтоукладчики</div>
                                                <div class="position__list">Автовышки</div>
                                                <div class="position__list">Грейдеры</div>
                                                <div class="position__list">Ассинизаторы</div>
                                                <div class="position__list">Асфальтоукладчики</div>
                                                <div class="position__list">Автовышки</div>
                                                <div class="position__list">Грейдеры</div>
                                                <div class="position__list">Ассинизаторы</div>
                                                <div class="position__list">Асфальтоукладчики</div>
                                            </div>
                                        </div>
                                        <div class="item__filtres with_range_slider__filtres">
                                            <h6 class="title__item">Масса, т</h6>
                                            <div class="range_slider__item">
                                                <div class="values__range_slider">
                                                    <input type="text" id="range_slider_1_min"
                                                           class=" range-slider-ui  inputbox"
                                                           data-index="0" value="5"/>
                                                    <input type="text" id="range_slider_1_max"
                                                           class=" range-slider-ui  inputbox"
                                                           data-index="1" value="35"/>
                                                </div>
                                                <div class="slider__range_slider" id="range_slider_1"></div>
                                            </div>
                                        </div>
                                        <div class="item__filtres with_range_slider__filtres">
                                            <h6 class="title__item">Ширина отвала, мм</h6>
                                            <div class="range_slider__item">
                                                <div class="values__range_slider">
                                                    <input type="text" id="range_slider_2_min"
                                                           class=" range-slider-ui  inputbox"
                                                           data-index="0" value="5"/>
                                                    <input type="text" id="range_slider_2_max"
                                                           class=" range-slider-ui  inputbox"
                                                           data-index="1" value="35"/>
                                                </div>
                                                <div class="slider__range_slider" id="range_slider_2"></div>
                                            </div>
                                        </div>
                                        <div class="item__filtres with_range_slider__filtres">
                                            <h6 class="title__item">Цена за час, руб</h6>
                                            <div class="range_slider__item">
                                                <div class="values__range_slider">
                                                    <input type="text" id="range_slider_3_min"
                                                           class=" range-slider-ui  inputbox"
                                                           data-index="0" value="5"/>
                                                    <input type="text" id="range_slider_3_max"
                                                           class=" range-slider-ui  inputbox"
                                                           data-index="1" value="35"/>
                                                </div>
                                                <div class="slider__range_slider" id="range_slider_3"></div>
                                            </div>
                                        </div>
                                        <div class="item__filtres with_range_slider__filtres">
                                            <h6 class="title__item">Минимальный заказ</h6>
                                            <div class="range_slider__item">
                                                <div class="values__range_slider">
                                                    <input type="text" id="range_slider_4_min"
                                                           class=" range-slider-ui  inputbox"
                                                           data-index="0" value="5"/>
                                                    <input type="text" id="range_slider_4_max"
                                                           class=" range-slider-ui  inputbox"
                                                           data-index="1" value="35"/>
                                                </div>
                                                <div class="slider__range_slider" id="range_slider_4"></div>
                                            </div>
                                        </div>
                                        <div class="item__filtres">
                                            <h6 class="title__item">Чекбоксы</h6>
                                            <div class="checkboxes__item">
                                                <div class="position__checkboxes">
                                                    <div class="btn__position">
                                                        <label class="label-check option">
                                                            <input name="checkbox_1" type="checkbox"
                                                                   class="label-check__input">
                                                            <span class="label-check__new-input"></span>
                                                        </label>
                                                    </div>
                                                    <div class="text__position on_click_checked_neighbour">
                                                        Характеристика
                                                    </div>
                                                </div>
                                                <div class="position__checkboxes">
                                                    <div class="btn__position">
                                                        <label class="label-check option">
                                                            <input name="checkbox_1" type="checkbox"
                                                                   class="label-check__input">
                                                            <span class="label-check__new-input"></span>
                                                        </label>
                                                    </div>
                                                    <div class="text__position on_click_checked_neighbour">
                                                        Характеристика
                                                    </div>
                                                </div>
                                                <div class="position__checkboxes">
                                                    <div class="btn__position">
                                                        <label class="label-check option">
                                                            <input name="checkbox_1" type="checkbox"
                                                                   class="label-check__input">
                                                            <span class="label-check__new-input"></span>
                                                        </label>
                                                    </div>
                                                    <div class="text__position on_click_checked_neighbour">
                                                        Характеристика
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item__filtres">
                                            <h6 class="title__item">Радиокнопки</h6>
                                            <div class="radios__item">
                                                <div class="position__radios">
                                                    <div class="btn__position">
                                                        <label class="label-check option">
                                                            <input name="radio_1" type="radio"
                                                                   class="label-check__input">
                                                            <span class="label-check__new-input"></span>
                                                        </label>
                                                    </div>
                                                    <div class="text__position on_click_checked_neighbour">
                                                        Характеристика
                                                    </div>
                                                </div>
                                                <div class="position__radios">
                                                    <div class="btn__position">
                                                        <label class="label-check option">
                                                            <input name="radio_1" type="radio"
                                                                   class="label-check__input">
                                                            <span class="label-check__new-input"></span>
                                                        </label>
                                                    </div>
                                                    <div class="text__position on_click_checked_neighbour">
                                                        Характеристика
                                                    </div>
                                                </div>
                                                <div class="position__radios">
                                                    <div class="btn__position">
                                                        <label class="label-check option">
                                                            <input name="radio_1" type="radio"
                                                                   class="label-check__input">
                                                            <span class="label-check__new-input"></span>
                                                        </label>
                                                    </div>
                                                    <div class="text__position on_click_checked_neighbour">
                                                        Характеристика
                                                    </div>
                                                </div>
                                                <div class="position__radios">
                                                    <div class="btn__position">
                                                        <label class="label-check option">
                                                            <input name="radio_1" type="radio"
                                                                   class="label-check__input">
                                                            <span class="label-check__new-input"></span>
                                                        </label>
                                                    </div>
                                                    <div class="text__position on_click_checked_neighbour">
                                                        Характеристика
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="button button__filtres"><span>Подобрать</span></button>
                                </form>
                            </div>
                            <div class="positions__catalog">
                                <div class="cart__site horizontal_cart__site">
                                    <a href="#" class="img__cart"><img
                                            src="{{Vite::image('dest/backgrounds/bg_first.jpg')}}dest/assets/catalog_big_asset1.jpg"
                                            alt=""></a>
                                    <div class="wrap__cart">
                                        <h4 class="title__cart"><a href="#">МАЗ-Телескоп</a></h4>
                                        <div class="list__cart">
                                            <div class="position__list">
                                                <span>Мощность двигателя</span>
                                                <span>94 л/с</span>
                                            </div>
                                            <div class="position__list">
                                                <span>Грузоподъемность стрелы</span>
                                                <span>14 т</span>
                                            </div>
                                            <div class="position__list">
                                                <span>Грузозахват</span>
                                                <span>Крюк</span>
                                            </div>
                                        </div>
                                        <div class="prices__cart">
                                            <div class="position__prices">
                                                <span>Цена за час:</span>
                                                <span>2500 ₽</span>
                                            </div>
                                            <div class="position__prices">
                                                <span>Цена за смену:</span>
                                                <span>7000 ₽</span>
                                            </div>
                                        </div>
                                        <div class="phone__cart">
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
                                            <div class="back__phone">
                                                <a href="tel:88009002030" class="number__back">8 800 900 20 30</a>
                                                <div class="socials__back">
                                                    <a href="#" class="item__socials"><img
                                                            src="{{Vite::image('icons/whatsapp.png')}}"
                                                            alt=""></a>
                                                    <a href="#" class="item__socials"><img
                                                            src="{{Vite::image('icons/viber.png')}}"
                                                            alt=""></a>
                                                    <a href="#" class="item__socials"><img
                                                            src="{{Vite::image('icons/telegram.png')}}"
                                                            alt=""></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart__site horizontal_cart__site">
                                    <a href="#" class="img__cart"><img
                                            src="{{Vite::image('dest/assets/catalog_big_asset1.jpg')}}"
                                            alt=""></a>
                                    <div class="wrap__cart">
                                        <h4 class="title__cart"><a href="#">МАЗ-Телескоп</a></h4>
                                        <div class="list__cart">
                                            <div class="position__list">
                                                <span>Мощность двигателя</span>
                                                <span>94 л/с</span>
                                            </div>
                                            <div class="position__list">
                                                <span>Грузоподъемность стрелы</span>
                                                <span>14 т</span>
                                            </div>
                                            <div class="position__list">
                                                <span>Грузозахват</span>
                                                <span>Крюк</span>
                                            </div>
                                        </div>
                                        <div class="prices__cart">
                                            <div class="position__prices">
                                                <span>Цена за час:</span>
                                                <span>2500 ₽</span>
                                            </div>
                                            <div class="position__prices">
                                                <span>Цена за смену:</span>
                                                <span>7000 ₽</span>
                                            </div>
                                        </div>
                                        <div class="phone__cart">
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
                                            <div class="back__phone">
                                                <a href="tel:88009002030" class="number__back">8 800 900 20 30</a>
                                                <div class="socials__back">
                                                    <a href="#" class="item__socials"><img
                                                            src="{{Vite::image('icons/whatsapp.png')}}"
                                                            alt=""></a>
                                                    <a href="#" class="item__socials"><img
                                                            src="{{Vite::image('icons/viber.png')}}"
                                                            alt=""></a>
                                                    <a href="#" class="item__socials"><img
                                                            src="{{Vite::image('icons/telegram.png')}}"
                                                            alt=""></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart__site horizontal_cart__site">
                                    <a href="#" class="img__cart"><img
                                            src="{{Vite::image('dest/assets/catalog_big_asset1.jpg')}}"
                                            alt=""></a>
                                    <div class="wrap__cart">
                                        <h4 class="title__cart"><a href="#">МАЗ-Телескоп</a></h4>
                                        <div class="list__cart">
                                            <div class="position__list">
                                                <span>Мощность двигателя</span>
                                                <span>94 л/с</span>
                                            </div>
                                            <div class="position__list">
                                                <span>Грузоподъемность стрелы</span>
                                                <span>14 т</span>
                                            </div>
                                            <div class="position__list">
                                                <span>Грузозахват</span>
                                                <span>Крюк</span>
                                            </div>
                                        </div>
                                        <div class="prices__cart">
                                            <div class="position__prices">
                                                <span>Цена за час:</span>
                                                <span>2500 ₽</span>
                                            </div>
                                            <div class="position__prices">
                                                <span>Цена за смену:</span>
                                                <span>7000 ₽</span>
                                            </div>
                                        </div>
                                        <div class="phone__cart">
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
                                            <div class="back__phone">
                                                <a href="tel:88009002030" class="number__back">8 800 900 20 30</a>
                                                <div class="socials__back">
                                                    <a href="#" class="item__socials"><img
                                                            src="{{Vite::image('icons/whatsapp.png')}}"
                                                            alt=""></a>
                                                    <a href="#" class="item__socials"><img
                                                            src="{{Vite::image('icons/viber.png')}}"
                                                            alt=""></a>
                                                    <a href="#" class="item__socials"><img
                                                            src="{{Vite::image('icons/telegram.png')}}"
                                                            alt=""></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- in last block insert block another_btn__positions -->
                                <div class="cart__site horizontal_cart__site with_another_btn__positions">
                                    <!--
                                    <a href="#" class="img__cart"><img src="dest/assets/catalog_big_asset1.jpg" alt=""></a>
                                    <div class="wrap__cart">
                                      <h4 class="title__cart"><a href="#">МАЗ-Телескоп</a></h4>
                                      <div class="list__cart">
                                        <div class="position__list">
                                          <span>Мощность двигателя</span>
                                          <span>94 л/с</span>
                                        </div>
                                        <div class="position__list">
                                          <span>Грузоподъемность стрелы</span>
                                          <span>14 т</span>
                                        </div>
                                        <div class="position__list">
                                          <span>Грузозахват</span>
                                          <span>Крюк</span>
                                        </div>
                                      </div>
                                      <div class="prices__cart">
                                        <div class="position__prices">
                                          <span>Цена за час:</span>
                                          <span>2500 ₽</span>
                                        </div>
                                        <div class="position__prices">
                                          <span>Цена за смену:</span>
                                          <span>7000 ₽</span>
                                        </div>
                                      </div>
                                      <div class="phone__cart">
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
                                        <div class="back__phone">
                                          <a href="tel:88009002030" class="number__back">8 800 900 20 30</a>
                                          <div class="socials__back">
                                            <a href="#" class="item__socials"><img src="icons/whatsapp.png" alt=""></a>
                                            <a href="#" class="item__socials"><img src="icons/viber.png" alt=""></a>
                                            <a href="#" class="item__socials"><img src="icons/telegram.png" alt=""></a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    -->
                                    <div class="another_btn__positions">
                                        <div class="wrap__another_btn">
                                            <span class="text__another_btn">Другие результаты</span>
                                            <span class="img__another_btn">
                      <svg class="icon-svg">
                        <use xlink:href="#arrow_another_ico"></use>
                      </svg>
                  </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="abs_wave__order"><img src="{{Vite::image('dest/assets/waves_asset.png')}}" alt=""></div>
            </section>
        @endif
        @if(count($categories))
            <section id="technique_block__main_page" data-delay="0.5s" class="technique_block__main_page  ">
                <div class="inner">
                    <h2 class="h2_title__site h2_black__site  h2_title_arrows__site alCenter">
                        <span>Каталог спецтехники</span>
                    </h2>
                    <div class="catalog__technique">
                        @each('catalog.shared.category', $categories, 'item')
                    </div>
                </div>
            </section>
        @endif


        <section id="lately_block__main_page" data-delay="0.5s" class="lately_block__main_page  ">
            <div class="inner">
                <h2 class="h2_title__site h2_black__site  h2_title_arrows__site alCenter">
                    <span>Недавно добавленные</span></h2>
                <div class="catalog__lately">


                    @each('catalog.shared.product', $products, 'item')

                </div>
            </div>
        </section>
    </main>


    <div class="about">
        <div class="bg-overlay"></div>
        <div class="container">
            <h2 class="h2-title"><span>О НАС</span></h2>
            <div class="text">
                Наша компания действует на рынке аренды спецтехники на протяжении многих лет. За это время у нас
                сформировался значительный парк техники, был приобретен большой опыт в области строительной техники и
                грузоперевозок. Наша компания действует на рынке аренды спецтехники на протяжении многих лет. За это
                время у нас сформировался значительный парк техники, был приобретен большой опыт в области строительной
                техники и грузоперевозок.Наша компания действует на рынке аренды спецтехники на протяжении многих лет.
                За это время у нас сформировался значительный парк техники, был приобретен большой опыт в области
                строительной техники и грузоперевозок.
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="/rangeslider.min.js"></script>
    <link rel="stylesheet" href="/rangeslider.css">
@endsection
