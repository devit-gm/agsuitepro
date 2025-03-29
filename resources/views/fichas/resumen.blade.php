@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> Ficha - Resumen</div>

                <div class="card-body">
                    <div class="container-fluid mt-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">
                                <form id="ficha-resumen" action="{{ route('fichas.enviar', $ficha->uuid) }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    <table class="table table-hover table-striped table-bordered">
                                        <tbody>
                                            @if($ficha->tipo != 3)
                                            <tr>
                                                <th scope="row">Total consumos:</th>
                                                <td>{{ number_format($ficha->total_consumos,2)}} <i class="bi bi-currency-euro"></i></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Total servicios:</th>
                                                <td>{{ number_format($ficha->total_servicios,2)}} <i class="bi bi-currency-euro"></i></td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th scope="row">Total gastos:</th>
                                                <td>{{ number_format($ficha->total_gastos,2)}} <i class="bi bi-currency-euro"></i></td>
                                            </tr>
                                            @if($ficha->tipo != 3)
                                            <tr>
                                                <th scope="row" style="vertical-align:middle;">Comensales:<br /><span style="font-size:0.9em; font-weight:normal;">(No incluye niños)</span></th>
                                                <td>{{ $ficha->total_comensales }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Total / comensal:</th>
                                                <td>{{ number_format($ficha->precio_comensal,2)}} <i class="bi bi-currency-euro"></i></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">TOTAL FICHA:</th>
                                                <td><b>{{ number_format($ficha->precio,2)}} <i class="bi bi-currency-euro"></i><b></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </form>


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
                <a class="btn btn-dark mx-1" href={{ route('fichas.gastos', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>
                @if(($ficha->precio>0 || ($ficha->tipo == 3 && $ficha->gastos > 0)) && $ficha->estado == 0)
                <button type="button" onclick="document.getElementById('ficha-resumen').submit();" class="btn btn-success mx-1"><i class="bi bi-send"></i></button>
                @endif
            </div>
        </form>
    </div>
    @endsection