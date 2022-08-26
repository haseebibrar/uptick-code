<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type='text/css'>
        <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type='text/css'>
        @stack('css')
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type='text/css'>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet" type='text/css'>
        <script type='text/javascript'>
            window.smartlook||(function(d) {
                var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
                var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
                c.charset='utf-8';c.src='https://web-sdk.smartlook.com/recorder.js';h.appendChild(c);
            })(document);
            smartlook('init', '0e05673c404dc8cf2492d62845867e877d366e2c', { region: 'eu' });
        </script>
        <meta name="google-site-verification" content="XbMSSqM0fiA3vpNaSWY98ygdwyZTFa7NymBow21wPWQ" />
    </head>
    <body>
        @php
            $myCurrentURL   = explode('/', Request::url());
            $myLogoURL      = $myCurrentURL[3];
            if(empty(Auth::user()->image)){
                $myImage = asset('images/placeholderimage.png');
            }else{
                $myImage = asset('images/users/'.Auth::user()->image);
            }
            if($myLogoURL === "teacher"){
                $myExpertise = Auth::user()->expertise;
            }else{
                $myExpertise = '';
            }
            if(Auth::guard('admin')->check())
                $editProL= 'editaprofile';
            elseif(Auth::guard('teacher')->check())
                $editProL= 'edittprofile';
            else{
                $myLogoURL = 'home';
                $editProL= 'editprofile';
            }
        @endphp
        <div id="appInner">
            <main class="px-2 py-2" style="background-color: #F8F8F8;">
                <div class="container innerData">
                    <div class="row justify-content-center">
                        <div class="px-4 py-4 col-md-1 myHeight" style="position:relative; background-color: #FFF;">
                            <div class="profilePnl txtCenter">
                                <img class="mx-auto d-block rounded-circle proImg" src="<?php echo $myImage; ?>" alt="{{ Auth::user()->name }} Image" title="{{ Auth::user()->name }} Image" />
                                <p class="usrName mb-0">{{ Auth::user()->name }}</p>
                                <p class="expertSec">{{ $myExpertise }}</p>
                                <a class="profileLink" href="{{ url('/'.$editProL.'/'.Auth::user()->id) }}">My Profile</a>
                            </div>
                            @if(Auth::guard('admin')->check())
                                @php
                                    $myGuard = 'admin';
                                @endphp
                                @if(Auth::user()->is_super < 1)
                                    <div class="txtCenter navLaftCnt mb-4">
                                       {{-- <a class="navLaft mb-2" href="/admin/departments"><img src="{{ asset('images/people.svg') }}" alt="Departments" title="Departments" /><br />Departments</a> --}}
                                    </div>
                                    <div class="btmCnt mt-auto">
                                        <div class="logoutDiv txtCenter mb-4">
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                                <img style="width:23px; height:23px;" src="{{ asset('images/logout.svg') }}" alt="Logout" title="Logout" /><br />{{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" value="{{ $myGuard }}" name="myguard">
                                            </form>
                                        </div>
                                        <a class="logoInner logoimg" href="{{ url('/'.$myLogoURL) }}"><img src="{{ asset('images/logo.png') }}" alt="Uptick Logo" title="Uptick Logo" /></a>
                                    </div>
                                @else
                                    <div class="txtCenter navLaftCnt mb-4">
                                        <a class="navLaft mb-2" href="/admin/teachers"><img src="{{ asset('images/people.svg') }}" alt="Teachers" title="Teachers" /><br />Teachers</a>
                                        <a class="navLaft mb-2" href="/admin/students"><img src="{{ asset('images/people.svg') }}" alt="Students" title="Students" /><br />Students</a>
                                        <a class="navLaft mb-2" href="/admin/companies"><img src="{{ asset('images/people.svg') }}" alt="Companies" title="Companies" /><br />Companies</a>
                                        <a class="navLaft mb-4" href="/admin/users"><img src="{{ asset('images/people.svg') }}" alt="Admin Users" title="Admin Users" /><br />Admin Users</a>
                                        <a class="navLaft mb-2" href="/admin/focusarea">Focus Area</a>
                                        <a class="navLaft mb-2" href="/admin/lessonsubject">Lesson Subjects</a>
                                        <a class="navLaft mb-2" href="/admin/departments">Departments</a>
                                        <div class="logoutDiv txtCenter mb-4">
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                                <img style="width:23px; height:23px;" src="{{ asset('images/logout.svg') }}" alt="Logout" title="Logout" /><br />{{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" value="{{ $myGuard }}" name="myguard">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="btmCnt mt-auto">
                                        <a class="logoInner logoimg" href="{{ url('/'.$myLogoURL) }}"><img src="{{ asset('images/logo.png') }}" alt="Uptick Logo" title="Uptick Logo" /></a>
                                    </div>
                                @endif
                            @elseif(Auth::guard('teacher')->check())
                                @php
                                    $myGuard = 'teacher';
                                @endphp
                                <div class="txtCenter navLaftCnt mb-4">
                                    <a class="navLaft mb-4 schedLesson{{ (request()->is('teacher')) ? ' active' : '' }}" href="/teacher">Scheduled <br />lessons<br />& availabilty</a>
                                    <a class="navLaft mb-4 openLesson{{ (request()->is('teacher/open-lesson')) ? ' active' : '' }}" href="/teacher/open-lesson">Open lessons</a>
                                    {{-- <a class="navLaft mb-4 lessonMaterial{{ (request()->is('teacher/lessons-materials')) ? ' active' : '' }}" href="/teacher/lessons-materials">Lesson's Materials</a> --}}
                                    <div class="logoutDiv txtCenter mb-4">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            <img style="width:23px; height:23px;" src="{{ asset('images/logout.svg') }}" alt="Logout" title="Logout" /><br />{{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                            <input type="hidden" value="{{ $myGuard }}" name="myguard">
                                        </form>
                                    </div>
                                </div>
                                <div class="btmCnt mt-auto">
                                    <a class="logoInner logoimg" href="{{ url('/'.$myLogoURL) }}"><img src="{{ asset('images/logo.png') }}" alt="Uptick Logo" title="Uptick Logo" /></a>
                                </div>
                            @else
                                @php
                                    //dd($checkreview);
                                    $myGuard = 'web';
                                @endphp
                                <div class="txtCenter navLaftCnt mb-4">
                                    @if(!isset($checkreview))
                                        @php
                                            $myAuthLink = '<a class="navLaft mb-4" href="/google/oauth">Authorize with<br />Google Calendar</a>';
                                            if(!empty(Auth::user()->googleAccounts)){
                                                foreach (Auth::user()->googleAccounts as $account){
                                                    $myAuthLink = '<form action="'.route('google.destroy', $account).'" method="post">
                                                        '.csrf_field().'
                                                        '.method_field('delete').'
                                                        <button type="submit" class="btn btn-outline-secondary btn-sm">UnAuthorize<br />Google Calendar</button>
                                                    </form>';
                                                }
                                            }   
                                        @endphp
                                        {!! $myAuthLink !!}
                                        <a class="navLaft mb-4 schedLesson{{ (request()->is('home')) ? ' active' : '' }}" href="/home">Schedule a<br />lesson</a>
                                        <a class="navLaft mb-4 pastLesson{{ (request()->is('past-future-lesson')) ? ' active' : '' }}" href="/past-future-lesson">Past and future<br />lessons</a>
                                    @endif
                                    <div class="logoutDiv txtCenter mb-4">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            <img style="width:23px; height:23px;" src="{{ asset('images/logout.svg') }}" alt="Logout" title="Logout" /><br />{{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                            <input type="hidden" value="{{ $myGuard }}" name="myguard">
                                        </form>
                                    </div>
                                </div>
                                <div class="btmCnt mt-auto">
                                    <a class="logoInner logoimg" href="{{ url('/'.$myLogoURL) }}"><img src="{{ asset('images/logo.png') }}" alt="Uptick Logo" title="Uptick Logo" /></a>
                                </div>
                            @endif
                        </div>
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
        <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
        @yield('scripts')
    </body>
</html>