@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-people"></i> {{ __('Nuevo usuario') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="nuevo-usuario" action="{{ route('usuarios.store') }}" method="post" enctype="multipart/form-data">
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
                                    <div class="form-group required mb-3">
                                        <label for="name" class="fw-bold form-label">{{ __('Nombre') }}</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="email" class="fw-bold form-label">{{ __('Email') }}</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="password" class="fw-bold form-label">{{ __('Contraseña') }}</label>
                                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="phone_number" class="fw-bold form-label">{{ __('Teléfono') }}</label>
                                        <input type="number" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="locale" class="fw-bold form-label">{{ __('Idioma') }}</label>
                                        <select name="locale" id="locale" class="form-select form-select-lg" aria-label="{{ __('Seleccione su idioma preferido') }}">
                                            <option value="es" selected>{{ __('Español') }}</option>
                                            <option value="en">{{ __('Inglés') }}</option>
                                        </select>
                                        <small class="form-text text-muted">{{ __('Seleccione su idioma preferido') }}</small>
                                    </div>

                                    <div class="form-group required mb-3">
                                        <label for="image" class="fw-bold form-label">{{ __('Imagen') }}</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="file-name-image" readonly placeholder="{{ __('Ningún archivo seleccionado') }}">
                                            <label class="input-group-text" for="image" style="cursor: pointer;">
                                                <i class="bi bi-folder2-open me-1"></i>{{ __('Seleccionar') }}
                                            </label>
                                            <button type="button" class="btn btn-outline-secondary" id="clear-image" style="display: none;" onclick="clearImageSelection()">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                            <input type="file" id="image" name="image" required onchange="handleImageSelection(this, 'file-name-image', 'preview-image')" accept="image/jpeg,image/jpg,image/png,image/webp" style="display: none;">
                                        </div>
                                        <div id="preview-image" class="text-center" style="display: none;">
                                            <img src="" alt="Preview" class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                                        </div>
                                        <small class="text-muted">{{ __('Formatos: JPG, PNG, WEBP. Máximo 2MB') }}</small>
                                    </div>

                                    <div class="form-group mb-3 required">
                                        <label for="role_id" class="fw-bold form-label">{{ __('Rol') }}</label>
                                        <select name="role_id" id="role_id" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                            @endforeach
                                        </select>
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
                            <a class="btn btn-dark mx-1" href={{ route('usuarios.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('nuevo-usuario').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>
				
<script>
function handleImageSelection(input, inputId, previewId) {
    const fileNameInput = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewId);
    const clearBtn = document.getElementById('clear-image');
    
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
    const fileInput = document.getElementById('image');
    const fileNameInput = document.getElementById('file-name-image');
    const previewContainer = document.getElementById('preview-image');
    const clearBtn = document.getElementById('clear-image');
    
    fileInput.value = '';
    fileNameInput.value = '';
    previewContainer.style.display = 'none';
    if (clearBtn) clearBtn.style.display = 'none';
}
</script>
@endsection