@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-tools"></i> {{ __('Editar servicio') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="editar-servicio" action="{{ route('servicios.update', $servicio->uuid) }}" method="post">
                                    @csrf
                                    @method('PUT')
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
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $servicio->nombre }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="posicion" class="fw-bold form-label">{{ __('Posición') }}</label>
                                        <input type="number" class="form-control" id="posicion" name="posicion" value="{{ $servicio->posicion }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="precio" class="fw-bold form-label">{{ __('Precio') }}</label>
                                        <input type="number" step='0.01' placeholder='0.00' class="form-control" id="precio" name="precio" value="{{ $servicio->precio }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="iva" class="fw-bold form-label">{{ __('IVA (%)') }}</label>
                                        <select name="iva" id="iva" class="form-select form-select-sm">
                                            <option value="0" {{ ($servicio->iva ?? 21) == 0 ? 'selected' : '' }}>{{ __('0% - Exento') }}</option>
                                            <option value="4" {{ ($servicio->iva ?? 21) == 4 ? 'selected' : '' }}>{{ __('4% - Superreducido') }}</option>
                                            <option value="10" {{ ($servicio->iva ?? 21) == 10 ? 'selected' : '' }}>{{ __('10% - Reducido') }}</option>
                                            <option value="21" {{ ($servicio->iva ?? 21) == 21 ? 'selected' : '' }}>{{ __('21% - General') }}</option>
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
                    <form action="{{ route('servicios.destroy', $servicio->uuid) }}" method="post">
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('servicios.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('editar-servicio').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                            @if ($servicio->borrable == 1)
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mx-1 my-1" title="{{ __('Eliminar servicio') }}" onclick="return confirm('{{ __('¿Está seguro de eliminar el servicio?') }}');"><i class="bi bi-trash"></i></button>
                            @endif
                        </div>
                    </form>
                </div>
				
@endsection