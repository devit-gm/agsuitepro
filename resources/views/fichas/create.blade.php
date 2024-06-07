@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> Nueva ficha</div>

                <div class="card-body">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-md-8 col-lg-6">
                            <form id="nueva-ficha" action="{{ route('fichas.store') }}" method="post">
                                @csrf
                                @if ($errors->any())
                                <div class="custom-error-container" id="custom-error-container">
                                    <ul class="custom-error-list">
                                        @foreach ($errors->all() as $error)
                                        <li class="custom-error-item">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                <input type="hidden" name="estado" value="0" />
                                <input type="hidden" name="invitados_grupo" value="0" />
                                <input type="hidden" name="precio" value="0.0" />
                                <div class="form-group mb-3">
                                    <label for="descripcion" class="fw-bold form-label">Nombre</label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion">
                                </div>
                                <div class="form-group mb-3 required">
                                    <label for="fecha">Fecha:</label><br>
                                    <input type="date" id="fecha" name="fecha" value="{{ old('fecha', $currentDateTime->format('Y-m-d')) }}">
                                </div>
                                <div class="form-group mb-3 required">
                                    <label for="tipo" class="fw-bold form-label">Tipo</label>
                                    <select name="tipo" id="tipo" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                        <option value="1">Individual</option>
                                        <option value="2">Conjunta</option>
                                        <option value="3">Compra</option>
                                        <option value="4">Evento</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('fichas.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('nueva-ficha').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection