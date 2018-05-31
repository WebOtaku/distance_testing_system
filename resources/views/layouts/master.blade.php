<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF-TOKEN --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>СДТ</title>

        {{-- CSS --}}
        <link rel="stylesheet" href="/css/app.css">

    </head>
    <body>

        <section class="section is-paddingless">

            <div class="container is-fluid">

                <header class="header">
                    @include ('layouts.header')
                </header>

                <main class="main" id="app">
                    @yield ('content')
                </main>

                {{--<footer class="footer">
                    @include ('layouts.footer')
                </footer>--}}

            </div>

        </section>

        <script src="/js/app.js" async></script>

    </body>
</html>