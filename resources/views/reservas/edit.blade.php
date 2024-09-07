@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-calendar3"></i> Editar reserva</div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">
                                <form id="editar-reserva" action="{{ route('reservas.update', $reserva->uuid) }}" method="post">
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
                                    <input type="hidden" name="user_id" value="{{ $userId }}">
                                    <div class="form-group required mb-3">
                                        <label for="name" class="fw-bold form-label">Nombre</label>
                                        <input type="textarea" class="form-control" id="name" name="name" value="{{ $reserva->name }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="start_time" class="fw-bold form-label">Fecha inicio</label><br />
                                        <input type="datetime-local" name="start_time" value="{{ $reserva->start_time }}">
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="end_time" class="fw-bold form-label">Fecha fin</label><br />
                                        <input type="datetime-local" name="end_time" value="{{ $reserva->end_time }}">
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
                    <form action="{{ route('reservas.destroy', $reserva->uuid) }}" method="post">
                        <div class="d-flex align-items-center justify-content-center">
                            @csrf
                            @method('DELETE')
                            <a class="btn btn-dark mx-1" href={{ route('reservas.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('editar-reserva').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                            @if ($reserva->usuario->id == Auth::user()->id)
                            <button type="submit" class="btn btn-danger mx-1 my-1" title="Eliminar reserva" onclick="return confirm('¿Está seguro de eliminar la reserva?');"><i class="bi bi-trash"></i></button>
                            @endif
                        </div>
                    </form>
                </div>
				@endsection