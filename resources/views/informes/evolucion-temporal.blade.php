@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-graph-up"></i> {{ __('Evolución Temporal') }}
                </div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <!-- Filtros de fecha -->
                        <form method="GET" action="{{ route('informes.evolucion-temporal') }}" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="fecha_inicial" class="form-label fw-bold">{{ __('Fecha inicial') }}</label>
                                    <input type="date" class="form-control" id="fecha_inicial" name="fecha_inicial" value="{{ $fechaInicial }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_final" class="form-label fw-bold">{{ __('Fecha final') }}</label>
                                    <input type="date" class="form-control" id="fecha_final" name="fecha_final" value="{{ $fechaFinal }}" required>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-search"></i> {{ __('Buscar') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Resumen -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Total Período') }}</h6>
                                        <h3 class="mb-0">{{ number_format($totalPeriodo, 2) }}€</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Transacciones') }}</h6>
                                        <h3 class="mb-0">{{ number_format($transaccionesTotal, 0) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ventas por día -->
                        <div class="mb-5">
                            <h5 class="mb-3"><i class="bi bi-calendar-day"></i> {{ __('Ventas Diarias') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>{{ __('Fecha') }}</th>
                                            <th class="text-center">{{ __('Transacciones') }}</th>
                                            <th class="text-end">{{ __('Total Vendido') }}</th>
                                            <th class="text-end">{{ __('Ticket Medio') }}</th>
                                            <th>{{ __('Progreso') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $maxVentas = $ventasPorDia->max('total_vendido') ?? 1;
                                        @endphp
                                        @forelse($ventasPorDia as $venta)
                                        <tr>
                                            <td class="fw-bold">
                                                <i class="bi bi-calendar-check"></i>
                                                {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $venta->num_transacciones }}</span>
                                            </td>
                                            <td class="text-end fw-bold text-success">{{ number_format($venta->total_vendido, 2) }}€</td>
                                            <td class="text-end">{{ number_format($venta->ticket_medio, 2) }}€</td>
                                            <td>
                                                @php
                                                    $porcentaje = ($venta->total_vendido / $maxVentas) * 100;
                                                @endphp
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-primary" 
                                                        role="progressbar" 
                                                        style="width: {{ $porcentaje }}%" 
                                                        aria-valuenow="{{ $porcentaje }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                        {{ number_format($porcentaje, 0) }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                {{ __('No hay datos para el período seleccionado') }}
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Ventas por mes (últimos 12 meses) -->
                        <div>
                            <h5 class="mb-3"><i class="bi bi-calendar3"></i> {{ __('Ventas Mensuales') }} ({{ __('Últimos 12 meses') }})</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>{{ __('Mes') }}</th>
                                            <th class="text-center">{{ __('Transacciones') }}</th>
                                            <th class="text-end">{{ __('Total Vendido') }}</th>
                                            <th class="text-end">{{ __('Ticket Medio') }}</th>
                                            <th>{{ __('Progreso') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $maxVentasMes = $ventasPorMes->max('total_vendido') ?? 1;
                                        @endphp
                                        @forelse($ventasPorMes as $venta)
                                        <tr>
                                            <td class="fw-bold">
                                                <i class="bi bi-calendar-month"></i>
                                                {{ $venta->mes_nombre }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $venta->num_transacciones }}</span>
                                            </td>
                                            <td class="text-end fw-bold text-success">{{ number_format($venta->total_vendido, 2) }}€</td>
                                            <td class="text-end">{{ number_format($venta->ticket_medio, 2) }}€</td>
                                            <td>
                                                @php
                                                    $porcentaje = ($venta->total_vendido / $maxVentasMes) * 100;
                                                @endphp
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" 
                                                        role="progressbar" 
                                                        style="width: {{ $porcentaje }}%" 
                                                        aria-valuenow="{{ $porcentaje }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                        {{ number_format($porcentaje, 0) }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                {{ __('No hay datos disponibles') }}
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="bi bi-chevron-left"></i> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
