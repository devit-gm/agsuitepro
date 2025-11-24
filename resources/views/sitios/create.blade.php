@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-building"></i> {{ __('Nueva sociedad') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="nuevo-sitio" action="{{ route('sitios.create') }}" method="post" enctype="multipart/form-data">
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
                                    <!-- Información básica -->
                                    <h5 class="mb-3 text-primary">{{ __('Información básica') }}</h5>
                                    <div class="form-group required mb-3">
                                        <label for="nombre" class="fw-bold form-label">{{ __('Nombre') }}</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="cif" class="fw-bold form-label">{{ __('CIF/NIF') }}</label>
                                        <input type="text" class="form-control" id="cif" name="cif" placeholder="B12345678">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="direccion" class="fw-bold form-label">{{ __('Dirección') }}</label>
                                        <textarea class="form-control" id="direccion" name="direccion" rows="2" placeholder="Calle, número, ciudad, código postal"></textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="telefono" class="fw-bold form-label">{{ __('Teléfono') }}</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="+34 123 456 789">
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="dominio" class="fw-bold form-label">{{ __('Dominio') }}</label>
                                        <input type="text" class="form-control" id="dominio" name="dominio" placeholder="ejemplo.com" required>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="central" name="central" value="1">
                                        <label class="form-check-label" for="central">{{ __('¿Es sitio central?') }}</label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="locale" class="fw-bold form-label">{{ __('Idioma') }}</label>
                                        <select name="locale" id="locale" class="form-select form-select-lg" aria-label="{{ __('Seleccione su idioma preferido') }}">
                                            <option value="es" selected>{{ __('Español') }}</option>
                                            <option value="en">{{ __('Inglés') }}</option>
                                        </select>
                                        <small class="form-text text-muted">{{ __('Idioma predeterminado para el sitio') }}</small>
                                    </div>

                                    <!-- Imágenes -->
                                    <h5 class="mb-3 mt-4 text-primary">{{ __('Imágenes y estilos') }}</h5>
                                    <div class="form-group required mb-3">
                                        <label for="logo" class="fw-bold form-label">{{ __('Logo') }}</label>
                                        <input type="text" class="form-control" id="logo" name="logo" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="logo_nav" class="fw-bold form-label">{{ __('Logo navegación') }}</label>
                                        <input type="text" class="form-control" id="logo_nav" name="logo_nav" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="favicon" class="fw-bold form-label">Favicon</label>
                                        <input type="text" class="form-control" id="favicon" name="favicon" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="estilos" class="fw-bold form-label">{{ __('Archivo de estilos CSS') }}</label>
                                        <input type="text" class="form-control" id="estilos" name="estilos" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="carpeta_pwa" class="fw-bold form-label">{{ __('Carpeta PWA (iconos)') }}</label>
                                        <input type="text" class="form-control" id="carpeta_pwa" name="carpeta_pwa" placeholder="eldespiste">
                                        <small class="form-text text-muted">{{ __('Nombre de la carpeta en /public/ donde están los iconos de PWA (icon-192x192.png, icon-512x512.png). Dejar vacío para usar la raíz.') }}</small>
                                    </div>

                                    <!-- Configuración de base de datos -->
                                    <h5 class="mb-3 mt-4 text-primary">{{ __('Configuración de base de datos') }}</h5>
                                    <div class="form-group required mb-3">
                                        <label for="db_host" class="fw-bold form-label">{{ __('Host de base de datos') }}</label>
                                        <input type="text" class="form-control" id="db_host" name="db_host" placeholder="localhost" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="db_name" class="fw-bold form-label">{{ __('Nombre de base de datos') }}</label>
                                        <input type="text" class="form-control" id="db_name" name="db_name" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="db_user" class="fw-bold form-label">{{ __('Usuario de base de datos') }}</label>
                                        <input type="text" class="form-control" id="db_user" name="db_user" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="db_password" class="fw-bold form-label">{{ __('Contraseña de base de datos') }}</label>
                                        <input type="password" class="form-control" id="db_password" name="db_password" required>
                                    </div>

                                    <!-- Configuración de correo -->
                                    <h5 class="mb-3 mt-4 text-primary">{{ __('Configuración de correo') }}</h5>
                                    <div class="form-group mb-3">
                                        <label for="mail_mailer" class="fw-bold form-label">{{ __('Mailer') }}</label>
                                        <select class="form-control" id="mail_mailer" name="mail_mailer">
                                            <option value="">{{ __('Seleccionar...') }}</option>
                                            <option value="smtp">SMTP</option>
                                            <option value="sendmail">Sendmail</option>
                                            <option value="mailgun">Mailgun</option>
                                            <option value="ses">Amazon SES</option>
                                            <option value="postmark">Postmark</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_host" class="fw-bold form-label">{{ __('Host de correo') }}</label>
                                        <input type="text" class="form-control" id="mail_host" name="mail_host" placeholder="smtp.gmail.com">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_port" class="fw-bold form-label">{{ __('Puerto de correo') }}</label>
                                        <input type="number" class="form-control" id="mail_port" name="mail_port" placeholder="587">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_username" class="fw-bold form-label">{{ __('Usuario de correo') }}</label>
                                        <input type="text" class="form-control" id="mail_username" name="mail_username">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_password" class="fw-bold form-label">{{ __('Contraseña de correo') }}</label>
                                        <input type="password" class="form-control" id="mail_password" name="mail_password">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_encryption" class="fw-bold form-label">{{ __('Encriptación') }}</label>
                                        <select class="form-control" id="mail_encryption" name="mail_encryption">
                                            <option value="">{{ __('Ninguna') }}</option>
                                            <option value="tls">TLS</option>
                                            <option value="ssl">SSL</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_from_address" class="fw-bold form-label">{{ __('Dirección de envío') }}</label>
                                        <input type="email" class="form-control" id="mail_from_address" name="mail_from_address" placeholder="noreply@ejemplo.com">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="mail_from_name" class="fw-bold form-label">{{ __('Nombre de envío') }}</label>
                                        <input type="text" class="form-control" id="mail_from_name" name="mail_from_name" placeholder="Mi Sitio">
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
            <a class="btn btn-dark mx-1" href="{{ route('sitios.index') }}"><i class="bi bi-chevron-left"></i></a>
            <button type="button" onclick="document.getElementById('nuevo-sitio').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</div>
@endsection
