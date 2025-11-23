@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-building"></i> {{ __('Editar sociedad') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="editar-sitio" action="{{ route('sitios.update', $sitio->id) }}" method="post" enctype="multipart/form-data">
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
                                    @if (session('success'))
                                    <div class="custom-success-container" id="custom-success-container">
                                        <ul class="custom-success-list">
                                            <li class="custom-success-item">{{ session('success') }}</li>
                                        </ul>
                                    </div>
                                    @endif
                                    <!-- Información básica -->
                                    <h5 class="mb-3 text-primary">{{ __('Información básica') }}</h5>
                                    <div class="form-group required mb-3">
                                        <label for="nombre" class="fw-bold form-label">{{ __('Nombre') }}</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $sitio->nombre }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="cif" class="fw-bold form-label">{{ __('CIF/NIF') }}</label>
                                        <input type="text" class="form-control" id="cif" name="cif" value="{{ $sitio->cif ?? '' }}" placeholder="B12345678">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="direccion" class="fw-bold form-label">{{ __('Dirección') }}</label>
                                        <textarea class="form-control" id="direccion" name="direccion" rows="2" placeholder="Calle, número, ciudad, código postal">{{ $sitio->direccion ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="telefono" class="fw-bold form-label">{{ __('Teléfono') }}</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $sitio->telefono ?? '' }}" placeholder="+34 123 456 789">
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="dominio" class="fw-bold form-label">{{ __('Dominio') }}</label>
                                        <input type="text" class="form-control" id="dominio" name="dominio" value="{{ $sitio->dominio }}" placeholder="ejemplo.com" required>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="central" name="central" value="1" {{ $sitio->central ? 'checked' : '' }}>
                                        <label class="form-check-label" for="central">{{ __('¿Es sitio central?') }}</label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="locale" class="fw-bold form-label">{{ __('Idioma') }}</label>
                                        <select name="locale" id="locale" class="form-select form-select-lg" aria-label="{{ __('Seleccione su idioma preferido') }}">
                                            <option value="es" @if($sitio->locale == 'es' || !$sitio->locale) selected @endif>{{ __('Español') }}</option>
                                            <option value="en" @if($sitio->locale == 'en') selected @endif>{{ __('Inglés') }}</option>
                                        </select>
                                        <small class="form-text text-muted">{{ __('Idioma predeterminado para el sitio') }}</small>
                                    </div>

                                    <!-- Imágenes y estilos -->
                                    <h5 class="mb-3 mt-4 text-primary">{{ __('Imágenes y estilos') }}</h5>
                                    <div class="form-group mb-3 required">
                                        @if($sitio->ruta_logo)
                                        <img width="100" class="float-end mb-2" src="{{ URL::to('/') }}/{{ $sitio->ruta_logo }}" />
                                        @endif
                                        <div class="form-group">
                                            <label for="logo" class="fw-bold form-label">{{ __('Logo') }}</label>
                                            <input type="text" class="form-control" id="logo" name="logo" value="{{ basename($sitio->ruta_logo) }}" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        @if($sitio->ruta_logo_nav)
                                        <img width="100" class="float-end mb-2" src="{{ URL::to('/') }}/{{ $sitio->ruta_logo_nav }}" />
                                        @endif
                                        <label for="logo_nav" class="fw-bold form-label">{{ __('Logo navegación') }}</label>
                                        <input type="text" class="form-control" id="logo_nav" name="logo_nav" value="{{ basename($sitio->ruta_logo_nav) }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        @if($sitio->favicon)
                                        <img width="32" class="float-end mb-2" src="{{ URL::to('/') }}{{ $sitio->favicon }}-32x32.png" />
                                        @endif
                                        <label for="favicon" class="fw-bold form-label">Favicon</label>
                                        <input type="text" class="form-control" id="favicon" name="favicon" value="{{ basename($sitio->favicon) }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="estilos" class="fw-bold form-label">{{ __('Archivo de estilos CSS') }}</label>
                                        <input type="text" class="form-control" id="estilos" name="estilos" value="{{ basename($sitio->ruta_estilos) }}">
                                    </div>

                                    <!-- Configuración de base de datos -->
                                    <h5 class="mb-3 mt-4 text-primary">{{ __('Configuración de base de datos') }}</h5>
                                    <div class="form-group required mb-3">
                                        <label for="db_host" class="fw-bold form-label">{{ __('Host de base de datos') }}</label>
                                        <input type="text" class="form-control" id="db_host" name="db_host" value="{{ $sitio->db_host }}" placeholder="localhost" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="db_name" class="fw-bold form-label">{{ __('Nombre de base de datos') }}</label>
                                        <input type="text" class="form-control" id="db_name" name="db_name" value="{{ $sitio->db_name }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="db_user" class="fw-bold form-label">{{ __('Usuario de base de datos') }}</label>
                                        <input type="text" class="form-control" id="db_user" name="db_user" value="{{ $sitio->db_user }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="db_password" class="fw-bold form-label">{{ __('Contraseña de base de datos') }}</label>
                                        <input type="password" class="form-control" id="db_password" name="db_password" value="{{ $sitio->db_password }}" required>
                                    </div>

                                    <!-- Configuración de correo -->
                                    <h5 class="mb-3 mt-4 text-primary">{{ __('Configuración de correo') }}</h5>
                                    <div class="form-group mb-3">
                                        <label for="mail_mailer" class="fw-bold form-label">{{ __('Mailer') }}</label>
                                        <select class="form-control" id="mail_mailer" name="mail_mailer">
                                            <option value="">{{ __('Seleccionar...') }}</option>
                                            <option value="smtp" {{ $sitio->mail_mailer == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                            <option value="sendmail" {{ $sitio->mail_mailer == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                            <option value="mailgun" {{ $sitio->mail_mailer == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                            <option value="ses" {{ $sitio->mail_mailer == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                                            <option value="postmark" {{ $sitio->mail_mailer == 'postmark' ? 'selected' : '' }}>Postmark</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_host" class="fw-bold form-label">{{ __('Host de correo') }}</label>
                                        <input type="text" class="form-control" id="mail_host" name="mail_host" value="{{ $sitio->mail_host }}" placeholder="smtp.gmail.com">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_port" class="fw-bold form-label">{{ __('Puerto de correo') }}</label>
                                        <input type="number" class="form-control" id="mail_port" name="mail_port" value="{{ $sitio->mail_port }}" placeholder="587">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_username" class="fw-bold form-label">{{ __('Usuario de correo') }}</label>
                                        <input type="text" class="form-control" id="mail_username" name="mail_username" value="{{ $sitio->mail_username }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_password" class="fw-bold form-label">{{ __('Contraseña de correo') }}</label>
                                        <input type="password" class="form-control" id="mail_password" name="mail_password" value="{{ $sitio->mail_password }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_encryption" class="fw-bold form-label">{{ __('Encriptación') }}</label>
                                        <select class="form-control" id="mail_encryption" name="mail_encryption">
                                            <option value="">{{ __('Ninguna') }}</option>
                                            <option value="tls" {{ $sitio->mail_encryption == 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ $sitio->mail_encryption == 'ssl' ? 'selected' : '' }}>SSL</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_from_address" class="fw-bold form-label">{{ __('Dirección de envío') }}</label>
                                        <input type="email" class="form-control" id="mail_from_address" name="mail_from_address" value="{{ $sitio->mail_from_address }}" placeholder="noreply@ejemplo.com">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_from_name" class="fw-bold form-label">{{ __('Nombre de envío') }}</label>
                                        <input type="text" class="form-control" id="mail_from_name" name="mail_from_name" value="{{ $sitio->mail_from_name }}" placeholder="Mi Sitio">
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
    <form action="{{ route('sitios.destroy', $sitio->id) }}" method="post">
        <div class="d-flex align-items-center justify-content-center">
            <a class="btn btn-dark mx-1" href="{{ route('sitios.index') }}"><i class="bi bi-chevron-left"></i></a>
            <button onclick="document.getElementById('editar-sitio').submit();" type="button" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
            @csrf
            @method('DELETE')
            @if ($sitio->borrable == 1)
            <button type="submit" class="btn btn-danger mx-1 my-1" title="Eliminar sociedad" onclick="return confirm('{{ __('¿Está seguro de eliminar la sociedad?') }}');"><i class="bi bi-trash"></i></button>
            @endif
        </div>
    </form>
</div>
@endsection
