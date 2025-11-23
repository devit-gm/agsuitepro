@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
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
                                                <img width="100" class="float-end" src="{{ URL::to('/') }}/images/{{ $usuario->image }}" />
                                                <div class="form-group">
                                                    <label for="image" class="fw-bold form-label">{{ __('Imagen') }}</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="file-name-image" readonly placeholder="{{ __('Ningún archivo seleccionado') }}">
                                                        <label class="input-group-text" for="image" style="cursor: pointer;">{{ __('Seleccionar archivo') }}</label>
                                                        <input type="file" id="image" name="image" onchange="updateFileName(this, 'file-name-image')" style="display: none;" />
                                                    </div>
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

                                                @if(request()->secure() && Auth::id() == $usuario->id)
                                                <!-- Sección de Notificaciones Push (solo en HTTPS y solo para el usuario activo) -->
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
function updateFileName(input, inputId) {
    const fileName = input.files[0] ? input.files[0].name : '';
    document.getElementById(inputId).value = fileName;
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