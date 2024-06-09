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
                            <h1>403 No permitido</h1>
                            <p>No tienes permiso para acceder a esta página. Pulse <a href="{{ url('/') }}">aquí</a> para volver al inicio</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection