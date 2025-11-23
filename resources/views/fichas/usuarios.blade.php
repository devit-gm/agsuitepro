<!-- filepath: /home/david/Documentos/agsuitepro/resources/views/fichas/usuarios.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> {{ $ajustes->modo_operacion === 'mesas' ? __("MESA") . ' ' . $ficha->numero_mesa . ' - ' . __("Asistentes") : __("FICHA - Asistentes") }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="d-flex justify-content-between align-items-center col-sm-12 col-md-12 col-lg-12 mb-3">
                        <button class="btn btn-lg btn-light border border-dark"><i class="bi bi-people"></i> {{ $ficha->total_comensales }}</button>
                        <button class="btn btn-lg btn-light border border-dark">{{number_format($ficha->precio,2)}} <i class="bi bi-currency-euro"></i></button>
                    </div>
                    <div class="container-fluid mt-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12" style="padding: 0px;">


                                <form id='editar-usuariosficha' action="{{ fichaRoute('updateusuarios', $ficha->uuid) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="container mt-3">
                                        <div class="row">
                                            @if ($errors->any())
                                            <div class="custom-error-container" id="custom-error-container">
                                                <ul class="custom-error-list">
                                                    @foreach ($errors->all() as $error)
                                                    <li class="custom-error-item">{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                            @if (session('success'))
                                            <div class="custom-success-container" id="custom-success-container">
                                                <ul class="custom-success-list">
                                                    <li class="custom-success-item">{{ session('success') }}</li>
                                                </ul>
                                            </div>
                                            @endif
                                            <style>
    /* ---- TABLA USUARIOS (ESTILO MINIMALISTA) ---- */

    .tabla-usuarios {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 6px;
        font-size: 0.95rem;
        padding:0px;
    }

    .tabla-usuarios thead th {
        background: #f7f7f7;
        padding: 12px;
        font-weight: 600;
        border-bottom: 2px solid #e5e5e5;
        text-align: center;
    }

    .tabla-usuarios tbody tr {
        background: #ffffff;
        border-radius: 8px;
        transition: background 0.2s ease;
    }

    .tabla-usuarios tbody tr:hover {
        background: #f4f7ff;
    }

    .tabla-usuarios td {
        padding: 16px;
        vertical-align: middle;
        border-top: 1px solid #efefef;
    }

    .tabla-usuarios td:first-child {
        border-left: 1px solid #efefef;
        border-radius: 8px 0 0 8px;
        font-size:18px;
    }

    .tabla-usuarios td:last-child {
        border-right: 1px solid #efefef;
        border-radius: 0 8px 8px 0;
    }

    /* ---- SWITCH ---- */
    .form-check-input {
        cursor: pointer;
        transform: scale(1.3);
    }
    .form-check-input.readonly {
        pointer-events: none;
        opacity: 0.6;
    }

    .form-switch .form-check-input{
        margin-left:0px;
    }

    /* ---- SELECT MINIMALISTA ---- */
    .tabla-usuarios select {
        font-size: 0.9rem;
        padding: 4px 6px;
        height: 34px;
        border-radius: 6px;
    }
</style>



<table class="tabla-usuarios table-responsive">
    <thead>
        <tr>
            <th class="text-start">{{ __('Nombre') }}</th>

            @if($ficha->estado == 0)
                <th>-</th>
            @endif

            <th><i class="bi bi-person-standing"></i></th>
            <th><i class="bi bi-person-fill"></i></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($usuariosFicha as $usuario)
        <tr style="height: 80px;">

            <!-- Nombre -->
            <td class="align-middle">
                {{ $usuario->name }}
            </td>

            <!-- Switch on/off -->
            @if($ficha->estado == 0)
            <td class="align-middle text-center">
                <div class="form-check form-switch m-0 p-0">
                    <input 
                        class="form-check-input 
                               @if($ficha->tipo != 4 && $usuario->id == $ficha->user_id) readonly @endif"
                        type="checkbox"
                        role="switch"
                        name="usuarios[{{ $usuario->id }}]"
                        id="usuarios[{{ $usuario->id }}]"
                        value="{{ $usuario->id }}"
                        @if($usuario->marcado == 1) checked @endif
                        @if($ficha->estado == 1) disabled @endif
                    >
                </div>
            </td>
            @endif

            <!-- Invitados -->
            <td class="align-middle text-center">
                <select class="form-control form-select"
                        name="invitados[{{ $usuario->id }}]"
                        id="invitados[{{ $usuario->id }}]"
                        style="width: 60px;"
                        @if($ficha->estado == 1) disabled @endif>
                    @for ($i = 0; $i <= $ajustes->max_invitados_cobrar; $i++)
                        <option value="{{ $i }}" @if($usuario->invitados == $i) selected @endif>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </td>

            <!-- Niños -->
            <td class="align-middle text-center">
                <select class="form-control form-select"
                        name="ninos[{{ $usuario->id }}]"
                        id="ninos[{{ $usuario->id }}]"
                        style="width: 60px;"
                        @if($ficha->estado == 1) disabled @endif>
                    @for ($i = 0; $i <= $ajustes->max_invitados_cobrar; $i++)
                        <option value="{{ $i }}" @if($usuario->ninos == $i) selected @endif>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

                                        </div>
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
            <a class="btn btn-dark mx-1" href={{ fichaRoute('lista', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>

            @if (
                auth()->user()->role_id > 2 &&
                $ficha->user_id != auth()->user()->id &&
                $ficha->tipo == 4 &&
                now()->diffInDays(\Carbon\Carbon::parse($ficha->fecha), false) < $ajustes->limite_inscripcion_dias_eventos
            )
            @else
                @if($ficha->estado == 0)
                <button type="button" onclick="document.getElementById('editar-usuariosficha').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                @endif
            @endif
            <a class="btn btn-dark mx-1" href={{ fichaRoute('servicios', $ficha->uuid) }}><i class="bi bi-chevron-right"></i></a>
        </div>
    </form>
</div>
@endsection