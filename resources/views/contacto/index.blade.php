@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-envelope"></i> {{ __('Contactar con el administrador') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    @if (session('success'))
                    <div class="custom-success-container" id="custom-success-container">
                        <ul class="custom-success-list">
                            <li class="custom-success-item">{{ session('success') }}</li>
                        </ul>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="custom-error-container" id="custom-error-container">
                        <ul class="custom-error-list">
                            <li class="custom-error-item">{{ session('error') }}</li>
                        </ul>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="custom-error-container" id="custom-error-container">
                        <ul class="custom-error-list">
                            @foreach ($errors->all() as $error)
                            <li class="custom-error-item">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form id="contacto-form" action="{{ route('contacto.send') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3 required">
                            <label for="asunto" class="fw-bold form-label">{{ __('Asunto') }}</label>
                            <input type="text" class="form-control @error('asunto') is-invalid @enderror" id="asunto" name="asunto" value="{{ old('asunto') }}" required maxlength="255">
                            @error('asunto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 required">
                            <label for="mensaje" class="fw-bold form-label">{{ __('Mensaje') }}</label>
                            <textarea class="form-control @error('mensaje') is-invalid @enderror" id="mensaje" name="mensaje" rows="8" required maxlength="2000">{{ old('mensaje') }}</textarea>
                            @error('mensaje')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <small class="form-text text-muted">{{ __('Máximo 2000 caracteres') }}</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<div class="card-footer">
    <form>
        <div class="d-flex align-items-center justify-content-center">
            <a href="{{ url()->previous() }}" class="btn btn-secondary mx-1"><i class="bi bi-x-circle"></i></a>
            <button type="button" onclick="document.getElementById('contacto-form').submit();" class="btn btn-success mx-1"><i class="bi bi-send"></i></button>
        </div>
    </form>
</div>
@endsection
