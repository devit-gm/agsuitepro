@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-10 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-graph-up"></i> {{ __('FACTURACIÓN') }} - {{ __('Por Camarero') }}
                </div>
                <div class="card-body overflow-auto flex-fill">
                    <!-- Gráfico de barras por camarero -->
                    <div class="row">
                        <div class="col-lg-8 col-md-12 mb-4">
                            <h5 class="text-center mb-3">{{ __('Facturación mensual por camarero') }}</h5>
                            <div>
                                <canvas id="graficoFacturacionCamareros" style="max-height: 400px;"></canvas>
                            </div>
                        </div>
                        
                        <!-- Gráfico de sectores por camarero -->
                        <div class="col-lg-4 col-md-12 mb-4">
                            <h5 class="text-center mb-3">{{ __('Distribución anual por camarero') }}</h5>
                            <div>
                                <canvas id="graficoSectoresCamareros" style="max-height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Resumen de totales por camarero -->
                    <div class="row mt-4">
                        @foreach($totalesCamareros as $camarero => $total)
                        <div class="col-md-4 col-lg-3 mb-3">
                            <div class="alert alert-info text-center">
                                <strong>{{ $camarero }}:</strong><br>
                                {{ number_format($total, 2, ',', '.') }} €
                            </div>
                        </div>
                        @endforeach
                        
                        @if(count($totalesCamareros) > 0)
                        <div class="col-12">
                            <div class="alert alert-success text-center">
                                <strong>{{ __('Total general') }}:</strong><br>
                                {{ number_format(array_sum($totalesCamareros), 2, ',', '.') }} €
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Desglose de IVA -->
                    @if(isset($desgloseIva) && !empty($desgloseIva))
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">{{ __('Desglose de IVA') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-warning">
                                        <tr>
                                            <th>{{ __('Tipo IVA') }}</th>
                                            <th class="text-end">{{ __('Base Imponible') }}</th>
                                            <th class="text-end">{{ __('Cuota IVA') }}</th>
                                            <th class="text-end">{{ __('Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($desgloseIva as $tipo => $datos)
                                        <tr>
                                            <td><strong>IVA {{ number_format($tipo, 0) }}%</strong></td>
                                            <td class="text-end">{{ number_format($datos['base'], 2, ',', '.') }} €</td>
                                            <td class="text-end text-warning">{{ number_format($datos['cuota'], 2, ',', '.') }} €</td>
                                            <td class="text-end">{{ number_format($datos['base'] + $datos['cuota'], 2, ',', '.') }} €</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td><strong>{{ __('TOTALES') }}</strong></td>
                                            <td class="text-end"><strong>{{ number_format($totalBaseImponible ?? 0, 2, ',', '.') }} €</strong></td>
                                            <td class="text-end text-warning"><strong>{{ number_format($totalCuotaIva ?? 0, 2, ',', '.') }} €</strong></td>
                                            <td class="text-end"><strong>{{ number_format(($totalBaseImponible ?? 0) + ($totalCuotaIva ?? 0), 2, ',', '.') }} €</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<div class="card-footer">
    <form id="form-filtro-año" action="{{ route('facturacion.index') }}" method="GET">
        <div class="d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-calendar-event"></i>
            <select name="año" id="año" class="form-select" style="width: auto; min-width: 100px;" onchange="document.getElementById('form-filtro-año').submit();">
                @foreach($añosDisponibles as $añoDisponible)
                    <option value="{{ $añoDisponible }}" {{ $año == $añoDisponible ? 'selected' : '' }}>
                        {{ $añoDisponible }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('graficoFacturacionCamareros');
        
        const meses = [
            '{{ __("Enero") }}',
            '{{ __("Febrero") }}',
            '{{ __("Marzo") }}',
            '{{ __("Abril") }}',
            '{{ __("Mayo") }}',
            '{{ __("Junio") }}',
            '{{ __("Julio") }}',
            '{{ __("Agosto") }}',
            '{{ __("Septiembre") }}',
            '{{ __("Octubre") }}',
            '{{ __("Noviembre") }}',
            '{{ __("Diciembre") }}'
        ];
        
        const datasets = @json($datasets);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += new Intl.NumberFormat('es-ES', {
                                    style: 'currency',
                                    currency: 'EUR'
                                }).format(context.parsed.y);
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: false
                    },
                    y: {
                        beginAtZero: true,
                        stacked: false,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('es-ES', {
                                    style: 'currency',
                                    currency: 'EUR',
                                    minimumFractionDigits: 0
                                }).format(value);
                            }
                        }
                    }
                }
            }
        });
        
        // Gráfico de sectores por camarero
        const ctxPie = document.getElementById('graficoSectoresCamareros');
        const totalesCamareros = @json($totalesCamareros);
        const camareros = Object.keys(totalesCamareros);
        const totales = Object.values(totalesCamareros);
        
        // Colores para el gráfico de sectores
        const coloresPie = [
            'rgba(220, 53, 69, 0.8)',
            'rgba(13, 110, 253, 0.8)',
            'rgba(25, 135, 84, 0.8)',
            'rgba(255, 193, 7, 0.8)',
            'rgba(111, 66, 193, 0.8)',
            'rgba(13, 202, 240, 0.8)',
        ];
        
        const coloresBorde = [
            'rgba(220, 53, 69, 1)',
            'rgba(13, 110, 253, 1)',
            'rgba(25, 135, 84, 1)',
            'rgba(255, 193, 7, 1)',
            'rgba(111, 66, 193, 1)',
            'rgba(13, 202, 240, 1)',
        ];
        
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: camareros,
                datasets: [{
                    data: totales,
                    backgroundColor: coloresPie.slice(0, camareros.length),
                    borderColor: coloresBorde.slice(0, camareros.length),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += new Intl.NumberFormat('es-ES', {
                                    style: 'currency',
                                    currency: 'EUR'
                                }).format(context.parsed);
                                
                                // Calcular porcentaje
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const porcentaje = ((context.parsed / total) * 100).toFixed(1);
                                label += ' (' + porcentaje + '%)';
                                
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
