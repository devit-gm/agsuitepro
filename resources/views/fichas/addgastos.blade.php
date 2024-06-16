@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> Ficha - Nuevo gasto</div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">
                                <form id="nuevo-gasto" action="{{ route('fichas.updategastos', $ficha->uuid) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    @if ($errors->any())
                                    <div class="custom-error-container" id="custom-error-container">
                                        <ul class="custom-error-list">
                                            @foreach ($errors->all() as $error)
                                            <li class="custom-error-item">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group mb-3 required">
                                        <label for="usuario" class="fw-bold form-label">Usuario</label>
                                        <select name="usuario" id="usuario" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            @foreach ($usuariosFicha as $usuario)
                                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="descripcion" class="fw-bold form-label">Descripción</label>
                                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="precio" class="fw-bold form-label">Precio</label>
                                        <input type="number" step='0.01' value="{{ old('precio') }}" placeholder='0.00' class="form-control" id="precio" name="precio" required>
                                    </div>
                                    @php
                                    if($ficha->tipo ==3 ){
                                    $ticket = 'required';
                                    }else{
                                    $ticket = '';
                                    }
                                    @endphp
                                    <div class="form-group mb-3 {{$ticket}}">
                                        <label for="ticket" class="fw-bold form-label">Ticket</label>
                                        <input type="file" class="form-control" id="ticket" name="ticket" @if($ticket=="required" ) required @endif></input>
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
                            <button type="button" onclick="document.getElementById('nuevo-gasto').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection