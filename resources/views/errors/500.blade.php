@extends('layouts.app')

@section('hide_nav')
@endsection

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center">
    <div class="row justify-content-center w-100">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-none fondo-rojo">
                    <i class="bi bi-exclamation-triangle"></i> {{ __('Error interno del servidor') }}
                </div>

                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-exclamation-triangle" style="font-size: 4rem; color: #dc3545;"></i>
                    </div>
                    <h2 class="mb-3">{{ __('Error interno del servidor') }}</h2>
                    <p class="text-muted mb-4">
                        {{ __('Se ha producido un error en el servidor. Por favor, recarga la página e inténtalo de nuevo.') }}
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button onclick="window.history.back()" class="btn btn-success">
                            <i class="bi bi-arrow-left"></i> {{ __('Volver') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
