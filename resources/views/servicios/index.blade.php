@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo"><i class="bi bi-tools"></i> {{ __('Services') }}</div>

                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if (Auth::user()->hasRole('Administrador'))
                        <a class="btn btn-sm btn-success" href={{ route('servicios.create') }}><i class="bi bi-plus-circle"></i> Nuevo Servicio</a>
                        @endif
                    </div>
                    <div class="container mt-3">
                        <div class="row">
                            <table class="table table-bordered table-responsive table-hover">
                                <thead>
                                    <tr class="">
                                        <th scope="col-auto">Nombre</th>
                                        <th scope="col-auto">Precio</th>
                                        <th scope="col-auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($servicios as $servicio)
                                    <tr>
                                        <td class="align-middle">
                                            {{ $servicio->nombre }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $servicio->precio }}€
                                        </td>
                                        <td class="align-middle text-center">
                                            <form action="{{ route('servicios.destroy', $servicio->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="align-items-center justify-content-center">
                                                    @if (Auth::user()->hasRole('Administrador'))
                                                    <a href="{{ route('servicios.edit', $servicio->id) }}" title="Editar servicio" class="btn btn-sm btn-secondary mx-1 my-1"><i class="bi bi-pen"></i></a>
                                                    <button type="submit" class="btn btn-sm btn-danger mx-1 my-1" title="Eliminar servicio" onclick="return confirm('¿Está seguro de eliminar el servicio?');"><i class="bi bi-trash"></i></button>
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