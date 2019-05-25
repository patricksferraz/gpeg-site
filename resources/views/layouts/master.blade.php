<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="Author" content="{{ config('app.author') }}"/>
    <meta name="description" content="@yield('hdescription', 'O Grupo de Pesquisa em Educação e Gestão (GPEG) é formado por um grupo multidisciplinar de pesquisadores, da Universidade Estadual de Santa Cruz (UESC) e de outras instituições nacionais e internacionais, sob a coordenação da Profa. Dra. Josefa Sônia Pereira da Fonseca. O objetivo dos pesquisadores é, por meio da pesquisa, responder questões relacionadas à Gestão de Organizações de Ensino, à Formação docente e à História da Educação. Desse modo, o GPEG tem o propósito de contribuir com as inquietações sobre educação, bem como receber contribuições de interessados pela área. Tem como objetivo investigar as principais razões que influenciam os resultados das escolas no Ideb. Nesse universo, focaremos, especificamente, nas escolas públicas que atendam ao Ensino Médio, situadas no Estado da Bahia.')"/>
    <meta name="application-name" content = "{{ config('app.name') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="icon" type="image/x-icon" href="{{ mix('favicon.ico') }}">
    @section('headCss')
        {{-- <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}"/> --}}
        <link rel="stylesheet" type="text/css" href="{{ mix('css/all.css') }}"/>
    @show
    <title>GPEG | @yield('title', 'Home Page')</title>
</head>
<body>

    <header>
        @section('header')
            @include('partials.navs.header')
        @show
    </header>

    <main>
        @yield('content')
    </main>

    @include('partials.navs.footer')

    @section('footerScripts')
        {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
        <script src="{{ mix('js/all.js') }}"></script>
    @show

</body>
</html>
