<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesa {{ $ficha->numero_mesa }} - {{ siteName() }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #dc3545;
        }
        
        .header h1 {
            font-size: 24pt;
            color: #dc3545;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 16pt;
            color: #666;
            font-weight: normal;
        }
        
        .info-section {
            background-color: #f8f9fa;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border-left: 4px solid #dc3545;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 5px 10px 5px 0;
            width: 30%;
        }
        
        .info-value {
            display: table-cell;
            padding: 5px 0;
        }
        
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #dc3545;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #dc3545;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th {
            background-color: #dc3545;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10pt;
        }
        
        .table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10pt;
        }
        
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .table .text-right {
            text-align: right;
        }
        
        .table .text-center {
            text-align: center;
        }
        
        .totals-box {
            background-color: #f8f9fa;
            border: 2px solid #dc3545;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }
        
        .total-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        
        .total-label {
            display: table-cell;
            font-weight: bold;
            font-size: 12pt;
            width: 70%;
            text-align: right;
            padding-right: 20px;
        }
        
        .total-value {
            display: table-cell;
            font-size: 12pt;
            text-align: right;
        }
        
        .grand-total {
            border-top: 2px solid #dc3545;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .grand-total .total-label,
        .grand-total .total-value {
            font-size: 16pt;
            font-weight: bold;
            color: #dc3545;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
        }
        
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ siteName() }}</h1>
        <h2>Ticket Mesa {{ $ficha->numero_mesa }}</h2>
    </div>

    <!-- Información de la mesa -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Número de Mesa:</div>
                <div class="info-value"><strong>{{ $ficha->numero_mesa }}</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Camarero:</div>
                <div class="info-value">{{ $ficha->camarero->name ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Comensales:</div>
                <div class="info-value">{{ $ficha->numero_comensales }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Fecha:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($ficha->fecha)->format('d/m/Y') }}</div>
            </div>
            @if($ficha->hora_apertura)
            <div class="info-row">
                <div class="info-label">Hora Apertura:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($ficha->hora_apertura)->format('H:i') }}</div>
            </div>
            @endif
            @if($ficha->hora_cierre)
            <div class="info-row">
                <div class="info-label">Hora Cierre:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($ficha->hora_cierre)->format('H:i') }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Productos consumidos -->
    @if($ficha->productos && $ficha->productos->count() > 0)
    <div class="section-title">Consumos</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 10%;">Cant.</th>
                <th style="width: 55%;">Producto</th>
                <th style="width: 15%;" class="text-right">P. Unit.</th>
                <th style="width: 20%;" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $productosAgrupados = $ficha->productos->groupBy('id_producto');
                $totalProductos = 0;
            @endphp
            @foreach($productosAgrupados as $idProducto => $items)
                @php
                    $producto = $items->first()->producto;
                    $cantidad = $items->count();
                    $precioUnitario = $producto ? $producto->precio : 0;
                    $subtotal = $precioUnitario * $cantidad;
                    $totalProductos += $subtotal;
                @endphp
                <tr>
                    <td class="text-center">{{ $cantidad }}</td>
                    <td>{{ $producto ? $producto->nombre : 'Producto no disponible' }}</td>
                    <td class="text-right">{{ number_format($precioUnitario, 2, ',', '.') }} €</td>
                    <td class="text-right"><strong>{{ number_format($subtotal, 2, ',', '.') }} €</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Servicios -->
    @if($ficha->servicios && $ficha->servicios->count() > 0)
    <div class="section-title">Servicios Adicionales</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 70%;">Servicio</th>
                <th style="width: 30%;" class="text-right">Importe</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalServicios = 0;
            @endphp
            @foreach($ficha->servicios as $fichaServicio)
                @php
                    $totalServicios += $fichaServicio->servicio ? $fichaServicio->servicio->precio : 0;
                @endphp
                <tr>
                    <td>{{ $fichaServicio->servicio ? $fichaServicio->servicio->nombre : 'Servicio no disponible' }}</td>
                    <td class="text-right"><strong>{{ number_format($fichaServicio->servicio ? $fichaServicio->servicio->precio : 0, 2, ',', '.') }} €</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Totales -->
    <div class="totals-box">
        @php
            $subtotal = ($totalProductos ?? 0) + ($totalServicios ?? 0);
            $propina = 0; // Puedes agregar lógica para propinas si es necesario
            $total = $subtotal + $propina;
        @endphp
        
        <div class="total-row">
            <div class="total-label">Subtotal Consumos:</div>
            <div class="total-value">{{ number_format($totalProductos ?? 0, 2, ',', '.') }} €</div>
        </div>
        
        @if(isset($totalServicios) && $totalServicios > 0)
        <div class="total-row">
            <div class="total-label">Servicios:</div>
            <div class="total-value">{{ number_format($totalServicios, 2, ',', '.') }} €</div>
        </div>
        @endif
        
        @if($propina > 0)
        <div class="total-row">
            <div class="total-label">Propina:</div>
            <div class="total-value">{{ number_format($propina, 2, ',', '.') }} €</div>
        </div>
        @endif
        
        <div class="total-row grand-total">
            <div class="total-label">TOTAL:</div>
            <div class="total-value">{{ number_format($total, 2, ',', '.') }} €</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>{{ siteName() }}</strong></p>
        <p>Documento generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p>Gracias por su visita</p>
    </div>
</body>
</html>
