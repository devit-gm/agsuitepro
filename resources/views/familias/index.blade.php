@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-tag"></i> {{ __('Families') }}</div>

                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-end">
                        @if (Auth::user()->hasRole('Administrador'))
                        <a class="btn btn-lg btn-success fs-3" href={{ route('familias.create') }}><i class="bi bi-plus-circle"></i> Nueva Familia</a>
                        @endif
                    </div>
                    <div class="container-fluid mt-3">
                        <div class="row">
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
                            <table class="table table-hover table-bordered table-responsive table-hover">
                                <thead>
                                    <tr class="">
                                        <th scope="col-auto" style="width: 90px;">Imagen</th>
                                        <th scope="col-auto">Nombre</th>
                                        <th scope="col-auto">Posición</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($familias as $familia)
                                    <tr class="clickable-row" data-href="{{ route('familias.edit', ['uuid'=>$familia->uuid]) }}" data-hrefborrar="{{ route('familias.destroy', $familia->uuid) }}" data-textoborrar="¿Está seguro de eliminar la familia?" data-borrable="{{$familia->borrable}}">
                                        <td class="align-middle"><img width="80" class="img-fluid rounded img-responsive" src="{{ URL::to('/') }}/images/{{ $familia->imagen }}" /></td>
                                        <td class="align-middle">{{ $familia->nombre }}</td>
                                        <td class="align-middle">
                                            {{ $familia->posicion }}
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