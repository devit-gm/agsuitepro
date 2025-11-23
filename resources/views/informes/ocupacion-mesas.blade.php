@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-grid-3x3-gap-fill"></i> {{ __('Ocupación de Mesas') }}
                </div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <!-- Filtros de fecha -->
                        <form method="GET" action="{{ route('informes.ocupacion-mesas') }}" class="mb-4">
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
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Total Recaudado') }}</h6>
                                        <h3 class="mb-0">{{ number_format($recaudacionTotal, 2) }}€</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Mesas Totales') }}</h6>
                                        <h3 class="mb-0">{{ $mesasTotales }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Ocupaciones') }}</h6>
                                        <h3 class="mb-0">{{ $ocupacionTotal }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-dark">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Media por Mesa') }}</h6>
                                        <h3 class="mb-0">{{ $mesasTotales > 0 ? number_format($ocupacionTotal / $mesasTotales, 1) : '0' }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de mesas -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>{{ __('Mesa') }}</th>
                                        <th>{{ __('Descripción') }}</th>
                                        <th class="text-center">{{ __('Veces Ocupada') }}</th>
                                        <th class="text-end">{{ __('Total Recaudado') }}</th>
                                        <th class="text-end">{{ __('Ticket Medio') }}</th>
                                        <th class="text-center">{{ __('Tiempo Medio') }}</th>
                                        <th class="text-center">{{ __('% Ocupación') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($estadisticasMesas as $mesa)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary fs-6">{{ $mesa->numero_mesa }}</span>
                                        </td>
                                        <td class="fw-bold">{{ $mesa->descripcion }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $mesa->veces_ocupada }}</span>
                                        </td>
                                        <td class="text-end text-success fw-bold">{{ number_format($mesa->total_recaudado, 2) }}€</td>
                                        <td class="text-end">{{ number_format($mesa->ticket_medio, 2) }}€</td>
                                        <td class="text-center">
                                            @if($mesa->tiempo_medio_ocupacion)
                                                <span class="badge bg-info">{{ round($mesa->tiempo_medio_ocupacion) }} min</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $porcentaje = $ocupacionTotal > 0 ? ($mesa->veces_ocupada / $ocupacionTotal) * 100 : 0;
                                            @endphp
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-primary" role="progressbar" 
                                                     style="width: {{ $porcentaje }}%" 
                                                     aria-valuenow="{{ $porcentaje }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ number_format($porcentaje, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
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
