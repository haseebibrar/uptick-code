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
    <link href="https://fonts.googleapis.com/css2?family=Poppins" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <meta name="google-site-verification" content="XbMSSqM0fiA3vpNaSWY98ygdwyZTFa7NymBow21wPWQ" />
</head>
<body>
    <div id="appFront">
        <main class="px-4 py-4 min-vh-100">
            <a class="navbar-brand logoimg" href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Uptick Logo" title="Uptick Logo" /></a>
            @yield('content')
        </main>
        <div id="appFrontBtm"></div>
    </div>
</body>
</html>
