@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-clock-history"></i> {{ __('Análisis de Horas Pico') }}
                </div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <!-- Filtros de fecha -->
                        <form method="GET" action="{{ route('informes.horas-pico') }}" class="mb-4">
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

                        <!-- Ventas por hora del día -->
                        <div class="mb-5">
                            <h5 class="mb-3"><i class="bi bi-clock"></i> {{ __('Ventas por Hora del Día') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>{{ __('Hora') }}</th>
                                            <th class="text-center">{{ __('Mesas Abiertas') }}</th>
                                            <th class="text-end">{{ __('Total Vendido') }}</th>
                                            <th class="text-end">{{ __('Ticket Medio') }}</th>
                                            <th>{{ __('Actividad') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $maxVentas = $ventasPorHora->max('total_vendido') ?? 1;
                                        @endphp
                                        @forelse($ventasPorHora as $venta)
                                        <tr>
                                            <td class="fw-bold">
                                                <i class="bi bi-clock"></i>
                                                {{ str_pad($venta->hora, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($venta->hora + 1, 2, '0', STR_PAD_LEFT) }}:00
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $venta->mesas_abiertas }}</span>
                                            </td>
                                            <td class="text-end fw-bold text-success">{{ number_format($venta->total_vendido, 2) }}€</td>
                                            <td class="text-end">{{ number_format($venta->ticket_medio, 2) }}€</td>
                                            <td>
                                                @php
                                                    $porcentaje = ($venta->total_vendido / $maxVentas) * 100;
                                                @endphp
                                                <div class="progress" style="height: 25px;">
                                                    <div class="progress-bar 
                                                        {{ $porcentaje > 80 ? 'bg-success' : ($porcentaje > 50 ? 'bg-warning' : 'bg-secondary') }}" 
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

                        <!-- Ventas por día de la semana -->
                        <div>
                            <h5 class="mb-3"><i class="bi bi-calendar-week"></i> {{ __('Ventas por Día de la Semana') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>{{ __('Día') }}</th>
                                            <th class="text-center">{{ __('Mesas Cerradas') }}</th>
                                            <th class="text-end">{{ __('Total Vendido') }}</th>
                                            <th class="text-end">{{ __('Ticket Medio') }}</th>
                                            <th>{{ __('Rendimiento') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $maxVentasDia = $ventasPorDia->max('total_vendido') ?? 1;
                                        @endphp
                                        @forelse($ventasPorDia as $venta)
                                        <tr>
                                            <td class="fw-bold">
                                                <i class="bi bi-calendar-check"></i>
                                                {{ $venta->dia_nombre }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $venta->mesas_cerradas }}</span>
                                            </td>
                                            <td class="text-end fw-bold text-success">{{ number_format($venta->total_vendido, 2) }}€</td>
                                            <td class="text-end">{{ number_format($venta->ticket_medio, 2) }}€</td>
                                            <td>
                                                @php
                                                    $porcentaje = ($venta->total_vendido / $maxVentasDia) * 100;
                                                @endphp
                                                <div class="progress" style="height: 25px;">
                                                    <div class="progress-bar 
                                                        {{ $porcentaje > 80 ? 'bg-success' : ($porcentaje > 50 ? 'bg-warning' : 'bg-secondary') }}" 
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
