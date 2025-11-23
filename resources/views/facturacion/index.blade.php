@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-10 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-graph-up"></i> {{ __('FACTURACIÓN') }}
                </div>

                <div class="card-body overflow-auto flex-fill">
                    <!-- Gráfico de barras -->
                    <div class="row">
                        <div class="col-lg-8 col-md-12 mb-4">
                            <h5 class="text-center mb-3">{{ __('Facturación mensual') }}</h5>
                            <canvas id="graficoFacturacion" style="max-height: 400px;"></canvas>
                        </div>
                        
                        <!-- Gráfico de sectores -->
                        <div class="col-lg-4 col-md-12 mb-4">
                            <h5 class="text-center mb-3">{{ __('Distribución anual') }}</h5>
                            <canvas id="graficoSectores" style="max-height: 400px;"></canvas>
                        </div>
                    </div>

                    <!-- Resumen de totales -->
                    <div class="row mt-4">
                        <div class="col-md-4 mb-2">
                            <div class="alert alert-success text-center">
                                <strong>{{ __('Total ingresos') }}:</strong><br>
                                {{ number_format($totalIngresos, 2, ',', '.') }} €
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="alert alert-danger text-center">
                                <strong>{{ __('Total gastos') }}:</strong><br>
                                {{ number_format($totalGastos, 2, ',', '.') }} €
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="alert alert-info text-center">
                                <strong>{{ __('Balance neto') }}:</strong><br>
                                {{ number_format($totalIngresos - $totalGastos, 2, ',', '.') }} €
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('graficoFacturacion');
        
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
        
        const datos = @json($datosGrafico);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: '{{ __("Facturación") }} (€)',
                    data: datos,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 2,
                    borderRadius: 5,
                    hoverBackgroundColor: 'rgba(220, 53, 69, 0.9)'
                }]
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
                    y: {
                        beginAtZero: true,
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
        
        // Gráfico de sectores (pie chart)
        const ctxPie = document.getElementById('graficoSectores');
        
        const totalIngresos = {{ $totalIngresos }};
        const totalGastos = {{ $totalGastos }};
        
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['{{ __("Ingresos") }}', '{{ __("Gastos") }}'],
                datasets: [{
                    data: [totalIngresos, totalGastos],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(220, 53, 69, 0.8)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
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
