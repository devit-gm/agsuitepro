@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo"><i class="bi bi-people"></i> {{ __('Users') }}</div>
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if (Auth::user()->hasRole('Administrador'))
                        <a class="btn btn-sm btn-success" href={{ route('usuarios.create') }}><i class="bi bi-plus-circle"></i> Nuevo Usuario</a>
                        @endif
                    </div>
                    <div class="container mt-3">
                        <div class="row">
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <tr class="">
                                        <th scope="col-auto">Imagen</th>
                                        <th scope="col-auto">Nombre</th>
                                        <th scope="col-auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td class="align-middle"><img width="100" class="img-fluid rounded img-responsive" src="{{ URL::to('/') }}/images/{{ $usuario->image }}" /></td>
                                        <td class="align-middle">
                                            {{ $usuario->name }}
                                            <br />
                                            <span class="badge bg-secondary">
                                                @foreach($roles as $rol)
                                                @if ($usuario->role_id == $rol->id)
                                                {{ $rol->name }}
                                                @endif
                                                @endforeach
                                            </span>
                                            <br />
                                            <span class="badge btn bt-sm btn-info color-negro">{{ $usuario->email }}</span>
                                        </td>

                                        <td class="align-middle text-center">
                                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="align-items-center justify-content-center">
                                                    @if (Auth::user()->hasRole('Administrador'))
                                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" title="Editar usuario" class="btn btn-sm btn-secondary mx-1 my-1"><i class="bi bi-pen"></i></a>
                                                    @if ($usuario->id != Auth::user()->id && $usuario->role_id != 1)
                                                    <button type="submit" class="btn btn-sm btn-danger mx-1 my-1" title="Eliminar usuario" onclick="return confirm('¿Está seguro de eliminar el usuario?');"><i class="bi bi-trash"></i></button>
                                                    @endif
                                                    @endif
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

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
@endsection