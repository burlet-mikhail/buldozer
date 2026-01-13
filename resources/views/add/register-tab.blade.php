<div class="wrap_form__add">

    <div class="item__form">
        <div class="add_tabs__add_page tabs_mb">
            <div class="labelbox">Что бы добавить объявление вам необходимо быть
                зарегистрированным
            </div>
            <div class="top__add_tabs">
                <div class="item__top active_tab" data-target="tab-profile-1">Вход</div>
                <div class="item__top" data-target="tab-profile-2">Регистрация</div>
            </div>
            <div data-tab="tab-profile-1" class="bot__add_tabs active_tab">
                <form method="POST" class="form__add" action="{{ route('login') }}">
                    @csrf


                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input class="block mt-1 w-full" type="email"
                                  name="email"
                                  :value="old('email')" required autofocus
                                  autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>


                    <x-input-label for="password" value="Пароль"/>
                    <x-text-input type="password" name="password"
                                  required autocomplete="current-password"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>


                    <div class=" input__item">
                        <div class="catalog__checkboxes ">
                            <div class="item__catalog"
                                 style="display: flex;justify-content: space-between;flex-wrap: wrap;width: 100%;">
                                <div class="btn__item">
                                    <label class="label-check option"
                                           style="display: flex;align-items: center;"><input
                                            name="remember" type="checkbox"
                                            class="label-check__input"><span
                                            class="label-check__new-input"></span>

                                        <span class="text__item on_click_checked_neighbour"
                                              style="margin-left: 10px;">Запомнить меня
                                                            </span>
                                    </label></div>

                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                       href="{{ route('password.request') }}">
                                        Забыли пароль?
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>


                    <x-primary-button>Войти</x-primary-button>


                </form>
            </div>
            <div data-tab="tab-profile-2" class="bot__add_tabs">
                <form method="POST" class="form__add" action="{{ route('register') }}">
                    @csrf
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('ФИО')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text"
                                      name="name" :value="old('name')" required autofocus
                                      autocomplete="name"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('Телефон')"/>
                        <x-text-input class="block mt-1 w-full" type="text"
                                      name="phone" :value="old('phone')"
                                      required autofocus
                                      autocomplete="phone"/>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                    </div>


                    <div class="mess__item">
                        <div class="labelbox">Мессенджеры на номере:</div>
                        <div class="catalog__mess">
                            <div class="item__catalog">
                                <div class="btn__item">
                                    <label class="label-check option">
                                        <input name="whatsapp" type="checkbox"
                                               class="label-check__input">
                                        <span class="label-check__new-input"></span>
                                    </label>
                                </div>
                                <div class="img__item on_click_checked_neighbour">
                                    <img src="../images/icons/whatsapp.png" alt="">
                                </div>
                            </div>
                            <div class="item__catalog">
                                <div class="btn__item">
                                    <label class="label-check option">
                                        <input name="viber" type="checkbox"
                                               class="label-check__input">
                                        <span class="label-check__new-input"></span>
                                    </label>
                                </div>
                                <div class="img__item on_click_checked_neighbour">
                                    <img src="../images/icons/viber.png" alt="">
                                </div>
                            </div>
                            <div class="item__catalog">
                                <div class="btn__item">
                                    <label class="label-check option">
                                        <input name="telegram" type="checkbox"
                                               class="label-check__input">
                                        <span class="label-check__new-input"></span>
                                    </label>
                                </div>
                                <div class="img__item on_click_checked_neighbour">
                                    <img src="../images/icons/telegram.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')"/>
                        <x-text-input class="block mt-1 w-full" type="email"
                                      name="email" :value="old('email')" required
                                      autocomplete="username"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    <div class="checkboxes__item">
                        <div class="labelbox"></div>
                        <div class="catalog__checkboxes">
                            <div class="item__catalog">
                                <div class="btn__item">
                                    <label class="label-check option"
                                           style="display: flex;align-items: center;">
                                        <input type="checkbox" id="company-check"
                                               class="label-check__input">
                                        <span class="label-check__new-input"></span>
                                        <div style="margin-left: 10px;padding-top: 3px;"
                                             class="text__item on_click_checked_neighbour">
                                            Компания?
                                        </div>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mt-4" id="company_container" style="display: none;">
                        <x-input-label for="company" :value="__('Компания')"/>
                        <x-text-input id="company" class="block mt-1 w-full" type="text"
                                      name="company" :value="old('company')"
                                      autocomplete="company"/>
                        <x-input-error :messages="$errors->get('company')" class="mt-2"/>
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Пароль')"/>

                        <x-text-input class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      required autocomplete="new-password"/>

                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation"
                                       :value="__('Подтвердите пароль')"/>

                        <x-text-input class="block mt-1 w-full"
                                      type="password"
                                      name="password_confirmation" required
                                      autocomplete="new-password"/>

                        <x-input-error :messages="$errors->get('password_confirmation')"
                                       class="mt-2"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button style="background: none;" data-target="tab-profile-1">
                            Зарегистрированы?
                        </button>

                        <x-primary-button>Регистрация</x-primary-button>
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>
