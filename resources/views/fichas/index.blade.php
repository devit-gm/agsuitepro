@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> {{ __('Tokens') }}
                    @if($request != null)
                    @if($request->incluir_cerradas == 1)
                    CERRADAS
                    @endif
                    @endif</div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">
                                <form id="realizar-busqueda" action="{{ route('fichas.index') }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    <!-- <div class="form-group mb-3">
                                        <label for="incluir_cerradas" class="fw-bold form-label">Mostrar fichas cerradas:</label>
                                        <select name="incluir_cerradas" id="incluir_cerradas" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                            <option value="0" @if ($request->incluir_cerradas == 0) selected @endif >No</option>
                                            <option value="1" @if ($request->incluir_cerradas == 1) selected @endif>Sí</option>
                                        </select>
                                    </div>
                                    <br /> -->
                                    @if($request != null)
                                    @if($request->incluir_cerradas == 1)
                                    <input type="hidden" name="incluir_cerradas" id="incluir_cerradas" value="0" />
                                    @else
                                    <input type="hidden" name="incluir_cerradas" id="incluir_cerradas" value="1" />
                                    @endif
                                    @endif

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

                                    @foreach ($fichas as $ficha)
                                    @php
                                    if ($ficha->tipo != 3) {
                                    $ruta = route('fichas.familias', ['uuid' => $ficha->uuid]);
                                    } else {
                                    $ruta = route('fichas.gastos', ['uuid' => $ficha->uuid]);
                                    }
                                    if($ficha->estado == 1 && $ficha->tipo != 3){
                                    $ruta = route('fichas.lista', ['uuid' => $ficha->uuid]);
                                    }
                                    if($ficha->tipo == 4){
                                    $ruta = route('fichas.usuarios', ['uuid' => $ficha->uuid]);
                                    }
                                    @endphp
                                    <table class="table table-bordered table-responsive">
                                        <tbody>
                                            @if ($ficha->descripcion != null && $ficha->descripcion != '')
                                            <tr>
                                                @if($ficha->tipo == 4 && $ficha->apuntado)
                                                <td colspan="3" class="align-middle">
                                                    <i class="bi  bi-calendar-check-fill color-rojo" style="float: right; font-size:1.1em;"></i>
                                                    @else
                                                <td colspan="3" class="align-middle">
                                                    @endif
                                                    <b>{{ $ficha->descripcion }}</b>
                                                </td>
                                            </tr>
                                            @endif
                                            @if($ficha->tipo == 4)
                                            @if ($ficha->menu != null && $ficha->menu != '')
                                            <!-- Añadir icono de menú -->
                                            <tr>
                                                <td colspan="3" class="align-middle">
                                                    <i class="bi bi-book"></i> {{ $ficha->menu }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if ($ficha->responsables != null && $ficha->responsables != '')
                                            <!-- Añadir icono de responsables -->
                                            <tr>
                                                <td colspan="3" class="align-middle">
                                                    <i class="bi bi-person-circle"></i> {{ $ficha->responsables }}
                                                </td>
                                            </tr>
                                            @endif
                                            @endif


                                            <tr class="clickable-row" data-href="{{$ruta}}" data-hrefborrar="{{ route('fichas.destroy', $ficha->uuid) }}" data-textoborrar="¿Está seguro de eliminar la ficha?" data-hrefrestarcantidadmethod="GET" data-hrefrestarcantidad="{{ route('fichas.edit', ['uuid' => $ficha->uuid]) }}" data-borrable="{{$ficha->borrable}}">
                                                <td class="align-middle text-center" style="width:85px">
                                                    @if($ficha->tipo == 4 && $ficha->hora != null)
                                                    <span class="badge bg-danger mt-2 fondo-rojo">{{\Carbon\Carbon::parse($ficha->hora)->format('H:i')}}</span>
                                                    @endif
                                                    <div class="fondo-calendario">

                                                        <p style="padding-top:14px">
                                                            <span style="font-size:0.8em; text-transform:uppercase"><b>{{ $ficha->mes }}</b></span>
                                                            <span style="clear: both;display: block; margin-top: -8px;">{{ \Carbon\Carbon::parse($ficha->fecha)->format('j') }}</span>
                                                        </p>

                                                    </div>

                                                </td>


                                                <td class="align-middle">

                                                    @if ($ficha->tipo != 4 && $ficha->tipo != 2)
                                                    {{ $ficha->usuario->name }}
                                                    <br />
                                                    @endif
                                                    @if ($ficha->tipo == 1)
                                                    <span class="badge bg-white color-negro border border-dark">Individual</span>
                                                    @elseif($ficha->tipo == 2)
                                                    <i class="bi bi-people-fill" style="margin-right: 0.1em;"></i>{{$ficha->total_comensales}} <i class="bi bi-person-standing" style="margin-right: 0.1em;"></i>{{$ficha->total_comensales - $ficha->total_ninos}} <i class="bi bi-person-fill" style="margin-right: 0.1em;"></i>{{$ficha->total_ninos}}<br />
                                                    <span class="badge bg-white color-negro border border-dark">Conjunta</span>
                                                    @elseif($ficha->tipo == 3)
                                                    <span class="badge bg-white color-negro border border-dark">Compra</span>
                                                    @elseif($ficha->tipo == 4)
                                                    <i class="bi bi-people-fill" style="margin-right: 0.1em;"></i>{{$ficha->total_comensales}} <i class="bi bi-person-standing" style="margin-right: 0.1em;"></i>{{$ficha->total_comensales - $ficha->total_ninos}} <i class="bi bi-person-fill" style="margin-right: 0.1em;"></i>{{$ficha->total_ninos}}<br />
                                                    <span class="badge bg-white color-negro border border-dark">Evento</span>
                                                    @endif
                                                    <br />
                                                    @if ($ficha->estado == 0)
                                                    <span class="badge bg-success">Abierta</span>
                                                    @elseif ($ficha->estado == 1)
                                                    <span class="badge bg-dark border border-dark">Cerrada</span>
                                                    @endif

                                                </td>
                                                <td class="align-middle text-center" style="width: 50px" ;>
                                                    <div class="d-flex justify-content-center" style="flex-direction: column;">
                                                        @if($ficha->borrable)
                                                        <a class="btn btn-sm btn-dark mb-2" href="{{ route('fichas.edit', ['uuid' => $ficha->uuid]) }}"><i class="bi bi-pencil fs-5"></i></a>
                                                        <a class="btn btn-sm btn-danger" href="#" onclick="triggerParentClick(event,this);"><i class="bi bi-trash fs-5"></i></a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @endforeach
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
            @if ($request != null && $request->incluir_cerradas == 1)
            <button type="button" onclick="document.getElementById('realizar-busqueda').submit();" class="btn btn-primary mx-1"><i class="bi bi-eye-slash"></i></button>
            @else
            <button type="button" onclick="document.getElementById('realizar-busqueda').submit();" class="btn btn-primary mx-1"><i class="bi bi-eye"></i></button>
            @endif
            <a href="{{ route('fichas.create') }}" class="btn btn-primary fondo-rojo borde-rojo mx-1"><i class="bi bi-plus-circle"></i></a>
        </div>
    </form>
</div>
@endsection