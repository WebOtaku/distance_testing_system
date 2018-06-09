<!doctype html>
<html lang="{{ app()->getLocale() }}" class="has-navbar-fixed-top">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Система дистанционного тестирования для студентов ГБПОУ ЧТПТиУ">
        <meta name="keywords" content="Система, обучение, дистанционное обучение, ГБПОУ ЧТПТиУ, тестирование">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF-TOKEN --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Система дистанционного тестирования</title>

        {{-- CSS --}}
        <link rel="stylesheet" href="/css/app.css">
        <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js" async></script>

    </head>
    <body>

        <section class="section is-paddingless">

            <div class="container is-fluid" id="app">

                @include ('layouts.header')

                @yield ('content')

            </div>

        </section>

        <script src="/js/app.js" async></script>

    </body>
</html>