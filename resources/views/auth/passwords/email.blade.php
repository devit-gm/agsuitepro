@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center">
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            <div class="card d-flex flex-column">
                <div class="card-header fondo-rojo">{{ __('Reset Password') }}</div>

                <div class="card-body d-flex flex-column justify-content-center">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 d-flex flex-column align-items-center justify-content-center">

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-envelope-at"></i> {{ __('Recuperar contraseña') }}
                                </button>
                                <a class="btn btn-link color-rojo" href="{{ route('login') }}">
                                    << {{ __('Volver') }} </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection