@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo"><i class="bi bi-tag"></i> Artículos de la familia</div>

                <div class="card-body">
                    <div class="container h-100">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-6">
                                <table class="table table-responsive table-borderless">

                                    <tbody>

                                        <tr>

                                            <td class="align-middle">
                                                <img width="80" class="img-fluid rounded img-responsive float-start mx-2" src="{{ URL::to('/') }}/images/{{ $familia->imagen }}" />
                                                <h2 class="color-rojo">{{ $familia->nombre }}</h2>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>


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
                                                @foreach ($productos as $componente)
                                                <tr>
                                                    <td class="align-middle"><img width="50" class="img-fluid rounded img-responsive" src="{{ URL::to('/') }}/images/{{ $componente->imagen }}" /></td>
                                                    <td class="align-middle">
                                                        {{ $componente->nombre }}
                                                    </td>
                                                    <td><a href="{{ route('productos.edit', $componente->id) }}" title="Editar producto" class="btn btn-sm btn-secondary mx-1 my-1"><i class="bi bi-pen"></i></a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="btn btn-sm btn-dark mx-1" href={{ route('familias.index') }}><i class="bi bi-x-circle"></i> Volver</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection