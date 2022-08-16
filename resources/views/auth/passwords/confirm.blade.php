@extends('layouts.front')

@section('content')
<div class="container frontData frontDataSec">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-md-center align-items-center vh-80">
            <div class="card shadow-lg p-5 bg-white rounded">
                <h1>{{ __('Confirm Password') }}</h1>
                {{ __('Please confirm your password before continuing.') }}
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input id="password" placeholder="Password" type="password" class="form-control brdrBtm @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-lg btn-block btnSubmit"> {{ __('Confirm Password') }}</button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link btnResetPass float-right" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
