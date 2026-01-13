@extends('layout.app')

@section('content')

    <main id="main" class="main">
        <section id="add_block__add_page" class="add_block__add_page">
            <div class="inner">
                <div class="wrap__add_block">
                    <div class="breadcrumbs__site">
                        <ul>
                            <li><a href="#">Главная</a></li>
                            <li>Установка пароля</li>
                        </ul>
                    </div>
                    <h1 class="h2_title__site h2_black__site">Установка пароля</h1>
                    <div class="wrap_form__add">


                        <div class="wrap_form__add">

                            <div class="item__form">
                                <div class="add_tabs__add_page tabs_mb">

                                    <form method="POST" action="{{ route('password.store') }}">
                                        @csrf

                                        <!-- Password Reset Token -->
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                        <!-- Email Address -->
                                        <div>
                                            <x-input-label for="email" :value="__('Email')"/>
                                            <x-text-input id="email" class="block mt-1 w-full" type="email"
                                                          name="email" :value="old('email', $request->email)"
                                                          required autofocus autocomplete="username"/>
                                            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                                        </div>

                                        <!-- Password -->
                                        <div class="mt-4">
                                            <x-input-label for="password" :value="__('Password')"/>
                                            <x-text-input id="password" class="block mt-1 w-full" type="password"
                                                          name="password" required autocomplete="new-password"/>
                                            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="mt-4">
                                            <x-input-label for="password_confirmation"
                                                           :value="__('Confirm Password')"/>

                                            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                                          type="password"
                                                          name="password_confirmation" required
                                                          autocomplete="new-password"/>

                                            <x-input-error :messages="$errors->get('password_confirmation')"
                                                           class="mt-2"/>
                                        </div>

                                        <div class="flex items-center justify-end mt-4">
                                            <x-primary-button>
                                                Сохранить
                                            </x-primary-button>
                                        </div>
                                    </form>


                                </div>


                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection




