@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> {{ __('Ficha - Nuevo gasto') }}</div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="nuevo-gasto" action="{{ route('fichas.updategastos', $ficha->uuid) }}" method="post" enctype="multipart/form-data">
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
                                    <div class="form-group mb-3 required">
                                        <label for="usuario" class="fw-bold form-label">{{ __('Usuario') }}</label>
                                        <select name="usuario" id="usuario" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            @foreach ($usuariosFicha as $usuario)
                                            <!-- Si el usuario es el que esta logueado, lo seleccionamos por defecto -->
                                            @if($usuario->id == Auth::user()->id)
                                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="descripcion" class="fw-bold form-label">{{ __('Descripción') }}</label>
                                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="precio" class="fw-bold form-label">{{ __('Precio') }}</label>
                                        <input type="number" step='0.01' value="{{ old('precio') }}" placeholder='0.00' class="form-control" id="precio" name="precio" required>
                                    </div>
                                    @php
                                    if($ficha->tipo ==3 ){
                                    $ticket = 'required';
                                    }else{
                                    $ticket = '';
                                    }
                                    @endphp
                                    <div class="form-group mb-3 {{$ticket}}">
                                        <label for="ticket" class="fw-bold form-label">{{ __('Ticket') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="file-name-ticket" readonly placeholder="{{ __('Ningún archivo seleccionado') }}">
                                            <label class="input-group-text" for="ticket" style="cursor: pointer;">{{ __('Seleccionar archivo') }}</label>
                                            <input type="file" id="ticket" name="ticket" @if($ticket=="required" ) required @endif onchange="updateFileName(this, 'file-name-ticket')" style="display: none;">
                                        </div>
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
            <a class="btn btn-dark mx-1" href={{ route('fichas.gastos', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>
            <button type="button" onclick="document.getElementById('nuevo-gasto').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</div>
<script>
function updateFileName(input, inputId) {
    const fileName = input.files[0] ? input.files[0].name : '';
    document.getElementById(inputId).value = fileName;
}
</script>
@endsection