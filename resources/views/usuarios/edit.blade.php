@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-people"></i>
                    @if (Auth::user()->role_id < 4) Editar usuario @else Mi cuenta @endif </div>

                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 col-md-8 col-lg-10">
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
                                                <label for="name" class="fw-bold form-label">Nombre</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $usuario->name }}" required>
                                            </div>
                                            <div class="form-group mb-3 required">
                                                <img width="100" class="float-end" src="{{ URL::to('/') }}/images/{{ $usuario->image }}" />
                                                <div class="form-group">
                                                    <label for="image" class="fw-bold form-label">Imagen</label>
                                                    <input type="file" class="form-control" id="image" name="image" />
                                                </div>
                                            </div>
                                            <div class="form-group required mb-3">
                                                <label for="email" class="fw-bold form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
                                            </div>
                                            <div class="form-group mb-3 required">
                                                <label for="phone_number" class="fw-bold form-label">Teléfono</label>
                                                <input type="number" class="form-control" id="phone_number" name="phone_number" value="{{ $usuario->phone_number }}" required>
                                            </div>

                                            @if (Auth::user()->role_id < 3 && $usuario->role_id != 1) <div class="form-group mb-3 required">
                                                    <label for="role_id" class="fw-bold form-label">Rol</label>
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
                                                    <label for="password" class="fw-bold form-label">Contraseña</label>
                                                    <input type="password" class="form-control" id="password" name="password" value="{{ $usuario->password }}" required>
                                                </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="post">
                                <div class="d-flex align-items-center justify-content-center">
                                    @if(Auth::user()->role_id < 3 ) <a class="btn btn-dark mx-1" href={{ route('usuarios.index') }}><i class="bi bi-chevron-left"></i></a>
                                        @endif
                                        @if (($usuario->role_id == 1 && Auth::id()== $usuario->id) || $usuario->role_id > 1)
                                        <button onclick="document.getElementById('editar-usuario').submit();" type="button" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                                        @endif
                                        @if ($usuario->borrable == 1 && Auth::user()->role_id < 3) @csrf @method('DELETE') <button type="submit" class="btn btn-danger mx-1 my-1" title="Eliminar usuario" onclick="return confirm('¿Está seguro de eliminar el usuario?');"><i class="bi bi-trash"></i></button>
                                            @endif
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @endsection