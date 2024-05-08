@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo"><i class="bi bi-cup-straw"></i> Composición producto</div>

                <div class="card-body">
                    <div class="container h-100">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-6">
                                <table class="table table-responsive table-borderless">

                                    <tbody>

                                        <tr>

                                            <td class="align-top">
                                                <img width="80" class="img-fluid rounded img-responsive float-start mx-2" src="{{ URL::to('/') }}/images/{{ $producto->imagen }}" />
                                                {{ $producto->nombre }}
                                                <br />
                                                @if ($producto->familia)
                                                <span class="badge bg-secondary">{{ $producto->familia->nombre }}</span>
                                                @endif


                                            </td>
                                            <td class="align-top">
                                                <i class="bi bi-cash"></i> {{ $producto->precio }}€<br />
                                                @if ($producto->combinado == 1)
                                                <span class="badge bg-success">Combinado</span>
                                                @endif
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>

                                <form action="{{ route('productos.update_components', $producto->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="container mt-3">
                                        <div class="row">
                                            <table class="table table-bordered table-responsive table-hover">
                                                <thead>
                                                    <tr class="">
                                                        <th scope="col-auto">Nombre</th>
                                                        <th scope="col-auto">Precio</th>
                                                        <th scope="col-auto">Incluido</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($componentes as $componente)
                                                    <tr>
                                                        <td class="align-middle">
                                                            {{ $componente->nombre }}
                                                        </td>
                                                        <td class="align-middle">
                                                            {{ $componente->precio }}€
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" name="componentes[]" id="componentes[]" value="{{ $componente->id }}" @if($componente->familia == 1) checked @endif>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="submit" class="btn btn-sm btn-success mx-1"><i class="bi bi-floppy"></i> Guardar</button>
                                        <a class="btn btn-sm btn-dark mx-1" href={{ route('productos.index') }}><i class="bi bi-x-circle"></i> Volver</a>
                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection