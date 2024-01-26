{{-- @extends('layouts.auth') --}}
@extends('layouts.auth.master')
{{-- @section('content_auth')
<div class="row">
    <div class="img-holder">
        <div class="bg"></div>
        <div class="info-holder">
            <img src="{{ asset('public/logo/sima.png') }}">
        </div>
    </div>
    <div class="form-holder">
        <div class="form-content">
            <div class="form-items">
                <h3>Login to account</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input class="form-control" type="text" name="username" placeholder="Username" required>
                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                    <div class="form-button">
                        <button id="submit" type="submit" class="ibtn">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection --}}
@section('content')
<div class="col-md-6 col-lg-4">
    <div class="login-wrap p-0">
        <h3 class="mb-4 text-center">Login Apps</h3>
        <form method="POST" action="{{ route('login') }}" class="signin-form">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
            </div>
            <div class="form-group">
                <input id="password-field" name="password" type="password" class="form-control" placeholder="Password"
                    required>
                <span toggle="#password-field"
                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
            <div class="form-group">
                <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
            </div>
            {{-- <div class="form-group d-md-flex">
                <div class="w-50">
                    <label class="checkbox-wrap checkbox-primary">Remember Me
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="w-50 text-md-right">
                    <a href="#" style="color: #fff">Forgot Password</a>
                </div>
            </div> --}}
        </form>
    </div>
</div>
@endsection
{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
