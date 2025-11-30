@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-people"></i>
                    @if (Auth::user()->role_id < 4) {{ __('Editar usuario') }} @else {{ __('Mi cuenta') }} @endif </div>

                        <div class="card-body overflow-auto flex-fill">
                            <div class="container-fluid">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <form id="editar-usuario" action="{{ route('usuarios.update', $usuario->id) }}" method="post" enctype="multipart/form-data">
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
                                            <div class="form-group required mb-3">
                                                <label for="name" class="fw-bold form-label">{{ __('Nombre') }}</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $usuario->name }}" required>
                                            </div>
                                            <div class="form-group mb-3 required">
                                                <label for="image" class="fw-bold form-label">{{ __('Imagen') }}</label>
                                                <div class="text-center mb-2">
                                                    <strong class="d-block mb-2">{{ __('Imagen actual') }}</strong>
                                                    <img width="100" class="img-thumbnail" loading="lazy" src="{{ URL::to('/') }}/images/{{ $usuario->image }}" alt="{{ $usuario->name }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="fw-bold form-label">{{ __('Cambiar imagen') }}</label>
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control" id="file-name-image" readonly placeholder="{{ __('Ningún archivo seleccionado') }}">
                                                        <label class="input-group-text" for="image" style="cursor: pointer;">
                                                            <i class="bi bi-folder2-open me-1"></i>{{ __('Seleccionar') }}
                                                        </label>
                                                        <button type="button" class="btn btn-outline-secondary" id="clear-image" style="display: none;" onclick="clearImageSelection()">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                        <input type="file" id="image" name="image" onchange="handleImageSelection(this, 'file-name-image', 'preview-image')" accept="image/jpeg,image/jpg,image/png,image/webp" style="display: none;" />
                                                    </div>
                                                    <div id="preview-image" class="text-center" style="display: none;">
                                                        <img src="" alt="Preview" class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                                                    </div>
                                                    <small class="text-muted">{{ __('Formatos: JPG, PNG, WEBP. Máximo 2MB') }}</small>
                                                </div>
                                            </div>
                                            <div class="form-group required mb-3">
                                                <label for="email" class="fw-bold form-label">{{ __('Email') }}</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
                                            </div>
                                            <div class="form-group mb-3 required">
                                                <label for="phone_number" class="fw-bold form-label">{{ __('Teléfono') }}</label>
                                                <input type="number" class="form-control" id="phone_number" name="phone_number" value="{{ $usuario->phone_number }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="locale" class="fw-bold form-label">{{ __('Idioma') }}</label>
                                                <select name="locale" id="locale" class="form-select form-select-lg" aria-label="{{ __('Seleccione su idioma preferido') }}">
                                                    <option value="es" @if($usuario->locale == 'es' || !$usuario->locale) selected @endif>{{ __('Español') }}</option>
                                                    <option value="en" @if($usuario->locale == 'en') selected @endif>{{ __('Inglés') }}</option>
                                                </select>
                                                <small class="form-text text-muted">{{ __('Seleccione su idioma preferido') }}</small>
                                            </div>

                                            @if (Auth::user()->role_id < 3 && $usuario->role_id != 1) <div class="form-group mb-3 required">
                                                    <label for="role_id" class="fw-bold form-label">{{ __('Rol') }}</label>
                                                    <select name="role_id" id="role_id" class="form-select form-select-lg" aria-label=".form-select-sm example" required>
                                                        @foreach ($roles as $rol)
                                                        <option value="{{ $rol->id }}" @if( $usuario->role_id == $rol->id ) selected @endif>{{ $rol->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @else
                                                <input type="hidden" name="role_id" value="{{ $usuario->role_id }}" />
                                                @endif
                                                <div class="form-group">
                                                    <label for="password" class="fw-bold form-label">{{ __('Contraseña') }}</label>
                                                    <input type="password" class="form-control" id="password" name="password" value="{{ $usuario->password }}" required>
                                                </div>

                                                <!-- Sección de Notificaciones Push (si no corresponde, se oculta con CSS) -->
                                                @php
                                                    $mostrarNotificaciones = (request()->secure() || str_contains(request()->getHost(), '127.0.0.1')) && Auth::id() == $usuario->id;
                                                @endphp
                                                <div class="notificaciones-push-wrapper" style="@if(!$mostrarNotificaciones) display:none; @endif">
                                                    <hr class="my-4">
                                                    <div class="form-group mb-3">
                                                        <label class="fw-bold form-label"><i class="bi bi-bell"></i> {{ __('Notificaciones Push') }}</label>
                                                        <div class="alert alert-info d-flex align-items-center" id="notification-status">
                                                            <i class="bi bi-bell me-2"></i>
                                                            <span id="notification-text">{{ __('Verificando estado...') }}</span>
                                                        </div>
                                                        <button type="button" id="enable-notifications-btn" class="btn btn-primary" onclick="requestNotificationPermission()" style="display: none;">
                                                            <i class="bi bi-bell-fill"></i> {{ __('Activar Notificaciones') }}
                                                        </button>
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
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="post">
                                <div class="d-flex align-items-center justify-content-center">
                                    @if(Auth::user()->role_id < 3 ) <a class="btn btn-dark mx-1" href={{ route('usuarios.index') }}><i class="bi bi-chevron-left"></i></a>
                                        @endif
                                        @if (($usuario->role_id == 1 && Auth::id()== $usuario->id) || $usuario->role_id > 1)
                                        <button onclick="document.getElementById('editar-usuario').submit();" type="button" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                                        @endif
                                        @if ($usuario->borrable == 1 && Auth::user()->role_id < 3 && Auth::id() != $usuario->id) @csrf @method('DELETE') <button type="submit" class="btn btn-danger mx-1 my-1" title="{{ __('Eliminar usuario') }}" onclick="return confirm('{{ __('¿Está seguro de eliminar el usuario?') }}');"><i class="bi bi-trash"></i></button>
                                            @endif
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

@push('scripts')
<script>
    // Verificar estado de notificaciones al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        checkNotificationStatus();
    });

    function checkNotificationStatus() {
        const statusDiv = document.getElementById('notification-status');
        const textSpan = document.getElementById('notification-text');
        const enableBtn = document.getElementById('enable-notifications-btn');

        if (!('Notification' in window)) {
            statusDiv.className = 'alert alert-warning d-flex align-items-center';
            textSpan.textContent = '{{ __("Este dispositivo no soporta notificaciones") }}';
            return;
        }

        const permission = Notification.permission;
        
        if (permission === 'granted') {
            statusDiv.className = 'alert alert-success d-flex align-items-center';
            textSpan.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>{{ __("Notificaciones activadas correctamente") }}';
            enableBtn.style.display = 'none';
        } else if (permission === 'denied') {
            statusDiv.className = 'alert alert-danger d-flex align-items-center';
            textSpan.innerHTML = '<i class="bi bi-x-circle-fill me-2"></i>{{ __("Notificaciones bloqueadas. Ve a los ajustes de tu dispositivo para habilitarlas") }}';
            enableBtn.style.display = 'none';
        } else {
            statusDiv.className = 'alert alert-warning d-flex align-items-center';
            textSpan.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>{{ __("Notificaciones desactivadas. Pulsa el botón para activarlas") }}';
            enableBtn.style.display = 'block';
        }
    }

    // Actualizar estado después de solicitar permisos
    window.addEventListener('focus', checkNotificationStatus);
</script>
@endpush

@endsection