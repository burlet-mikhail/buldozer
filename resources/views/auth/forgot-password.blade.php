@extends('layout.app')

@section('content')

    <main id="main" class="main">
        <section id="add_block__add_page" class="add_block__add_page">
            <div class="inner">
                <div class="wrap__add_block">
                    <div class="breadcrumbs__site">
                        <ul>
                            <li><a href="#">Главная</a></li>
                            <li>Сброс пароля</li>
                        </ul>
                    </div>
                    <h1 class="h2_title__site h2_black__site">Сброс пароля</h1>
                    <div class="wrap_form__add">

                        @if(auth()->check())
                            <add></add>
                        @else
                            <div class="wrap_form__add">

                                <div class="item__form">
                                    <div class="add_tabs__add_page tabs_mb">
                                        <div class="labelbox" style="font-weight: normal;">
                                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                                        </div>


                                        <!-- Session Status -->
                                        <x-auth-session-status class="mb-4" :status="session('status')"/>

                                        <form method="POST" class="form__add"
                                              action="{{ route('password.email') }}">
                                            @csrf

                                            <!-- Email Address -->
                                            <div>
                                                <x-input-label for="email" :value="__('Email')"/>
                                                <x-text-input id="email" class="block mt-1 w-full" type="email"
                                                              name="email"
                                                              :value="old('email')"
                                                              required autofocus/>
                                                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                                            </div>

                                            <div class="flex items-center justify-end mt-4">
                                                <x-primary-button>
                                                    Сбросить пароль
                                                </x-primary-button>
                                            </div>
                                        </form>


                                    </div>


                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
