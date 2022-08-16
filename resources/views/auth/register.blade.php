@extends('layouts.front')

@section('content')
<div class="container frontData">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-md-center align-items-center vh-80">
            <div class="card shadow-lg p-5 bg-white rounded">
                <h1>{{ __('Create a new account') }} </h1>
                <form class="mt-4 mb-4" method="POST" action='{{ url("register/teacher") }}' aria-label="{{ __('Register') }}">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <input id="name" placeholder="Full name" type="text" class="form-control brdrBtm @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <input id="email" placeholder="Email" type="email" class="form-control brdrBtm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <input id="password" placeholder="Password" type="password" class="form-control brdrBtm @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control brdrBtm" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-lg btn-block btnSubmit">{{ __('Sign up') }}</button>
                        </div>
                    </div>
                </form>
                <div class="row mb-0 signUp">
                    <p>Already have an account? <a href="/login/teacher">{{ __('Sign in') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
