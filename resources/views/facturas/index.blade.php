@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-10 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-receipt"></i> {{ __('Facturas Emitidas') }}
                </div>
                <div class="card-body overflow-auto flex-fill">

    <!-- Filtros -->
    <form id="form-filtro-fechas" method="GET" action="{{ route('facturas.index') }}" class="row g-3 mb-3">
        <div class="col-6">
            <label for="fecha_inicial" class="form-label small mb-1">{{ __('Fecha inicial') }}</label>
            <input type="date" class="form-control form-control-sm" id="fecha_inicial" name="fecha_inicial" value="{{ $fechaInicial }}" required>
        </div>
        <div class="col-6">
            <label for="fecha_final" class="form-label small mb-1">{{ __('Fecha final') }}</label>
            <input type="date" class="form-control form-control-sm" id="fecha_final" name="fecha_final" value="{{ $fechaFinal }}" required>
        </div>
    </form>

    <!-- Resumen -->
    <div class="row g-2 mb-3">
        <div class="col-6 col-md-3">
            <div class="alert alert-info mb-0 text-center">
                <small class="d-block text-muted">{{ __('Total Facturas') }}</small>
                <strong class="fs-5">{{ $totalFacturas }}</strong>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="alert alert-secondary mb-0 text-center">
                <small class="d-block text-muted">{{ __('Base Imponible') }}</small>
                <strong class="fs-5">{{ number_format($totalSubtotal, 2) }} €</strong>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="alert alert-warning mb-0 text-center">
                <small class="d-block text-muted">{{ __('Total IVA') }}</small>
                <strong class="fs-5">{{ number_format($totalIva, 2) }} €</strong>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="alert alert-success mb-0 text-center">
                <small class="d-block text-muted">{{ __('Total Importe') }}</small>
                <strong class="fs-5">{{ number_format($totalImporte, 2) }} €</strong>
            </div>
        </div>
    </div>

    <!-- Tabla de facturas -->
    <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 100px;">Nº</th>
                            <th style="width: 100px;">Fecha</th>
                            <th class="d-none d-md-table-cell">Mesa</th>
                            <th class="d-none d-md-table-cell">Camarero</th>
                            <th class="d-none d-lg-table-cell">Cliente</th>
                           
                            <th class="text-end d-none d-md-table-cell" style="width: 80px;">IVA</th>
                            <th class="text-end" style="width: 100px;">Total</th>
                            <th class="text-center" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facturas as $factura)
                        <tr>
                            <td>
                                <strong>{{ $factura->numero_factura }}</strong>
                            </td>
                            <td>
                                <small>{{ $factura->fecha->format('d/m/Y') }}</small>
                            </td>
                            <td class="d-none d-md-table-cell">
                                @if($factura->mesa)
                                    <small>Mesa {{ $factura->mesa->numero_mesa }}</small>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell">
                                @if($factura->camarero)
                                    <small>{{ $factura->camarero->name }}</small>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            <td class="d-none d-lg-table-cell">
                                @if($factura->cliente_nombre)
                                    <small>{{ $factura->cliente_nombre }}</small>
                                    @if($factura->cliente_nif)
                                        <br><small class="text-muted">{{ $factura->cliente_nif }}</small>
                                    @endif
                                @else
                                    <small class="text-muted">Cliente Final</small>
                                @endif
                            </td>
                            
                            <td class="text-end d-none d-md-table-cell">
                                <small class="text-warning">{{ number_format($factura->total_iva, 2) }} €</small>
                            </td>
                            <td class="text-end">
                                <strong>{{ number_format($factura->total, 2) }} €</strong>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-info" title="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                   
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="bi bi-inbox fa-3x text-muted mb-2"></i>
                                <p class="text-muted">No hay facturas en este período</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
    </div>

    <!-- Paginación -->
    @if($facturas->hasPages())
    <div class="mt-3">
        {{ $facturas->links() }}
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
    <div class="d-flex align-items-center justify-content-center">
        <button type="button" onclick="document.getElementById('form-filtro-fechas').submit();" class="btn btn-secondary mx-1">
            <i class="bi bi-search"></i>
        </button>
    </div>
</div>
@endsection
