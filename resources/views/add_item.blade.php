@extends('layout.app')

@section('content')

    <main id="main" class="main">
        <section id="add_block__add_page" class="add_block__add_page">
            <div class="inner">
                <div class="wrap__add_block">
                    <div class="breadcrumbs__site">
                        <ul>
                            <li><a href="/">Главная</a></li>
                            <li>Добавление объявления</li>
                        </ul>
                    </div>
                    <h1 class="h2_title__site h2_black__site">Добавление объявления</h1>
                    <div class="wrap_form__add">
                        @if(auth()->check())
                            @include('add.add-item-live')
                        @else
                            @include('add.register-tab')
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection


