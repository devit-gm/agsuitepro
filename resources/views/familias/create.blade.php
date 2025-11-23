@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-tag"></i> {{ __('Nueva familia') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="nueva-familia" action="{{ route('familias.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
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
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="body" class="fw-bold form-label">{{ __('Imagen') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="file-name-imagen" readonly placeholder="{{ __('Ningún archivo seleccionado') }}">
                                            <label class="input-group-text" for="imagen" style="cursor: pointer;">{{ __('Seleccionar archivo') }}</label>
                                            <input type="file" id="imagen" name="imagen" required onchange="updateFileName(this, 'file-name-imagen')" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="title" class="fw-bold form-label">{{ __('Posición') }}</label>
                                        <input type="number" class="form-control" id="posicion" name="posicion" required>
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
                            <a class="btn btn-dark mx-1" href={{ route('familias.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" class="btn btn-success mx-1" onclick="document.getElementById('nueva-familia').submit();"><i class="bi bi-floppy"></i></button>
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