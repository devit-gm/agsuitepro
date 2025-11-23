<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Ficha') }} {{ $ficha->uuid }}</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ siteName() }}</h1>
        <h2>{{ __('Ficha') }} #{{ $ficha->uuid }}</h2>
    </div>

    <div class="info-section">
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">{{ __('Fecha') }}:</div>
                <div class="info-value">{{ $fechaCambiada }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('Hora') }}:</div>
                <div class="info-value">{{ $ficha->hora ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('Descripción') }}:</div>
                <div class="info-value">{{ $ficha->descripcion ?? __('Sin descripción') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('Tipo') }}:</div>
                <div class="info-value">
                    @if($ficha->tipo == 1) {{ __('Individual') }}
                    @elseif($ficha->tipo == 2) {{ __('Conjunta') }}
                    @elseif($ficha->tipo == 3) {{ __('Compra') }}
                    @elseif($ficha->tipo == 4) {{ __('Evento') }}
                    @endif
                </div>
            </div>
        </div>
            <div class="info-row">
                <div class="info-label">{{ __('Estado') }}:</div>
                <div class="info-value">{{ $ficha->estado == 0 ? __('Abierta') : __('Cerrada') }}</div>
            </div>
        </div>
    </div>

    @php
        $productos = \App\Models\FichaProducto::where('id_ficha', $ficha->uuid)->get();
        $totalProductos = 0;
    @endphp

    @if($productos->count() > 0)
    <h3 class="section-title">{{ __('Productos consumidos') }}</h3>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Producto') }}</th>
                <th class="text-center">{{ __('Cantidad') }}</th>
                <th class="text-right">{{ __('Precio') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            @php
                $prod = \App\Models\Producto::find($producto->id_producto);
                $totalProductos += $producto->precio;
            @endphp
            <tr>
                <td>{{ $prod->nombre ?? 'N/A' }}</td>
                <td class="text-center">{{ $producto->cantidad }}</td>
                <td class="text-right">{{ number_format($producto->precio, 2) }} €</td>
            </tr>
            @endforeach
            <tr style="border-top: 2px solid #dc3545; font-weight: bold;">
                <td colspan="2" class="text-right">{{ __('Subtotal productos') }}:</td>
                <td class="text-right">{{ number_format($totalProductos, 2) }} €</td>
            </tr>
        </tbody>
    </table>
    @endif

    @php
        $servicios = \App\Models\FichaServicio::where('id_ficha', $ficha->uuid)->get();
        $totalServicios = 0;
    @endphp

    @if($servicios->count() > 0)
    <h3 class="section-title">{{ __('Servicios') }}</h3>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Servicio') }}</th>
                <th class="text-right">{{ __('Precio') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicios as $servicio)
            @php
                $serv = \App\Models\Servicio::find($servicio->id_servicio);
                $totalServicios += $servicio->precio;
            @endphp
            <tr>
                <td>{{ $serv->nombre ?? 'N/A' }}</td>
                <td class="text-right">{{ number_format($servicio->precio, 2) }} €</td>
            </tr>
            @endforeach
            <tr style="border-top: 2px solid #dc3545; font-weight: bold;">
                <td class="text-right">{{ __('Subtotal servicios') }}:</td>
                <td class="text-right">{{ number_format($totalServicios, 2) }} €</td>
            </tr>
        </tbody>
    </table>
    @endif

    @php
        $gastos = \App\Models\FichaGasto::where('id_ficha', $ficha->uuid)->get();
        $totalGastos = 0;
    @endphp

    @if($gastos->count() > 0)
    <h3 class="section-title">{{ __('Gastos') }}</h3>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Gasto') }}</th>
                <th>{{ __('Usuario') }}</th>
                <th class="text-right">{{ __('Precio') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gastos as $gasto)
            @php
                $usuario = \App\Models\User::find($gasto->user_id);
                $totalGastos += $gasto->precio;
            @endphp
            <tr>
                <td>{{ $gasto->descripcion ?? __('Sin descripción') }}</td>
                <td>{{ $usuario->name ?? 'N/A' }}</td>
                <td class="text-right">{{ number_format($gasto->precio, 2) }} €</td>
            </tr>
            @endforeach
            <tr style="border-top: 2px solid #dc3545; font-weight: bold;">
                <td colspan="2" class="text-right">{{ __('Subtotal gastos') }}:</td>
                <td class="text-right">{{ number_format($totalGastos, 2) }} €</td>
            </tr>
        </tbody>
    </table>
    @endif

    @php
        $usuarios = \App\Models\FichaUsuario::where('id_ficha', $ficha->uuid)->get();
    @endphp

    @if($usuarios->count() > 0)
    <h3 class="section-title">{{ __('Usuarios participantes') }}</h3>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Usuario') }}</th>
                <th class="text-center">{{ __('Invitados') }}</th>
                <th class="text-center">{{ __('Niños') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuarioFicha)
            @php
                $user = \App\Models\User::find($usuarioFicha->user_id);
            @endphp
            <tr>
                <td>{{ $user->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $usuarioFicha->invitados }}</td>
                <td class="text-center">{{ $usuarioFicha->ninos ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="totals-box">
        <div class="total-row grand-total">
            <div class="total-label">{{ __('TOTAL') }}:</div>
            <div class="total-value">{{ number_format($ficha->precio, 2) }} €</div>
        </div>
    </div>

    <div class="footer">
        {{ siteName() }} - {{ __('Generado el') }} {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>