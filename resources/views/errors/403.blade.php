@extends('layouts.app')

@section('hide_nav')
@endsection

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center">
    <div class="row justify-content-center w-100">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-none fondo-rojo">
                    <i class="bi bi-exclamation-triangle"></i> {{ __('Operación no permitida') }}
                </div>

                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-exclamation-triangle" style="font-size: 4rem; color: #dc3545;"></i>
                    </div>
                    <h2 class="mb-3">{{ __('Operación no permitida') }}</h2>
                    <p class="text-muted mb-4">
                        {{ __('La operación que intentas realizar no está permitida.') }}
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
