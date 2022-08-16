@extends('layouts.front')

@section('content')
<div class="container frontData frontDataSec">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-md-center align-items-center vh-80">
            <div class="card shadow-lg p-5 bg-white rounded">
                <h1>{{ __('Reset Password') }}</h1>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input id="email" placeholder="Email" type="email" class="form-control brdrBtm @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
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
                            <input id="password" placeholder="Password" type="password" class="form-control brdrBtm @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control brdrBtm" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-lg btn-block btnSubmit">{{ __('Reset Password') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
