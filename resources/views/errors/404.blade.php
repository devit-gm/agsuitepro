@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo">Página no encontrada</div>

                <div class="card-body">
                    <div class="container mt-3">
                        <div class="row">
                            <p>Lo sentimos pero esta página no está disponible.</p>
                            <p>Pulse <a href="{{ url('/') }}">aquí</a> para volver al inicio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection