@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-cup-straw"></i> Nuevo producto</div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">
                                <form id="nuevo-producto" action="{{ route('productos.store') }}" method="post" enctype="multipart/form-data">
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
                                    <div class="form-group required mb-3">
                                        <label for="nombre" class="fw-bold form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="imagen" class="fw-bold form-label">Imagen</label>
                                        <input type="file" class="form-control" id="imagen" name="imagen" required></input>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="posicion" class="fw-bold form-label">Posición</label>
                                        <input type="number" class="form-control" id="posicion" name="posicion" required>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="familia" class="fw-bold form-label">Familia</label>
                                        <select name="familia" id="familia" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            @foreach ($familias as $familia)
                                            <option value="{{ $familia->uuid }}">{{ $familia->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="combinado" class="fw-bold form-label">¿Combinado?</label>
                                        <select name="combinado" id="combinado" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            <option value="0">No</option>
                                            <option value="1">Sí</option>
                                        </select>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="precio" class="fw-bold form-label">Precio</label>
                                        <input type="number" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="precio" name="precio" required>
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
@section('footer')
                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('productos.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('nuevo-producto').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>	
@endsection