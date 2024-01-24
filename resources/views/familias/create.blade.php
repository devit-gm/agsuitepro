@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo"><i class="bi bi-tag"></i> Nueva familia</div>

                <div class="card-body">
                    <div class="container h-100">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-6">
                                <form action="{{ route('familias.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3 required">
                                        <label for="title" class="fw-bold form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="body" class="fw-bold form-label">Imagen</label>
                                        <input type="file" class="form-control" id="imagen" name="imagen" required></input>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="title" class="fw-bold form-label">Posición</label>
                                        <input type="number" class="form-control" id="posicion" name="posicion" required>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="submit" class="btn btn-sm btn-success mx-1"><i class="bi bi-floppy"></i> Guardar</button>
                                        <a class="btn btn-sm btn-dark mx-1" href={{ route('familias.index') }}><i class="bi bi-x-circle"></i> Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection