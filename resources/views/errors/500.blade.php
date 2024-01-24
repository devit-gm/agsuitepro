@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo">Error interno</div>

                <div class="card-body">
                    <div class="container mt-3">
                        <div class="row">
                            <p>Se ha producido un error en la solicitud.</p>
                            <p>Pulse <a href="{{ url('/') }}">aquí</a> para volver al inicio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection