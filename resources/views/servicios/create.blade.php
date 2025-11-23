@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-tools"></i> {{ __('Nuevo servicio') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="nuevo-servicio" action="{{ route('servicios.store') }}" method="post">
                                    @csrf
                                    @if ($errors->any())
                                    <div class="custom-error-container" id="custom-error-container">
                                        <ul class="custom-error-list">
                                            @foreach ($errors->all() as $error)
                                            <li class="custom-error-item">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group required mb-3">
                                        <label for="nombre" class="fw-bold form-label">{{ __('Nombre') }}</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="posicion" class="fw-bold form-label">{{ __('Posición') }}</label>
                                        <input type="number" class="form-control" id="posicion" name="posicion" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="precio" class="fw-bold form-label">{{ __('Precio') }}</label>
                                        <input type="number" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="precio" name="precio" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="iva" class="fw-bold form-label">{{ __('IVA (%)') }}</label>
                                        <select name="iva" id="iva" class="form-select form-select-sm">
                                            <option value="0">{{ __('0% - Exento') }}</option>
                                            <option value="4">{{ __('4% - Superreducido') }}</option>
                                            <option value="10">{{ __('10% - Reducido') }}</option>
                                            <option value="21" selected>{{ __('21% - General') }}</option>
                                        </select>
                                        <small class="text-muted">{{ __('Por defecto 21% (IVA general en España)') }}</small>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                            <a class="btn btn-dark mx-1" href={{ route('servicios.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('nuevo-servicio').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>	
@endsection