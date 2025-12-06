<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket - Mesa {{ $mesa->numero_mesa }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            max-width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            margin: 2px 0;
        }
        
        .info-section {
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        
        .info-label {
            font-weight: bold;
        }
        
        .items-section {
            margin-bottom: 15px;
        }
        
        .item {
            margin: 5px 0;
        }
        
        .item-header {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
        
        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            padding-left: 10px;
        }
        
        .separator {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }
        
        .totals-section {
            margin-top: 15px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        
        .total-row.grand-total {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #000;
        }
        
        .iva-desglose {
            margin: 10px 0;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px dashed #000;
            font-size: 11px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            background-color: #FFF;
            color: #0c0c0c;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .print-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Imprimir</button>
    
    <div class="header">
        <h1>{{ $ajustes->nombre_sitio ?? $site->titulo ?? 'TICKET' }}</h1>
        @if($ajustes->direccion)
            <p>{{ $ajustes->direccion }}</p>
        @endif
        @if($ajustes->telefono)
            <p>Tel: {{ $ajustes->telefono }}</p>
        @endif
        @if($ajustes->cif)
            <p>CIF: {{ $ajustes->cif }}</p>
        @endif
    </div>
    
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">MESA:</span>
            <span>{{ $mesa->numero_mesa }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">FECHA:</span>
            <span>{{ $mesa->hora_cierre ? $mesa->hora_cierre->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span>
        </div>
        @if($mesa->camarero)
        <div class="info-row">
            <span class="info-label">CAMARERO:</span>
            <span>{{ $mesa->camarero->name }}</span>
        </div>
        @endif
        @if($mesa->numero_comensales)
        <div class="info-row">
            <span class="info-label">COMENSALES:</span>
            <span>{{ $mesa->numero_comensales }}</span>
        </div>
        @endif
    </div>
    
    <div class="items-section">
        @foreach($lineas as $linea)
        <div class="item">
            <div class="item-header">
                <span>{{ $linea['nombre'] }}</span>
                <span>{{ number_format($linea['total'], 2, ',', '.') }} €</span>
            </div>
            <div class="item-detail">
                <span>{{ $linea['cantidad'] }} x {{ number_format($linea['precio_unitario'], 2, ',', '.') }} €</span>
                <span>(IVA {{ number_format($linea['iva'], 0) }}%)</span>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="separator"></div>
    
    <div class="totals-section">
        <div class="total-row">
            <span>Subtotal (Base):</span>
            <span>{{ number_format($subtotal, 2, ',', '.') }} €</span>
        </div>
        <div class="total-row">
            <span>IVA:</span>
            <span>{{ number_format($totalIva, 2, ',', '.') }} €</span>
        </div>
        <div class="total-row grand-total">
            <span>TOTAL:</span>
            <span>{{ number_format($total, 2, ',', '.') }} €</span>
        </div>
    </div>
    
    @if(count($ivaDesglose) > 0)
    <div class="iva-desglose">
        <p style="font-weight: bold; margin-bottom: 5px;">Desglose IVA:</p>
        @foreach($ivaDesglose as $iva)
        <div class="total-row" style="font-size: 10px;">
            <span>IVA {{ number_format($iva['porcentaje'], 0) }}%: Base {{ number_format($iva['base'], 2, ',', '.') }} €</span>
            <span>{{ number_format($iva['cuota'], 2, ',', '.') }} €</span>
        </div>
        @endforeach
    </div>
    @endif
    
    <div class="footer">
        <p>¡GRACIAS POR SU VISITA!</p>
        <p>Este documento no tiene validez fiscal</p>
        <p style="margin-top: 5px; font-size: 10px;">{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <script>
        // Auto-imprimir al cargar la página (opcional)
        // window.onload = function() { window.print(); };
    </script>
</body>
</html>
