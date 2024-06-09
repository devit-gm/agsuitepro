@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> FICHA - CONSUMO</div>

                <div class="card-body">

                    <div class="d-grid gap-2 d-md-flex justify-content-end">
                        <button class="btn btn-lg btn-light border border-dark">{{number_format($ficha->precio,2)}} <i class="bi bi-currency-euro"></i></button>
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
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <tr class="">
                                        <th scope="col-auto" style="width:90px">Producto</th>
                                        <th scope="col-auto" class="text-center">Unidades</th>
                                        <th scope="col-auto" class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productosFicha as $componente)
                                    <tr class="clickable-row" data-hrefsumarcantidad="{{ route('fichas.updatelista', ['uuid' => $ficha->uuid, 'uuid2' => $componente->id_producto, 'cantidad' => 1]) }}" data-hrefrestarcantidad="{{ route('fichas.updatelista', ['uuid' => $ficha->uuid, 'uuid2' => $componente->id_producto, 'cantidad' => -1]) }}" data-hrefborrar="{{ route('fichas.destroylista', ['uuid' => $ficha->uuid, 'uuid2' => $componente->id_producto]) }}" data-textoborrar="¿Está seguro de eliminar el artículo de la lista?" data-borrable="{{$componente->borrable}}">
                                        <td class="align-middle text-center">
                                            @php
                                            $ruta = URL::to('/') . '/images/' . $componente->producto->imagen;
                                            @endphp
                                            <div class="fondo-calendario" style="background-image: url('{{ $ruta }}');">
                                                <p style="padding-top:22px">
                                                </p>
                                            </div>
                                            {{ $componente->producto->nombre }}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $componente->cantidad }}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ number_format($componente->precio,2) }} <i class="bi bi-currency-euro">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-warning mx-1" href="{{ route('fichas.show', ['uuid'=>$ficha->uuid]) }}"><i class="bi bi-eye"></i></a>
                            <a class="btn btn-info mx-1" href="{{ route('fichas.familias', ['uuid'=>$ficha->uuid]) }}"><i class="bi bi-cup-straw"></i></a>
                            <a class="btn btn-dark mx-1" href="{{ route('fichas.usuarios', ['uuid'=>$ficha->uuid]) }}"><i class="bi bi-chevron-right"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection