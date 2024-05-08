@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo"><i class="bi bi-people"></i> Editar usuario</div>

                <div class="card-body">
                    <div class="container h-100">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-6">
                                <form action="{{ route('usuarios.update', $usuario->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
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
                                    <div class="form-group required mb-3">
                                        <label for="phone_number" class="fw-bold form-label">Teléfono</label>
                                        <input type="number" class="form-control" id="phone_number" name="phone_number" value="{{ $usuario->phone_number }}" required>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="role_id" class="fw-bold form-label">Rol</label>
                                        <select name="role_id" id="role_id" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}" @if( $usuario->role_id == $rol->id ) selected @endif>{{ $rol->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="submit" class="btn btn-sm btn-success mx-1"><i class="bi bi-floppy"></i> Guardar</button>
                                        <a class="btn btn-sm btn-dark mx-1" href={{ route('usuarios.index') }}><i class="bi bi-x-circle"></i> Cancelar</a>
                                    </div>
                                </form>
                                @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                <div>{{$error}}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection