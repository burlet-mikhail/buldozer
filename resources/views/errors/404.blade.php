@extends('layout.app')

@section('content')
    <div class="page-product section-gray">
        <div class="container">
            <div class="inner">
                <ul class="breadcrumbs">
                    <li><a href="/">Главная</a></li>
                    <li><span>404</span></li>
                </ul>
                <h1 class="h1-title text-center mt-2" style="text-align: center; margin-bottom: 20px;">404</h1>

                <div class=" text-center" style="text-align: center;">
                    <p>Страница не найдена</p>
                    <a data-delay="0.7s" href="/" class="btn__site scroll_click  " style="display: block;margin-left: auto;
                    margin-right: auto;margin-top: 20px;"><span>Вернутся на главную</span></a>

                </div>
            </div>
        </div>


    </div>
@endsection
