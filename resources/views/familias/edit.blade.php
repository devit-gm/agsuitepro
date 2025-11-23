@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">

                <div class="card-header fondo-rojo"><i class="bi bi-tag"></i> {{ __('Editar familia') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="editar-familia" action="{{ route('familias.update', $familia->uuid) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    @if ($errors->any())
                                    <div class="custom-error-container">
                                        <ul class="custom-error-list">
                                            @foreach ($errors->all() as $error)
                                            <li class="custom-error-item">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group mb-3 required">
                                        <label for="title" class="fw-bold form-label">{{ __('Nombre') }}</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $familia->nombre }}" required>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <img width="100" class="float-end" src="{{ URL::to('/') }}/images/{{ $familia->imagen }}" />
                                        <div class="form-group">
                                            <label for="imagen" class="fw-bold form-label">{{ __('Imagen') }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="file-name-imagen" readonly placeholder="{{ __('Ningún archivo seleccionado') }}">
                                                <label class="input-group-text" for="imagen" style="cursor: pointer;">{{ __('Seleccionar archivo') }}</label>
                                                <input type="file" id="imagen" name="imagen" onchange="updateFileName(this, 'file-name-imagen')" style="display: none;" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="title" class="fw-bold form-label">{{ __('Posición') }}</label>
                                        <input type="number" class="form-control" id="posicion" name="posicion" value="{{ $familia->posicion }}" required>
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
                    <form action="{{ route('familias.destroy', $familia->uuid) }}" method="post">
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('familias.index') }}><i class="bi bi-chevron-left"></i></a>
                            <a href="{{ route('familias.view', $familia->uuid) }}" title="{{ __('Ver artículos de la familia') }}" class="btn btn-info mx-1 my-1"><i class="bi bi-list-ul"></i></a>
                            <button type="button" onclick="document.getElementById('editar-familia').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                            @if ($familia->borrable == 1)
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('{{ __('¿Está seguro de eliminar la familia?') }}');"><i class="bi bi-trash"></i></button>
                            @endif
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