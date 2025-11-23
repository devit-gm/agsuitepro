@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-calendar3"></i> {{ __('Nueva reserva') }}</div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="nueva-reserva" action="{{ route('reservas.store') }}" method="post">
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


                                    <input type="hidden" name="user_id" value="{{ $userId }}">
                                    <div class="form-group required mb-3">
                                        <label for="name" class="fw-bold form-label">{{ __('Nombre') }}</label>
                                        <input type="textarea" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="start_time" class="fw-bold form-label">{{ __('Fecha inicio') }}</label><br />
                                        <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}">
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="end_time" class="fw-bold form-label">{{ __('Fecha fin') }}</label><br />
                                        <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}">
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

@push('scripts')
<script>
let validandoFechaFinReserva = false;

function actualizarFechaFinReserva() {
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    
    if (startTime.value) {
        // Si la fecha final está vacía o es anterior a la inicial, actualizarla
        if (!endTime.value || endTime.value < startTime.value) {
            endTime.value = startTime.value;
        }
        // Establecer la fecha mínima (aunque Safari iOS no lo respete)
        endTime.setAttribute('min', startTime.value);
    } else {
        endTime.removeAttribute('min');
    }
}

// Validación manual para Safari iOS cuando cambia la fecha final
function validarFechaFinReserva() {
    if (validandoFechaFinReserva) return;
    
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    
    if (startTime.value && endTime.value) {
        if (endTime.value < startTime.value) {
            validandoFechaFinReserva = true;
            // Forzar blur para cerrar el datepicker antes del alert
            endTime.blur();
            setTimeout(function() {
                alert('{{ __('La fecha fin no puede ser anterior a la fecha inicio') }}');
                endTime.value = startTime.value;
                validandoFechaFinReserva = false;
            }, 100);
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    
    // Ejecutar al cargar la página si ya hay fecha inicial
    actualizarFechaFinReserva();
    
    // Agregar listeners
    startTime.addEventListener('change', actualizarFechaFinReserva);
    endTime.addEventListener('change', validarFechaFinReserva);
    endTime.addEventListener('blur', validarFechaFinReserva);
});
</script>
@endpush
@endsection
@section('footer')
                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('reservas.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('nueva-reserva').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>	
@endsection