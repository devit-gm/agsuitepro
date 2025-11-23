@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-10 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo">
                    <i class="bi bi-receipt-cutoff"></i> {{ __('FACTURA') }} {{ $factura->numero_factura }}
                </div>
                <div class="card-body overflow-auto flex-fill">
    <div class="row">
        <!-- Columna izquierda: Datos de la factura -->
        <div class="col-md-8">
            <!-- Encabezado -->
            <div class="mb-4">
                <div class="row">
                    <div class="col">
                        <h4 class="mb-0">FACTURA</h4>
                        <p class="mb-0">Nº {{ $factura->numero_factura }}</p>
                    </div>
                    <div class="col-auto text-end">
                        <small>Fecha de emisión</small>
                        <p class="mb-0"><strong>{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</strong></p>
                    </div>
                </div>
            </div>

            <div>
                    <div class="row mb-4">
                        <!-- Datos del emisor (empresa) -->
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted mb-2">Datos del Emisor</h6>
                            <p class="mb-1"><strong>{{ config('app.name') }}</strong></p>
                            @if(isset($site))
                                <p class="mb-1">{{ $site->direccion ?? '' }}</p>
                                <p class="mb-1">CIF: {{ $site->cif ?? '' }}</p>
                                <p class="mb-1">Tel: {{ $site->telefono ?? '' }}</p>
                            @endif
                        </div>

                        <!-- Datos del cliente -->
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted mb-2">Datos del Cliente</h6>
                            <p class="mb-1">
                                <strong>{{ $factura->cliente_nombre ?? 'Cliente Final' }}</strong>
                            </p>
                            @if($factura->cliente_nif)
                                <p class="mb-1">NIF/CIF: {{ $factura->cliente_nif }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Información de la mesa -->
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <small class="text-muted">Mesa</small>
                                <p class="mb-0"><strong>Mesa {{ $factura->detalles['mesa_numero'] ?? $factura->mesa->numero_mesa ?? 'N/A' }}</strong></p>
                            </div>
                            <div class="col-6 col-md-4">
                                <small class="text-muted">Camarero</small>
                                <p class="mb-0">{{ $factura->camarero->name ?? 'Sin asignar' }}</p>
                            </div>
                            <div class="col-6 col-md-4">
                                <small class="text-muted">Estado</small>
                                <p class="mb-0"><span class="badge bg-success">Pagado</span></p>
                            </div>
                        </div>
                    </div>

                <!-- Tabla de líneas de detalle -->
                <h5 class="mt-4 mb-3 border-bottom pb-2">Detalle de la Factura</h5>
                <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Descripción</th>
                                    <th class="text-center" style="width: 80px;">Cantidad</th>
                                    <th class="text-end" style="width: 100px;">Precio Unit.</th>
                                    
                                    <th class="text-end" style="width: 110px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($factura->detalles['lineas'] as $linea)
                                <tr>
                                    <td>
                                        {{ $linea['nombre'] }}
                                        @if($linea['tipo'] === 'servicio')
                                            <span class="badge bg-info">Servicio</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $linea['cantidad'] }}</td>
                                    <td class="text-end">{{ number_format($linea['precio'], 2) }} €</td>
                  
                                    <td class="text-end"><strong>{{ number_format($linea['total'], 2) }} €</strong></td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Columna derecha: Resumen y desglose -->
        <div class="col-md-4">
            <!-- Desglose de IVA -->
            <div class="mb-4">
                <h5 class="border-bottom pb-2">Desglose de IVA</h5>
                <div>
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th class="text-end">Base</th>
                                <th class="text-end">Cuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $ivaDesglose = $factura->getDesgloseIva();
                            @endphp
                            @foreach($ivaDesglose as $tipoIva => $datos)
                            <tr>
                                <td>IVA {{ number_format($datos['porcentaje'], 0) }}%</td>
                                <td class="text-end">{{ number_format($datos['base'], 2) }} €</td>
                                <td class="text-end">{{ number_format($datos['cuota'], 2) }} €</td>
                            </tr>
                            @endforeach
                            <tr class="table-light">
                                <td><strong>TOTAL</strong></td>
                                <td class="text-end"><strong>{{ number_format($factura->subtotal, 2) }} €</strong></td>
                                <td class="text-end"><strong>{{ number_format($factura->total_iva, 2) }} €</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totales -->
            <div class="mb-4">
                <h5 class="border-bottom pb-2">Resumen del Importe</h5>
                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Base Imponible:</span>
                        <strong>{{ number_format($factura->subtotal, 2) }} €</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="">Total IVA:</span>
                        <strong class="">{{ number_format($factura->total_iva, 2) }} €</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0">TOTAL A PAGAR:</h5>
                        <h4 class="mb-0 text-success">{{ number_format($factura->total, 2) }} €</h4>
                    </div>
                </div>
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
                <div class="card-footer" style="gap:12px">
                    <a href="{{ route('facturas.index') }}" class="btn btn-secondary">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                    <a href="{{ route('facturas.pdf', $factura->id) }}" class="btn btn-success" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </a>
                </div>
                @endsection

