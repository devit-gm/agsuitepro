@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-gear"></i> {{ __('Settings') }}</div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">
                                <form id="editar-ajustes" action="{{ route('ajustes.update') }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    @if (session('success'))
                                    <div class="custom-success-container" id="custom-success-container">
                                        <ul class="custom-success-list">
                                            <li class="custom-success-item">{{ session('success') }}</li>
                                        </ul>
                                    </div>
                                    @endif
                                    @if ($errors->any())
                                    <div class="custom-error-container">
                                        <ul class="custom-error-list">
                                            @foreach ($errors->all() as $error)
                                            <li class="custom-error-item">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group required mb-3">
                                        <label for="precio_invitado" class="fw-bold form-label">Cargo por invitado:</label>
                                        <input type="number" step="0.05" min='0.00' value='{{ $ajustes->precio_invitado }}' placeholder='0.00' class="form-control" id="precio_invitado" name="precio_invitado" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="max_invitados_cobrar" class="fw-bold form-label">Máximo de invitados con cargo:</label>
                                        <input type="number" min='0' placeholder='0' value="{{ $ajustes->max_invitados_cobrar }}" class="form-control" id="max_invitados_cobrar" name="max_invitados_cobrar" required>
                                    </div>

                                    <div class="form-group mb-3 required">
                                        <label for="primer_invitado_gratis" class="fw-bold form-label">Primer invitado sin cargo:</label>
                                        <select name="primer_invitado_gratis" id="primer_invitado_gratis" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            <option value="0" @if( $ajustes->primer_invitado_gratis == 0 ) selected @endif>No</option>
                                            <option value="1" @if( $ajustes->primer_invitado_gratis == 1 ) selected @endif>Sí</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3 required">
                                        <label for="activar_invitados_grupo" class="fw-bold form-label">Activar invitados de grupo:</label>
                                        <select name="activar_invitados_grupo" id="activar_invitados_grupo" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            <option value="0" @if( $ajustes->activar_invitados_grupo == 0 ) selected @endif>No</option>
                                            <option value="1" @if( $ajustes->activar_invitados_grupo == 1 ) selected @endif>Sí</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3 required">
                                        <label for="permitir_comprar_sin_stock" class="fw-bold form-label">Permitir comprar sin stock:</label>
                                        <select name="permitir_comprar_sin_stock" id="permitir_comprar_sin_stock" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            <option value="0" @if( $ajustes->permitir_comprar_sin_stock == 0 ) selected @endif>No</option>
                                            <option value="1" @if( $ajustes->permitir_comprar_sin_stock == 1 ) selected @endif>Sí</option>
                                        </select>
                                    </div>

                                </form>
                            </div>
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
                            <button type="button" onclick="document.getElementById('editar-ajustes').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>
		@endsection