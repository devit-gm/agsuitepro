@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-card-list"></i> BALANCE POR SOCIO
                </div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">
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
                                            <option value="0" @if ($request->incluir_facturados == 0) selected @endif >No</option>
                                            <option value="1" @if ($request->incluir_facturados == 1) selected @endif>Sí</option>
                                        </select>
                                    </div>
                                    <br />
                                    @php
                                    $totalGastos = 0;
                                    $totalCompras = 0;
                                    $totalBalance = 0;
                                    @endphp
                                    @foreach ($usuariosInforme as $usuario)
                                    <table class="table table-bordered table-responsive table-hover">
                                        @php
                                        $totalGastos += $usuario->gastos;
                                        $totalCompras += $usuario->compras;
                                        $totalBalance += $usuario->balance;
                                        @endphp
                                        <tbody>
                                            <tr>
                                                <th colspan="3" class="align-middle">
                                                    {{ $usuario->name }}
                                                </th>
                                            </tr>
                                            <tr class="">

                                                <th scope="col-auto" class="text-center"><i class="bi bi-cup-straw"></i></th>
                                                <th scope="col-auto" class="text-center"><i class="bi bi-cart2"></i></th>
                                                <th scope="col-auto" class="text-center"><i class="bi bi-graph-up"></i></th>
                                            </tr>
                                            <tr>

                                                <td class="text-center">
                                                    {{ number_format($usuario->gastos,2) }}€
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format($usuario->compras,2) }}€
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format($usuario->balance,2) }}€
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @endforeach
                                    <table class="table table-bordered table-responsive table-hover">

                                        <tbody>
                                            <tr>
                                                <th colspan="3" class="align-middle">
                                                    TOTAL
                                                </th>
                                            </tr>
                                            <tr class="">

                                                <th scope="col-auto" class="text-center"><i class="bi bi-cup-straw"></i></th>
                                                <th scope="col-auto" class="text-center"><i class="bi bi-cart2"></i></th>
                                                <th scope="col-auto" class="text-center"><i class="bi bi-graph-up"></i></th>
                                            </tr>
                                            <tr>

                                                <td class="text-center">
                                                    {{ number_format($totalGastos,2) }}€
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format($totalCompras,2) }}€
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format($totalBalance,2) }}€
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
    <form id="form-facturar" method="POST" action={{ route('informes.facturar'); }}>
        @csrf
        @method('PUT')
        <div class="d-flex align-items-center justify-content-center">
            <button type="button" onclick="document.getElementById('realizar-busqueda').submit();" class="btn btn-secondary mx-1"><i class="bi bi-search"></i></button>
            @if ($mostrarBotonFacturar == true)
            @if (Auth::user()->role_id < 4) </form>
                <a class="btn btn-success fondo-rojo borde-rojo fs-3" href="#" onclick="if(confirm('Se marcará como facturado todo lo pendiente. ¿Desea continuar?')){ document.getElementById('form-facturar').submit(); }"><i class="bi bi-cash-coin"></i></a>
                @endif
                @endif
        </div>
    </form>
</div>
@endsection