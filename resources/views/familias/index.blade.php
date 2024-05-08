@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo"><i class="bi bi-tag"></i> {{ __('Families') }}</div>

                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if (Auth::user()->hasRole('Administrador'))
                        <a class="btn btn-sm btn-success" href={{ route('familias.create') }}><i class="bi bi-plus-circle"></i> Nueva Familia</a>
                        @endif
                    </div>
                    <div class="container mt-3">
                        <div class="row">
                            <table class="table table-bordered table-responsive table-hover">
                                <thead>
                                    <tr class="">
                                        <th scope="col-auto">Imagen</th>
                                        <th scope="col-auto">Nombre</th>
                                        <th scope="col-auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($familias as $familia)
                                    <tr>
                                        <td class="align-middle"><img width="100" class="img-fluid rounded img-responsive" src="{{ URL::to('/') }}/images/{{ $familia->imagen }}" /></td>
                                        <td class="align-middle">{{ $familia->nombre }}</td>
                                        <td class="align-middle text-center">
                                            @if (Auth::user()->hasRole('Administrador'))
                                            <form action="{{ route('familias.destroy', $familia->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <a href="{{ route('familias.edit', $familia->id) }}" class="btn btn-sm btn-secondary mx-1"><i class="bi bi-pen"></i></a>
                                                    <button type="submit" class="btn btn-sm btn-danger mx-1" onclick="return confirm('¿Está seguro de eliminar la familia?');"><i class="bi bi-trash"></i></button>
                                                    <a href="{{ route('familias.view', $familia->id) }}" title="Ver artículos de la familia" class="btn btn-sm btn-info mx-1 my-1"><i class="bi bi-list-ul"></i></a>
                                                </div>
                                            </form>
                                            @endif
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