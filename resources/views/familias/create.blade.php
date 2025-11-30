@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex h-100">
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
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="file-name-imagen" readonly placeholder="{{ __('Ningún archivo seleccionado') }}">
                                            <label class="input-group-text" for="imagen" style="cursor: pointer;">
                                                <i class="bi bi-folder2-open me-1"></i>{{ __('Seleccionar') }}
                                            </label>
                                            <button type="button" class="btn btn-outline-secondary" id="clear-imagen" style="display: none;" onclick="clearImageSelection()">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                            <input type="file" id="imagen" name="imagen" required onchange="handleImageSelection(this, 'file-name-imagen', 'preview-imagen')" accept="image/jpeg,image/jpg,image/png,image/webp" style="display: none;">
                                        </div>
                                        <div id="preview-imagen" class="text-center" style="display: none;">
                                            <img src="" alt="Preview" class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                                        </div>
                                        <small class="text-muted">{{ __('Formatos: JPG, PNG, WEBP. Máximo 2MB') }}</small>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="title" class="fw-bold form-label">{{ __('Posición') }}</label>
                                        <input type="number" class="form-control" id="posicion" name="posicion" required>
                                    </div>
                                    @php
                                        $ajustes = app('App\\Models\\Ajustes')::first();
                                    @endphp
                                    @if($ajustes && $ajustes->modo_operacion === 'mesas')
                                    <div class="form-group mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="mostrar_en_cocina" name="mostrar_en_cocina" value="1">
                                            <label class="form-check-label" for="mostrar_en_cocina">
                                                {{ __('Mostrar en cocina/mesas') }}
                                            </label>
                                        </div>
                                    </div>
                                    @endif
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
function handleImageSelection(input, inputId, previewId) {
    const fileNameInput = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewId);
    const clearBtn = document.getElementById('clear-imagen');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validar tipo de archivo
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('{{ __('Por favor selecciona una imagen válida (JPG, PNG o WEBP)') }}');
            input.value = '';
            return;
        }
        
        // Validar tamaño (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('{{ __('La imagen no debe superar los 2MB') }}');
            input.value = '';
            return;
        }
        
        // Mostrar nombre del archivo
        fileNameInput.value = file.name;
        
        // Mostrar preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = previewContainer.querySelector('img');
            img.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
        
        // Mostrar botón limpiar
        if (clearBtn) clearBtn.style.display = 'inline-block';
    }
}

function clearImageSelection() {
    const fileInput = document.getElementById('imagen');
    const fileNameInput = document.getElementById('file-name-imagen');
    const previewContainer = document.getElementById('preview-imagen');
    const clearBtn = document.getElementById('clear-imagen');
    
    fileInput.value = '';
    fileNameInput.value = '';
    previewContainer.style.display = 'none';
    if (clearBtn) clearBtn.style.display = 'none';
}
</script>
@endsection