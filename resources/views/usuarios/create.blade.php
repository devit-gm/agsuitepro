@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-people"></i> Nuevo usuario</div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">
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
                                        <label for="name" class="fw-bold form-label">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="email" class="fw-bold form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="password" class="fw-bold form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="phone_number" class="fw-bold form-label">Teléfono</label>
                                        <input type="number" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="image" class="fw-bold form-label">Imagen</label>
                                        <input type="file" class="form-control" id="image" name="image" required></input>
                                    </div>

                                    <div class="form-group mb-3 required">
                                        <label for="role_id" class="fw-bold form-label">Rol</label>
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

                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('usuarios.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('nuevo-usuario').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection