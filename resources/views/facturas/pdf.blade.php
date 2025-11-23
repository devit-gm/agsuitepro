<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $factura->numero_factura }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header-row {
            display: table;
            width: 100%;
        }
        
        .header-left, .header-right {
            display: table-cell;
            vertical-align: top;
        }
        
        .header-left {
            width: 50%;
        }
        
        .header-right {
            width: 50%;
            text-align: right;
        }
        
        .factura-title {
            font-size: 28pt;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .factura-numero {
            font-size: 14pt;
            color: #666;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 10pt;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 8px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .info-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 15px;
            background-color: #f8f9fa;
        }
        
        .info-col-left {
            border-right: 10px solid white;
        }
        
        .info-label {
            font-size: 9pt;
            color: #666;
            margin-bottom: 3px;
        }
        
        .info-value {
            font-size: 11pt;
            font-weight: bold;
        }
        
        .mesa-info {
            background-color: #e7f3ff;
            padding: 12px;
            margin-bottom: 25px;
            border-left: 4px solid #007bff;
        }
        
        .mesa-info-row {
            display: table;
            width: 100%;
        }
        
        .mesa-info-col {
            display: table-cell;
            width: 33.33%;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background-color: #007bff;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 10pt;
            font-weight: bold;
        }
        
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10pt;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8pt;
            background-color: #17a2b8;
            color: white;
            border-radius: 3px;
        }
        
        .desglose-table {
            width: 50%;
            margin-left: auto;
            margin-bottom: 20px;
        }
        
        .desglose-table th {
            background-color: #ffc107;
            color: #333;
        }
        
        .totales {
            width: 50%;
            margin-left: auto;
            border: 2px solid #28a745;
            padding: 15px;
            background-color: #f8f9fa;
        }
        
        .total-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        
        .total-label, .total-value {
            display: table-cell;
        }
        
        .total-label {
            width: 60%;
        }
        
        .total-value {
            width: 40%;
            text-align: right;
        }
        
        .total-final {
            border-top: 2px solid #28a745;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .total-final .total-label {
            font-size: 14pt;
            font-weight: bold;
        }
        
        .total-final .total-value {
            font-size: 16pt;
            font-weight: bold;
            color: #28a745;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 9pt;
            color: #666;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Cabecera -->
        <div class="header">
            <div class="header-row">
                <div class="header-left">
                    <div class="factura-title">FACTURA</div>
                    <div class="factura-numero">Nº {{ $factura->numero_factura }}</div>
                </div>
                <div class="header-right">
                    <div class="info-label">Fecha de emisión</div>
                    <div class="info-value">{{ $factura->fecha->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Datos emisor y cliente -->
        <div class="info-row">
            <div class="info-col info-col-left">
                <div class="section-title">DATOS DEL EMISOR</div>
                <div class="info-value">{{ config('app.name') }}</div>
                @if(isset($site))
                    <div>{{ $site->direccion ?? '' }}</div>
                    <div>CIF: {{ $site->cif ?? '' }}</div>
                    <div>Tel: {{ $site->telefono ?? '' }}</div>
                @endif
            </div>
            <div class="info-col">
                <div class="section-title">DATOS DEL CLIENTE</div>
                <div class="info-value">{{ $factura->cliente_nombre ?? 'Cliente Final' }}</div>
                @if($factura->cliente_nif)
                    <div>NIF/CIF: {{ $factura->cliente_nif }}</div>
                @endif
            </div>
        </div>

        <!-- Información de la mesa -->
        <div class="mesa-info">
            <div class="mesa-info-row">
                <div class="mesa-info-col">
                    <div class="info-label">Mesa</div>
                    <div class="info-value">Mesa {{ $factura->detalles['mesa_numero'] ?? ($factura->mesa ? $factura->mesa->numero_mesa : 'N/A') }}</div>
                </div>
                <div class="mesa-info-col">
                    <div class="info-label">Camarero</div>
                    <div class="info-value">{{ $factura->camarero ? $factura->camarero->name : 'Sin asignar' }}</div>
                </div>
                <div class="mesa-info-col">
                    <div class="info-label">Estado</div>
                    <div class="info-value">Pagado</div>
                </div>
            </div>
        </div>

        <!-- Tabla de líneas -->
        <div class="section">
            <div class="section-title">DETALLE DE LA FACTURA</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 35%;">Descripción</th>
                        <th class="text-center" style="width: 8%;">Cant.</th>
                        <th class="text-right" style="width: 12%;">Precio Unit.</th>
                        <th class="text-center" style="width: 8%;">IVA %</th>
                        <th class="text-right" style="width: 12%;">Base Imp.</th>
                        <th class="text-right" style="width: 12%;">Imp. IVA</th>
                        <th class="text-right" style="width: 13%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->detalles['lineas'] as $linea)
                    <tr>
                        <td>
                            {{ $linea['nombre'] }}
                            @if($linea['tipo'] === 'servicio')
                                <span class="badge">Servicio</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $linea['cantidad'] }}</td>
                        <td class="text-right">{{ number_format($linea['precio'], 2) }} €</td>
                        <td class="text-center">{{ number_format($linea['iva'], 0) }}%</td>
                        <td class="text-right">{{ number_format($linea['base_imponible'], 2) }} €</td>
                        <td class="text-right">{{ number_format($linea['importe_iva'], 2) }} €</td>
                        <td class="text-right"><strong>{{ number_format($linea['total'], 2) }} €</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Desglose IVA -->
        <div class="section">
            <div class="section-title">DESGLOSE DE IVA</div>
            <table class="desglose-table">
                <thead>
                    <tr>
                        <th>Tipo IVA</th>
                        <th class="text-right">Base Imponible</th>
                        <th class="text-right">Cuota IVA</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $ivaDesglose = $factura->getDesgloseIva();
                    @endphp
                    @foreach($ivaDesglose as $tipoIva => $datos)
                    <tr>
                        <td>IVA {{ number_format($datos['porcentaje'], 0) }}%</td>
                        <td class="text-right">{{ number_format($datos['base'], 2) }} €</td>
                        <td class="text-right">{{ number_format($datos['cuota'], 2) }} €</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totales finales -->
        <div class="totales">
            <div class="total-row">
                <div class="total-label">Base Imponible:</div>
                <div class="total-value">{{ number_format($factura->subtotal, 2) }} €</div>
            </div>
            <div class="total-row">
                <div class="total-label">Total IVA:</div>
                <div class="total-value">{{ number_format($factura->total_iva, 2) }} €</div>
            </div>
            <div class="total-row total-final">
                <div class="total-label">TOTAL A PAGAR:</div>
                <div class="total-value">{{ number_format($factura->total, 2) }} €</div>
            </div>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            <p>Factura generada el {{ now()->format('d/m/Y H:i') }}</p>
            <p>{{ config('app.name') }} - Gracias por su confianza</p>
        </div>
    </div>
</body>
</html>
