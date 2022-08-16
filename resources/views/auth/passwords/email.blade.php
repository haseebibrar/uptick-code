@extends('layouts.front')

@section('content')
<div class="container frontData frontDataSec">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-md-center align-items-center vh-80">
            <div class="card shadow-lg p-5 bg-white rounded">
                <h1>{{ __('Forgot password?') }}</h1>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="row mb-4" style="font-size:17px;">Enter the email address associated with your account</div>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input id="email" placeholder="Email" type="email" class="form-control brdrBtm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <span class="spanBtm">Probably your work email</span>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
