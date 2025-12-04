<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Albarán {{ $albaran->numero_albaran }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 20px;
        }
        h1 {
            font-size: 20px;
            margin-bottom: 5px;
            color: #dc3545;
        }
        h3 {
            font-size: 13px;
            margin-bottom: 8px;
            color: #dc3545;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .info-section {
            margin-bottom: 15px;
        }
        .info-box {
            width: 48%;
            float: left;
            padding: 10px;
            border: 1px solid #ddd;
            margin-right: 2%;
            min-height: 100px;
        }
        .info-box:nth-child(2) {
            margin-right: 0;
        }
        .clear {
            clear: both;
        }
        p {
            margin: 3px 0;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        thead {
            background-color: #dc3545;
            color: white;
        }
        th {
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            font-size: 10px;
            border: 1px solid #ddd;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #666;
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ALBARÁN DE ENTRADA</h1>
        <p><strong>Número:</strong> {{ $albaran->numero_albaran }} | 
        <strong>Estado:</strong> 
        @if($albaran->estado == 'recibido')
            <span class="badge badge-success">RECIBIDO</span>
        @else
            {{ strtoupper($albaran->estado) }}
        @endif
        </p>
    </div>

    <div class="info-section">
        <div class="info-box">
            <h3>PROVEEDOR</h3>
            <p><strong>Nombre:</strong> {{ $albaran->proveedor }}</p>
            @if($albaran->nif)
            <p><strong>NIF/CIF:</strong> {{ $albaran->nif }}</p>
            @endif
            @if($albaran->contacto)
            <p><strong>Contacto:</strong> {{ $albaran->contacto }}</p>
            @endif
        </div>
        <div class="info-box">
            <h3>DATOS DEL ALBARÁN</h3>
            <p><strong>Fecha Albarán:</strong> {{ $albaran->fecha->format('d/m/Y') }}</p>
            <p><strong>Creado por:</strong> {{ $albaran->usuario->name ?? 'N/A' }}</p>
            @if($albaran->fecha_recepcion)
            <p><strong>Fecha Recepción:</strong> {{ $albaran->fecha_recepcion->format('d/m/Y H:i') }}</p>
            @endif
            <p><strong>Fecha Impresión:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        <div class="clear"></div>
    </div>

    @if($albaran->observaciones)
    <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 15px;">
        <h3>OBSERVACIONES</h3>
        <p>{{ $albaran->observaciones }}</p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 50%;">PRODUCTO</th>
                <th class="text-center" style="width: 15%;">CANTIDAD</th>
                <th class="text-right" style="width: 17%;">PRECIO COSTE</th>
                <th class="text-right" style="width: 18%;">SUBTOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($albaran->lineas as $linea)
            <tr>
                <td>{{ $linea->producto->nombre ?? 'Producto eliminado' }}
                @if($linea->producto && $linea->producto->familiaObj)
                <br><small style="color: #666;">{{ $linea->producto->familiaObj->nombre }}</small>
                @endif
                </td>
                <td class="text-center">{{ number_format($linea->cantidad, 2, ',', '.') }}</td>
                <td class="text-right">{{ number_format($linea->precio_coste, 2, ',', '.') }} €</td>
                <td class="text-right">{{ number_format($linea->subtotal, 2, ',', '.') }} €</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" class="text-right"><strong>TOTAL:</strong></td>
                <td class="text-right"><strong>{{ number_format($albaran->total, 2, ',', '.') }} €</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Documento generado automáticamente por {{ config('app.name') }} - {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
