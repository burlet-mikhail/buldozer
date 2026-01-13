@extends('layout.app')

@section('content')
    <main id="main" class="main">
        <section data-wow-delay="0.5s" id="text_block__text_page" class="text_block__text_page">
            <div class="inner">
                <div class="wrap__text_block">
                    <div class="breadcrumbs__site">
                        <ul>
                            <li><a href="/">Главная</a></li>
                            <li>{{$page->title}}</li>
                        </ul>
                    </div>
                    <h1 class="h2_title__site h2_black__site">{{$page->title}}</h1>
                    <div class="content_box_site">
                        {!! $page->text !!}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
