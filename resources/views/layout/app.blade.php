<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="icon" href="{{Vite::image('favicon.ico')}}">
    @vite([
    'resources/scss/libs.scss',
    'resources/scss/main.scss'
    ])


    @if(request()->is('/'))
        <title>Аренда спецтехники в {{regionName()}}</title>
        <meta name='title' content='Аренда спецтехники {{regionName()}}'>
        <meta name='description' content='Аренда спецтехники {{regionName()}}'>
        <meta name='keywords' content='Аренда спецтехники {{regionName()}}'>
    @else
        @php
            $title = seo()->meta()->title();

            if ($title !== env('APP_NAME')) {
                $title .= ' ' . regionName();
            }
        @endphp
        <title>{{$title}}</title>
        <meta name='title' content='{{$title}}'>
        @if(seo()->meta()->description())
            <meta name='description' content='{{seo()->meta()->description()}}'>
        @endif
        @if(seo()->meta()->keywords())
            <meta name='keywords' content='{{seo()->meta()->keywords()}}'>
        @endif

    @endif
    @livewireStyles

</head>
<body class="@yield('class')" id="app">
@include('shared.svg')
<div id="wrapper" class="wrapper bld__wrapper">
    @include('shared.header')

    <div class="content">
        @yield('content')
    </div>
    @include('shared.footer')
    @include('shared.modal')
</div>


@yield('script0')
@yield('script')
@vite([
'resources/js/app.js',
])

@livewireScripts

@if(app()->isProduction())
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(96974874, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/96974874" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

@endif
</body>
</html>
