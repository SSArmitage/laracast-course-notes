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

        <!-- 3 column layout section - repeated for timeline and profile -->
        <!-- if the user is not logged in, the '_sidebar-links' & '_friends-list' will casue errors to be thrown... in that case, remove these statments, log in, and the put them back -->
        <!-- need to put some kind of conditional here to check if user is logged in??? -->;
        <section class="px-8">
            <main class="container mx-auto">
                <!-- only for large screen flex & set width -->
                <div class="lg:flex lg:justify-between">
                    <!-- sidebar - links -->
                    @if(auth()->check())
                        <div class="lg:w-32">
                            @include('_sidebar-links')
                        </div>
                    @endif
                    <div 
                    class="lg:flex-1 lg:mx-10" 
                    style="max-width:700px">
                        @yield('content')
                    </div>
                    <!-- friends list -->
                    @if(auth()->check())
                        <div 
                        class="lg:w-1/6 bg-blue-100 p-4" 
                        style="
                            height:max-content;
                            border-radius:1.25rem"
                        >
                            @include('_friends-list')
                        </div>
                    @endif
                </div>
            </main>
        </section>

    </div>
</body>
</html>
