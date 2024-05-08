@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo"><i class="bi bi-cup-straw"></i> {{ __('Products') }}</div>

                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if (Auth::user()->hasRole('Administrador'))
                        <a class="btn btn-sm btn-success" href={{ route('productos.create') }}><i class="bi bi-plus-circle"></i> Nuevo Producto</a>
                        @endif
                    </div>
                    <div class="container mt-3">
                        <div class="row">
                            <table class="table table-bordered table-responsive table-hover">
                                <thead>
                                    <tr class="">
                                        <th scope="col-auto">Imagen</th>
                                        <th scope="col-auto">Nombre</th>
                                        <th scope="col-auto">Precio</th>
                                        <th scope="col-auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                    <tr>
                                        <td class="align-middle"><img width="100" class="img-fluid rounded img-responsive" src="{{ URL::to('/') }}/images/{{ $producto->imagen }}" /></td>
                                        <td class="align-middle">
                                            {{ $producto->nombre }}
                                            <br />
                                            @if ($producto->familia)
                                            <span class="badge bg-secondary">{{ $producto->familia->nombre }}</span>
                                            @endif
                                            <br />
                                            @if ($producto->combinado == 1)
                                            <span class="badge btn bt-sm btn-info color-negro">Combinado</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            {{ $producto->precio }}€
                                        </td>
                                        <td class="align-middle text-center">
                                            <form action="{{ route('productos.destroy', $producto->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="align-items-center justify-content-center">
                                                    @if (Auth::user()->hasRole('Administrador'))
                                                    <a href="{{ route('productos.edit', $producto->id) }}" title="Editar producto" class="btn btn-sm btn-secondary mx-1 my-1"><i class="bi bi-pen"></i></a>
                                                    <button type="submit" class="btn btn-sm btn-danger mx-1 my-1" title="Eliminar producto" onclick="return confirm('¿Está seguro de eliminar el producto?');"><i class="bi bi-trash"></i></button>
                                                    <a href="{{ route('productos.components', $producto->id) }}" title="Ver composición producto" class="btn btn-sm btn-info mx-1 my-1" @if ($producto->combinado == 0) hidden @endif><i class="bi bi-list-ul"></i></a>
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
    @endsection