@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-tag"></i> {{ __('Productos de la familia') }} - {{ $familia->nombre }}</div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">

                                <div class="container-fluid p-0 mt-3">
                                    <div class="row">
                                        <table class="table table-bordered table-responsive">
                                            <thead>
                                                <tr class="">
                                                    <th scope="col-auto">Imagen</th>
                                                    <th scope="col-auto">Nombre</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($productos as $componente)
                                                <tr class="clickable-row" data-href="{{ route('productos.edit', $componente->uuid) }}">
                                                    <td class=" align-middle"><img width="50" class="img-fluid rounded img-responsive" src="{{ URL::to('/') }}/images/{{ $componente->imagen }}" /></td>
                                                    <td class="align-middle">
                                                        {{ $componente->nombre }}
                                                    </td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
@section('footer')

                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('familias.edit', $familia->uuid) }}><i class="bi bi-chevron-left"></i></a>
                        </div>
                    </form>
                </div>
@endsection