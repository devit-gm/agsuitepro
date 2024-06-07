@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-card-list"></i> INFORMES - BALANCE
                </div>

                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-end">
                        @if ($mostrarBotonFacturar == true)
                        @if (Auth::user()->hasRole('Administrador'))
                        <a class="btn btn-lg btn-success fs-3" onclick="if(confirm('Se marcará como facturado todo lo pendiente. Desea continuar?')){location.href=this.data.href}" href={{ route('informes.facturar') }}><i class="bi bi-cash-coin"></i> Facturar pendiente</a>
                        @endif
                        @endif
                    </div>
                    <div class="container-fluid mt-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-6">
                                <form id="realizar-busqueda" action="{{ route('informes.index') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    @if (session('success'))
                                    <div class="custom-success-container" id="custom-success-container">
                                        <ul class="custom-success-list">
                                            <li class="custom-success-item">{{ session('success') }}</li>
                                        </ul>
                                    </div>
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


                                    <div class="form-group required mb-3">
                                        <label for="fecha_inicial" class="fw-bold form-label">Fecha inicial</label><br />
                                        <input class="w-100" type="date" name="fecha_inicial" id="fecha_inicial" value="{{ $request->fecha_inicial }}">
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="fecha_final" class="fw-bold form-label">Fecha final</label><br />
                                        <input type="date" class="w-100" name="fecha_final" id="fecha_final" value="{{ $request->fecha_final }}">
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="incluir_facturados" class="fw-bold form-label">Incluir facturados:</label>
                                        <select name="incluir_facturados" id="incluir_facturados" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            <option value="0" @if($request->incluir_facturados == 0) selected @endif>No</option>
                                            <option value="1" @if($request->incluir_facturados == 1) selected @endif>Sí</option>
                                        </select>
                                    </div>
                                    <br />
                                    @foreach ($usuariosInforme as $usuario) <table class="table table-bordered table-responsive table-hover">

                                        <tbody>
                                            <tr>
                                                <th colspan="3" class="align-middle fondo-negro">
                                                    {{ $usuario->name }}
                                                </th>
                                            </tr>
                                            <tr class="">

                                                <th scope="col-auto" class="text-center">Gastos</th>
                                                <th scope="col-auto" class="text-center">Compras</th>
                                                <th scope="col-auto" class="text-center">Balance</th>
                                            </tr>
                                            <tr>

                                                <td class="text-end">
                                                    {{ number_format($usuario->gastos,2) }}€
                                                </td>
                                                <td class="text-end">
                                                    {{ number_format($usuario->compras,2) }}€
                                                </td>
                                                <td class="text-end">
                                                    {{ number_format($usuario->balance,2) }}€
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

                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <button type="button" onclick="document.getElementById('realizar-busqueda').submit();" class="btn btn-info mx-1"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection