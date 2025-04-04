@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center d-flex">
        <div class="col-md-6 flex-fill">

            <div class="card">

                <div class="card-header fondo-rojo">
                    {{ __('Login') }}
                </div>

                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ siteLogo() }}" style="width:150px; height:auto" class="mb-2">
                        <h1 class="color-rojo mb-2">{{ siteName() }}</h1>
                    </div>
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

                            <div class="col-md-6 password-container">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <i class="bi bi-eye toggle-password" id="togglePassword"></i>
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
                            <div class="col-md-12 ">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check2-circle"></i> {{ __('Access') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link color-rojo" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection