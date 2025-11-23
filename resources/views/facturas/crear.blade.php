@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-10 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-file-earmark-plus"></i> {{ __('Generar Factura') }}
                </div>
                <div class="card-body overflow-auto flex-fill">

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form id="form-crear-factura" method="POST" action="{{ route('facturas.store', $mesa->uuid) }}">
        @csrf
        
        <div class="row">
            <!-- Columna izquierda: Datos de la factura -->
            <div class="col-md-6">
                <!-- Datos de la Mesa -->
                <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-grid-3x3-gap"></i> {{ __('Datos de la Mesa') }}</h5>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label small text-muted">{{ __('Número de Mesa') }}</label>
                        <p class="mb-0"><strong class="fs-4">{{ $mesa->numero_mesa }}</strong></p>
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted">{{ __('Estado') }}</label>
                        <p class="mb-0">
                            <span class="badge bg-{{ $mesa->estado_mesa === 'cerrada' ? 'secondary' : 'warning' }}">
                                {{ ucfirst($mesa->estado_mesa) }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small text-muted">{{ __('Camarero') }}</label>
                    <p class="mb-0">{{ $mesa->camarero->name ?? 'Sin asignar' }}</p>
                </div>

                <!-- Datos del Cliente -->
                <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-person"></i> {{ __('Datos del Cliente') }}</h5>
                <div class="mb-3">
                    <label for="cliente_nombre" class="form-label">{{ __('Nombre/Razón Social') }}</label>
                    <input type="text" class="form-control" id="cliente_nombre" name="cliente_nombre" value="{{ old('cliente_nombre') }}" placeholder="{{ __('Cliente Final') }} ({{ __('opcional') }})">
                    <small class="text-muted">{{ __('Dejar en blanco para factura genérica') }}</small>
                </div>
                <div class="mb-3">
                    <label for="cliente_nif" class="form-label">{{ __('NIF/CIF') }}</label>
                    <input type="text" class="form-control" id="cliente_nif" name="cliente_nif" value="{{ old('cliente_nif') }}" placeholder="{{ __('Opcional') }}">
                </div>
            </div>

            <!-- Columna derecha: Preview de la factura -->
            <div class="col-md-6">
                <!-- Líneas de productos -->
                <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-receipt"></i> {{ __('Líneas de Detalle') }}</h5>
                <div class="table-responsive mb-3" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-sm">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>{{ __('Descripción') }}</th>
                                <th class="text-center">{{ __('Cant.') }}</th>
                                <th class="text-end">{{ __('Precio') }}</th>
                                <th class="text-center">{{ __('IVA') }}</th>
                                <th class="text-end">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lineas as $linea)
                            <tr>
                                <td>
                                    <small>
                                        <strong>{{ $linea['nombre'] }}</strong>
                                        @if($linea['tipo'] === 'servicio')
                                            <span class="badge bg-info">{{ __('Servicio') }}</span>
                                        @endif
                                    </small>
                                </td>
                                <td class="text-center">
                                    <small>{{ $linea['cantidad'] }}</small>
                                </td>
                                <td class="text-end">
                                    <small>{{ number_format($linea['precio'], 2) }} €</small>
                                </td>
                                <td class="text-center">
                                    <small>{{ number_format($linea['iva'], 0) }}%</small>
                                </td>
                                <td class="text-end">
                                    <small><strong>{{ number_format($linea['total'], 2) }} €</strong></small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Desglose IVA -->
                <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-calculator"></i> {{ __('Desglose de IVA') }}</h5>
                <table class="table table-sm mb-3">
                    <thead>
                        <tr>
                            <th>{{ __('Tipo IVA') }}</th>
                            <th class="text-end">{{ __('Base Imponible') }}</th>
                            <th class="text-end">{{ __('Cuota IVA') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ivaDesglose as $tipoIva => $datos)
                        <tr>
                            <td><small>IVA {{ number_format($datos['porcentaje'], 0) }}%</small></td>
                            <td class="text-end"><small>{{ number_format($datos['base'], 2) }} €</small></td>
                            <td class="text-end"><small>{{ number_format($datos['cuota'], 2) }} €</small></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totales -->
                <div class="border-top pt-3">
                    <div class="row mb-2">
                        <div class="col-6">
                            <strong>{{ __('Base Imponible') }}:</strong>
                        </div>
                        <div class="col-6 text-end">
                            <strong>{{ number_format($subtotal, 2) }} €</strong>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <strong class="">{{ __('Total IVA') }}:</strong>
                        </div>
                        <div class="col-6 text-end">
                            <strong class="">{{ number_format($totalIva, 2) }} €</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h5 class="mb-0">{{ __('TOTAL') }}:</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="mb-0 text-success">{{ number_format($total, 2) }} €</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<div class="card-footer">
    <div class="d-flex justify-content-between">
        <a href="{{ route('mesas.index') }}" class="btn btn-secondary">
            <i class="bi bi-chevron-left"></i>
        </a>
        <button type="submit" form="form-crear-factura" class="btn btn-success btn-lg">
            <i class="bi bi-floppy"></i> 
        </button>
    </div>
</div>
@endsection
