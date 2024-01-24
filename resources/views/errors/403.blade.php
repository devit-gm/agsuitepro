@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo">Operación no permitida</div>

                <div class="card-body">
                    <div class="container mt-3">
                        <div class="row">
                            <p>La operación solicitada no está permitida. Si considera que es un error póngase en contacto con el administrador.</p>
                            <p>Pulse <a href="{{ url('/') }}">aquí</a> para volver al inicio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection