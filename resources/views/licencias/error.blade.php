@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fondo-rojo"><i class="bi bi-key"></i> ERROR DE LICENCIA</div>

                <div class="card-body">

                    @if ($errors->any())
                    <div class="custom-error-container" id="custom-error-container">
                        <ul class="custom-error-list">
                            @foreach ($errors->all() as $error)
                            <li class="custom-error-item">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('licencias.error') }}">
                        @csrf
                        @method('PUT')
                        <div class="py-3 align-items-center justify-content-center">
                            <h3 class="text-center"><b>No tienes licencia o ha caducado.</b></h3>
                            <p class="text-center">Por favor, si tiene un código de licencia, intente activarla.</p>
                            <p class="text-center">Si el error persiste póngase en contacto con su administrador.</p>
                        </div>
                        <div class="row mb-3 col-sm-12">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Licencia:</label>

                            <div class="col-md-6">
                                <input id="licencia" type="text" class="form-control" name="licencia" value="{{ old('licencia') }}" required autofocus>
                            </div>
                        </div>

                        <div class="row mb-0 col-sm-12">
                            <div class="col-md-6 offset-md-4 d-flex flex-column align-items-center justify-content-center">

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-arrow-clockwise"></i> Activar licencia
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection