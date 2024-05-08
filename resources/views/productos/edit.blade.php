@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fondo-rojo"><i class="bi bi-cup-straw"></i> Editar producto</div>

                <div class="card-body">
                    <div class="container h-100">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-6">
                                <form action="{{ route('productos.update', $producto->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group required mb-3">
                                        <label for="nombre" class="fw-bold form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $producto->nombre }}" required>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <img width="100" class="float-end" src="{{ URL::to('/') }}/images/{{ $producto->imagen }}" />
                                        <div class="form-group">
                                            <label for="imagen" class="fw-bold form-label">Imagen</label>
                                            <input type="file" class="form-control" id="imagen" name="imagen" />
                                        </div>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="posicion" class="fw-bold form-label">Posición</label>
                                        <input type="number" class="form-control" id="posicion" name="posicion" value="{{ $producto->posicion }}" required>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="familia" class="fw-bold form-label">Familia</label>
                                        <select name="familia" id="familia" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            @foreach ($familias as $familia)
                                            <option value="{{ $familia->id }}" @if( $producto->familia == $familia->id ) selected @endif>{{ $familia->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="combinado" class="fw-bold form-label">¿Combinado?</label>
                                        <select name="combinado" id="combinado" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            <option value="0" @if( $producto->combinado == 0 ) selected @endif>No</option>
                                            <option value="1" @if( $producto->combinado == 1 ) selected @endif>Sí</option>
                                        </select>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="precio" class="fw-bold form-label">Precio</label>
                                        @if( $producto->combinado == 0 )
                                        <input type="number" step='0.01' placeholder='0.00' class="form-control" id="precio" name="precio" value="{{ $producto->precio }}" required>
                                        @else
                                        <input type="number" placeholder='0.00' class="form-control" id="precio" name="precio" value="{{ $producto->precio }}" required>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="submit" class="btn btn-sm btn-success mx-1"><i class="bi bi-floppy"></i> Guardar</button>
                                        <a class="btn btn-sm btn-dark mx-1" href={{ route('productos.index') }}><i class="bi bi-x-circle"></i> Cancelar</a>
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