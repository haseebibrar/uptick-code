@extends('layouts.front')

@section('content')
<div class="container frontData">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-md-center align-items-center vh-80">
            <div class="card shadow-lg p-5 bg-white rounded">
                <h1>{{ __('Log in to your account') }}</h1>
                @isset($url)
                <form class="mt-4 mb-4" method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
                @else
                <form class="mt-4 mb-4" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @endisset
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <input id="email" placeholder="Email" type="email" class="form-control brdrBtm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <span class="spanBtm">Enter your work email</span>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input id="password" placeholder="Password" type="password" class="form-control brdrBtm @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if (Route::has('password.request'))
                                <a class="btn btn-link btnResetPass float-right" href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('Keep me logged in') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-lg btn-block btnSubmit">{{ __('Login') }}</button>
                        </div>
                    </div>
                </form>
                @isset($url)
                    @if($url === "teacher")
                        <div class="row mb-0 signUp">
                            <p>Didn't have an account? <a href="/register/teacher">{{ __('Sign Up') }}</a></p>
                        </div>
                    @endif
                @endisset
            </div>
        </div>
    </div>
</div>
@endsection
