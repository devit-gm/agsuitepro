@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> FICHA - Gastos</div>

                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-end">
                        <button class="btn btn-lg btn-light border border-dark">{{number_format($ficha->precio,2)}} <i class="bi bi-currency-euro"></i></button>
                    </div>
                    <div class="container-fluid mt-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-6">
                                <div class="container mt-3">
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

                                        @foreach ($gastosFicha as $componente)
                                        <table class="table table-bordered table-responsive table-hover">

                                            <tbody>
                                                <tr>
                                                    <th colspan="3" class="align-middle fondo-negro">
                                                        {{ $componente->usuario->name }}
                                                    </th>
                                                </tr>
                                                <tr class="">

                                                    <th scope="col-auto">Descripción</th>
                                                    <th scope="col-auto" class="text-center">Precio</th>
                                                    <th scope="col-auto" class="text-center">Ticket</th>
                                                </tr>
                                                <tr class="clickable-row" data-hrefborrar="{{ route('fichas.destroygastos', ['uuid' => $ficha->uuid, 'uuid2' => $componente->uuid]) }}" data-textoborrar="¿Está seguro de eliminar el gasto de la lista?" data-borrable="{{$componente->borrable}}">
                                                    <td class="align-middle">
                                                        {{ $componente->descripcion }}
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        {{ number_format($componente->precio,2) }} <i class="bi bi-currency-euro">
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        @php
                                                        $ruta = URL::to('/') . '/images/' . $componente->ticket;
                                                        @endphp
                                                        <form>
                                                            <a href="{{ $ruta }}" target="_blank" class="btn btn-sm btn-white"><i class="bi bi-file-earmark-arrow-down"></i></a>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('fichas.servicios', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>
                            <a class="btn btn-info mx-1" href={{ route('fichas.addgastos', $ficha->uuid) }}><i class="bi bi-plus-circle"></i></a>
                            <a class="btn btn-success mx-1" href={{ route('fichas.resumen', $ficha->uuid) }}><i class="bi bi-check-circle"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection