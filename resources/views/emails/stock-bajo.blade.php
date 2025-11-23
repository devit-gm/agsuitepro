<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta de Stock Bajo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: #dc3545;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
        .stock-bajo {
            color: #dc3545;
            font-weight: bold;
            font-size: 18px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ Alerta de Stock Bajo</h1>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <strong>¡Atención!</strong> Se ha detectado que un producto tiene stock por debajo del nivel mínimo establecido.
            </div>

            <div class="info-row">
                <span class="label">Producto:</span>
                <span class="value">{{ $producto_nombre }}</span>
            </div>

            <div class="info-row">
                <span class="label">Familia:</span>
                <span class="value">{{ $familia }}</span>
            </div>

            <div class="info-row">
                <span class="label">Stock actual:</span>
                <span class="value stock-bajo">{{ $stock_actual }} unidades</span>
            </div>

            <div class="info-row">
                <span class="label">Stock mínimo:</span>
                <span class="value">{{ $stock_minimo }} unidades</span>
            </div>

            <div class="info-row">
                <span class="label">Establecimiento:</span>
                <span class="value">{{ $site_nombre }}</span>
            </div>

            <p style="margin-top: 20px;">
                Se recomienda realizar un pedido de reposición lo antes posible para evitar quedarse sin existencias.
            </p>

            <center>
                <a href="{{ route('productos.inventory') }}" class="button">
                    Ver Inventario Completo
                </a>
            </center>
        </div>

        <div class="footer">
            <p>Este es un mensaje automático del sistema {{ $site_nombre }}</p>
            <p>Por favor, no responda a este correo</p>
        </div>
    </div>
</body>
</html>
