@extends('layout.app')

@section('content')

    <main id="main" class="main">
        <section id="add_block__add_page" class="add_block__add_page">
            <div class="inner">
                <div class="wrap__add_block">
                    <div class="breadcrumbs__site">
                        <ul>
                            <li><a href="#">Главная</a></li>
                            <li>Вход</li>
                        </ul>
                    </div>
                    <h1 class="h2_title__site h2_black__site">Вход</h1>
                    <div class="wrap_form__add">

                        <div class="wrap_form__add">

                            <div class="item__form">
                                <div class="add_tabs__add_page tabs_mb">
                                
                                    <div class="top__add_tabs">
                                        <div class="item__top active_tab" data-target="tab-profile-1">Вход</div>
                                        <div class="item__top" data-target="tab-profile-2">Регистрация</div>
                                    </div>
                                    <div data-tab="tab-profile-1" class="bot__add_tabs active_tab">
                                        <form method="POST" class="form__add" action="{{ route('login') }}">
                                            @csrf


                                            <x-input-label for="email" :value="__('Email')"/>
                                            <x-text-input id="email" class="block mt-1 w-full" type="email"
                                                          name="email"
                                                          :value="old('email')" required autofocus
                                                          autocomplete="username"/>
                                            <x-input-error :messages="$errors->get('email')" class="mt-2"/>


                                            <x-input-label for="password" value="Пароль"/>
                                            <x-text-input id="password" type="password" name="password"
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
                                                <x-input-label for="name" :value="__('Имя')"/>
                                                <x-text-input id="name" class="block mt-1 w-full" type="text"
                                                              name="name" :value="old('name')" required autofocus
                                                              autocomplete="name"/>
                                                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                                            </div>

                                            <!-- Email Address -->
                                            <div class="mt-4">
                                                <x-input-label for="email" :value="__('Email')"/>
                                                <x-text-input id="email" class="block mt-1 w-full" type="email"
                                                              name="email" :value="old('email')" required
                                                              autocomplete="username"/>
                                                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                                            </div>

                                            <!-- Password -->
                                            <div class="mt-4">
                                                <x-input-label for="password" :value="__('Пароль')"/>

                                                <x-text-input id="password" class="block mt-1 w-full"
                                                              type="password"
                                                              name="password"
                                                              required autocomplete="new-password"/>

                                                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="mt-4">
                                                <x-input-label for="password_confirmation"
                                                               :value="__('Подтвердите пароль')"/>

                                                <x-text-input id="password_confirmation" class="block mt-1 w-full"
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

                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
