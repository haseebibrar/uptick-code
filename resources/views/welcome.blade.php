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
        {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins" rel="stylesheet">
         --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <meta name="google-site-verification" content="XbMSSqM0fiA3vpNaSWY98ygdwyZTFa7NymBow21wPWQ" />
    </head>
    <body class="welcomeBody">
        <div class="container welcomeCont">
            <div class="row justify-content-center">
                <a class="navbar-brand logoimg" href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Uptick Logo" title="Uptick Logo" /></a>
                <div class="col-md-12 noBrd">
                    <div class="headSec">
                        <div class="headSecBtm"><h1>Welcome to Uptick!</h1>
                        <h2>Let's find the right fit for you</h2></div>
                    </div>
                </div>
                    
                
            </div>
            <div class="row btmSecMain">
                <div class="col-md-4 noBrd"><a href="{{ route('login') }}" class="btn btnMainScreen btnStudent">I'm a student</a></div>
                <div class="col-md-4 noBrd"><a href="/login/teacher" class="btn btnMainScreen btnTeacher">I'm a teacher</a></div>
                <div class="col-md-4 noBrd"><a href="/login/admin" class="btn btnMainScreen btnAdmin">I'm an admin</a></div>
            </div>
        </div>
    </body>
</html>
