<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- change to the tailwind file -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <!-- header section -->
        <section class="px-8 py-4 mb-6">
            <header class="container mx-auto">
                <div style="display:flex;align-items:center;width:max-content">
                    <div style="width:50px">
                        <img src="/images/bird.png" alt="Tweety">
                    </div>
                    <h1 style="font-weight:bold">Tweety</h1>
                </div>
            </header>
        </section>

        @yield('content')

    </div>
</body>
</html>