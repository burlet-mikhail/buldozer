<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                          autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                          autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


<div class="row">
    <div class="col-md-12">
        <div class="accordion-type-2">
            <div class="item-accordion-wrapper">
                <div class="accordion-head accordion-close collapsed" data-toggle="collapse"
                     data-parent="#accordion-1"
                     href="#accordion-1">
                    <span>Россия<i
                            class="fa fa-angle-down"></i></span>
                </div>
                <div id="accordion-1" class="panel-collapse collapse" style="height: 0px;">
                    <div class="accordion-body pl-0" style="padding-left: 34px;">

                        <div class="row" style="
    display: flex;
    flex-wrap: wrap;
">
                            <div class="col-md-6">
                                <div class="title">АРМТЕК</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: Московская обл., Мытищинский район, МКАД 86-й км, владение 13А, строение
                                    1<br>
                                    Телефон:&nbsp;+7 (495) 781-45-55<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">info@armtek.ru, podbor@armtek.ru</a><br>
                                    Сайт:&nbsp;<a href="https://armtek.ru/" target="_blank">armtek.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ТУРБОТРАКС</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: Московская обл., г. Долгопрудный, мкр. Павельцево, Новое шоссе, 30А<br>
                                    Телефон:&nbsp;8 800 333-07-67<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">info@turbotrucks.ru</a><br>
                                    Сайт:&nbsp;<a href="https://turbotrucks.ru/" target="_blank">turbotrucks.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">Форум-Авто</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: г. Москва,&nbsp;Солнечногорский проезд, 4<br>
                                    Телефон:&nbsp;+7 (495) 789-8000<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">info@forum-auto.ru</a><br>
                                    Сайт:&nbsp;<a href="https://forum-auto.ru/" target="_blank">forum-auto.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ООО «АГМ Ультра»</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: г. Москва, ул. Салтыковская, д. 8<br>
                                    Телефон:&nbsp;&nbsp;+7 (495) 926-85-12<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">agm-ultra@yandex.ru</a><br>
                                    Сайт:&nbsp;<a href="https://agm-ultra.ru/" target="_blank">agm-ultra.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">Truck star</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: г.&nbsp;Волгоград,&nbsp;ул. Генерала Романенко, д. 86<br>
                                    Телефон:&nbsp;+7 (8443) 21-00-01<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">info@truck-star.ru</a><br>
                                    Сайт:&nbsp;<a href="https://truck-star.ru/" target="_blank">truck-star.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ООО «Камавтокомплект»</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">

                                    Адрес: г. Набережные Челны,&nbsp;Мензелинский тракт, 32<br>
                                    Телефон:&nbsp;+7 (8552) 39-58-05, 39-58-06<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">kateko.ru@yandex.ru</a><br>
                                    Сайт:&nbsp;<a href="http://www.kateko.ru" target="_blank">www.kateko.ru</a><br>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ООО «Полюс+»</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: г. Ростов-на-Дону,&nbsp;пер. 1-й Машиностроительный, 15-А<br>
                                    Телефон:&nbsp;8 (800) 551-09-18, +7 (863) 307-60-00<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">inetmrkt@polusplus.ru</a><br>
                                    Сайт:&nbsp;<a href="http://www.polusplus.ru"
                                                  target="_blank">www.polusplus.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ТД Восход</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: г. Челябинск,&nbsp;ул. Сталеваров, 1Б<br>
                                    Телефон:&nbsp;+7 (351) 217-45-45<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">voshod@v-avto.ru</a><br>
                                    Сайт:&nbsp;<a href="https://v-avto.ru/" target="_blank">v-avto.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ООО «СтройПромКапитал»</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес:&nbsp;г.&nbsp;Москва,&nbsp;2-й Южнопортовый пр-д, 14/22<br>
                                    Телефон:&nbsp;+7 (495) 101-12-35<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">info@skladspk.ru</a><br>
                                    Сайт:&nbsp;<a href="https://skladspk.ru/" target="_blank">skladspk.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">Favorit</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: г. Москва,&nbsp;Научный проезд, д. 17<br>
                                    Телефон:&nbsp;+7 (495) 544-43-00<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">info@favorit-parts.ru</a><br>
                                    Сайт:&nbsp;<a href="https://favorit-parts.ru/"
                                                  target="_blank">favorit-parts.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ООО «Полюс+»</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: г. Москва,&nbsp;ул. Малыгина, д. 2, корп. 2<br>
                                    Телефон:&nbsp;+7 (925) 931-85-47, +7 (925) 931-82-58<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">i.msk@polusplus.ru</a><br>
                                    Сайт:&nbsp;<a href="http://www.polusplus.ru/"
                                                  target="_blank">www.polusplus.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ООО «Амтел»</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">

                                    Адрес: г. Санкт-Петербург,&nbsp;1-й Верхний переулок, дом 12, Литер А<br>
                                    Телефон:&nbsp;&nbsp;+7 (812) 456-24-71<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">alliance@amtel.club</a><br>
                                    nbsp;<a href="https://amtel.club" target="_blank">amtel.club</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ООО «Торговый Дом Энергия»</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">

                                    Адрес:&nbsp;г.&nbsp;Екатеринбург,&nbsp;ул. Крауля, д. 8, пом. 27<br>
                                    Телефон:&nbsp;+7 (343) 261-62-62<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">td.energy@akkmir.ru</a><br>
                                    nbsp;<a href="https://akkmir.ru/" target="_blank">akkmir.ru</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ИП Майер Андрей Викторович</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: г. Омск,&nbsp;ул. Лескова 2<br>
                                    Телефон:&nbsp;+7 (3812) 405-225, 405-445<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">info@akbray.ru</a><br>
                                    Сайт:&nbsp;<a href="https://akbopt55.ru/" target="_blank">akbopt55.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">Акбат</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: г. Рязань,&nbsp;196 км Окружной дороги, стр. 12<br>
                                    Телефон:&nbsp;+7 (4912) 575-442<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">akbat@bk.ru</a><br>
                                    Сайт:&nbsp;<a href="https://akbat.ru/" target="_blank">akbat.ru</a><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="title">ООО «АКБ-АВТО»</div>

                                <div class="accordion-body pl-0" style="padding-left: 0;">
                                    Адрес: Уфимский р-н, деревня Вавилово, улица Трактовая, дом № 5<br>
                                    Телефон:&nbsp;+7(347)266-39-06<br>
                                    Email:&nbsp;<a href="mailto:info@truck-star.ru">info@akb-ufa.ru</a><br>
                                    Сайт:&nbsp;<a href="https://akb-ufa.ru/" target="_blank">akb-ufa.ru</a><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="accordion-type-2">
            <div class="item-accordion-wrapper">
                <div class="accordion-head accordion-close collapsed" data-toggle="collapse"
                     data-parent="#accordion-9"
                     href="#accordion-9">
                    <span>Республика Беларусь<i class="fa fa-angle-down"></i></span>
                </div>
                <div id="accordion-9" class="panel-collapse collapse" style="height: 0px;">


                    <div class="accordion-body pl-0" style="padding-left: 34px;">


                        <div class="row" style="
    display: flex;
    flex-wrap: wrap;
">
                            <div class="col-md-6">
                                <div class="title">ООО «СВИАТ»</div>
                                Адрес: г. Минск,&nbsp;аг. Колодищи, ул. Минская, 56-6<br>
                                Телефон:&nbsp;+375295551221, +375295551221<br>
                                Email:&nbsp;<a href="mailto:order@sviat.by">order@sviat.by</a><br>
                                Сайт:&nbsp;<a href="http://www.sviat.by">www.sviat.by</a></div>
                            <div class="col-md-6">
                                <div class="title">ООО «Форвард Моторс»</div>


                                Адрес: Минская обл, Дзержинский р-н, г. Фаниполь, ул.Заводская, 41В<br>
                                Телефон:&nbsp;+375 (17) 388 02 56<br>
                                Email:&nbsp;<a
                                    href="mailto:info@truck-star.ru">pavel_belov@forward-motors.com</a><br>
                                Сайт:&nbsp;<a href="https://shop.forward-motors.com/"
                                              target="_blank">shop.forward-motors.com<br></a></div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


