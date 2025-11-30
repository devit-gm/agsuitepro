@extends('layouts.app')

@section('content')

<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> {{ __('Editar ficha') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="row justify-content-center align-items-center">
                        <div class="d-grid gap-2 d-md-flex justify-content-end col-sm-12 col-md-8 col-lg-12">
                            <button class="btn btn-lg btn-light border border-dark">{{number_format($ficha->precio,2)}} <i class="bi bi-currency-euro"></i></button>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <form id="editar-ficha" action="{{ route('fichas.update', ['uuid'=>$ficha->uuid]) }}" method="post">
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
                                <input type="hidden" name="user_id" value="{{ $ficha->user_id }}" />
                                <div class="form-group mb-3 required">
                                    <label for="tipo" class="fw-bold form-label">{{ __('Tipo') }}</label>
                                    <select name="tipo" id="tipo" class="form-select form-select-sm" aria-label=".form-select-sm example" required @if($ficha->estado == 1) disabled @endif>
                                        <option value="1" @if($ficha->tipo == 1) selected @endif>{{ __('Individual') }}</option>
                                        <option value="2" @if($ficha->tipo == 2) selected @endif>{{ __('Conjunta') }}</option>
                                        <option value="3" @if($ficha->tipo == 3) selected @endif>{{ __('Compra') }}</option>
                                        <option value="4" @if($ficha->tipo == 4) selected @endif>{{ __('Evento') }}</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="descripcion" class="fw-bold form-label">{{ __('Nombre') }}</label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $ficha->descripcion }}" @if($ficha->estado == 1) disabled @endif>
                                </div>
                                <div class="form-group mb-3 required">
                                    <label for="fecha" class="fw-bold form-label">{{ __('Fecha') }}:</label><br>
                                    <input type="date" id="fecha" name="fecha" value="{{ $fechaCambiada }}" @if($ficha->estado == 1) disabled @endif>
                                </div>
                                <div class="form-group mb-3 required">
                                    <label for="estado" class="fw-bold form-label">{{ __('Estado') }}</label>
                                    <select name="estado" id="estado" class="form-select form-select-sm" aria-label=".form-select-sm example" required @if($ficha->estado == 1) disabled @endif>
                                        <option value="0" @if($ficha->estado == '0') selected @endif>{{ __('Abierta') }}</option>
                                        <option value="1" @if($ficha->estado == '1') selected @endif>{{ __('Cerrada') }}</option>
                                    </select>
                                </div>
                                @if($ficha->tipo == 2)
                                <div class="form-group mb-3">
                                    <label for="invitados_grupo" class="fw-bold form-label">{{ __('Invitados grupo') }}</label>
                                    <input class="form-control" type="number" min="0" name="invitados_grupo" id="invitados_grupo" value="{{ $ficha->invitados_grupo }}">
                                </div>
                                @else
                                <input type="hidden" name="invitados_grupo" value="{{ $ficha->invitados_grupo }}" />
                                @endif

                                {{ __('Sólo para la edición de eventos') }}<br />
                                <div class="form-group mb-3">
                                    <label for="hora" class="fw-bold">{{ __('Hora') }}:</label><br>
                                    <input type="time" id="hora" name="hora" value="{{ $ficha->hora }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="menu" class="fw-bold">{{ __('Menú') }}:</label><br>
                                    <input type="text" class="form-control" id="menu" name="menu" value="{{ $ficha->menu }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="menu" class="fw-bold">{{ __('Responsable/s') }}:</label><br>
                                    <input type="text" class="form-control" id="responsables" name="responsables" value="{{ $ficha->responsables }}">
                                </div>

                                <div class="form-group mb-3 required">

                                    <input type="hidden" id="precio" name="precio" value="{{ $ficha->precio }}" disabled>
                                </div>
                            </form>
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
                    <form action="{{ route('fichas.destroy', ['uuid'=>$ficha->uuid]) }}" method="post">
                        <div class="d-flex align-items-center justify-content-center">

                            <a class="btn btn-dark mx-1" href={{ route('fichas.index') }}><i class="bi bi-chevron-left"></i></a>
                            <a href="{{ route('fichas.familias', ['uuid'=>$ficha->uuid]) }}" title="{{ __('Ver contenido de la ficha') }}" class="btn btn-info mx-1 my-1"><i class="bi bi-cup-straw"></i></a>


                            @if($ficha->estado == 0)
                            <button type="button" class="btn btn-success mx-1" onclick="document.getElementById('editar-ficha').submit();"><i class="bi bi-floppy"></i></button>
                            @endif

                            @if ($ficha->borrable == 1)

                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('{{ __('¿Está seguro de eliminar la ficha?') }}');"><i class="bi bi-trash"></i></button>

                            @endif
                        </div>
                    </form>
                </div>
@endsection