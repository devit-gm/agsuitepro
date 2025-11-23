@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-people-fill"></i> {{ __('Ventas por Camarero') }}
                </div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <!-- Filtros de fecha -->
                        <form method="GET" action="{{ route('informes.ventas-camareros') }}" class="mb-4">
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
                            <div class="col-md-4">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Total Facturado') }}</h6>
                                        <h3 class="mb-0">{{ number_format($totalGeneral, 2) }}€</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Mesas Atendidas') }}</h6>
                                        <h3 class="mb-0">{{ $mesasTotal }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Ticket Medio') }}</h6>
                                        <h3 class="mb-0">{{ $mesasTotal > 0 ? number_format($totalGeneral / $mesasTotal, 2) : '0.00' }}€</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de camareros -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>{{ __('Ranking') }}</th>
                                        <th>{{ __('Camarero') }}</th>
                                        <th class="text-center">{{ __('Mesas') }}</th>
                                        <th class="text-end">{{ __('Total Vendido') }}</th>
                                        <th class="text-end">{{ __('Ticket Medio') }}</th>
                                        <th class="text-center">{{ __('% Total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ventasCamareros as $index => $venta)
                                    <tr>
                                        <td>
                                            <span class="badge bg-{{ $index === 0 ? 'warning' : ($index === 1 ? 'secondary' : ($index === 2 ? 'bronze' : 'light text-dark')) }}">
                                                #{{ $index + 1 }}
                                            </span>
                                        </td>
                                        <td>
                                            <i class="bi bi-person-circle"></i>
                                            <span class="fw-bold">{{ $venta->camarero }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $venta->mesas_atendidas }}</span>
                                        </td>
                                        <td class="text-end fw-bold text-success">{{ number_format($venta->total_vendido, 2) }}€</td>
                                        <td class="text-end">{{ number_format($venta->ticket_medio, 2) }}€</td>
                                        <td class="text-center">
                                            @php
                                                $porcentaje = $totalGeneral > 0 ? ($venta->total_vendido / $totalGeneral) * 100 : 0;
                                            @endphp
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $porcentaje }}%; background-color: {{ $index === 0 ? '#ffc107' : ($index === 1 ? '#6c757d' : '#28a745') }}" 
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
                                        <td colspan="6" class="text-center text-muted py-4">
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
