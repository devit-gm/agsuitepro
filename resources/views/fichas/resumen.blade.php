@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> Ficha - Resumen</div>

                <div class="card-body">
                    <div class="container-fluid mt-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-6">
                                <form id="ficha-resumen" action="{{ route('fichas.enviar', $ficha->uuid) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-3">
                                        <label class="fw-bold form-label">CONSUMOS: </label> {{ number_format($ficha->total_consumos,2)}} €
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="fw-bold form-label">SERVICIOS: </label> {{ number_format($ficha->total_servicios,2)}} €
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="fw-bold form-label">GASTOS: </label> {{ number_format($ficha->total_gastos,2)}} €
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="fw-bold form-label">PRECIO: </label> {{ number_format($ficha->precio,2)}} €
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="fw-bold form-label">COMENSALES: </label> {{ $ficha->total_comensales }}
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="fw-bold form-label">PRECIO / COMENSAL: </label> {{ number_format($ficha->precio_comensal,2)}} €
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('fichas.gastos', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('ficha-resumen').submit();" class="btn btn-success mx-1"><i class="bi bi-send"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endsection