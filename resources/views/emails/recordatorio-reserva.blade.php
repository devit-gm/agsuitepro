<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            margin: -30px -30px 20px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .content {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-item {
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: bold;
            color: #667eea;
            display: inline-block;
            min-width: 120px;
        }
        .info-value {
            color: #333;
        }
        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px auto;
            text-align: center;
        }
        .time-highlight {
            font-size: 20px;
            font-weight: bold;
            color: #dc3545;
            text-align: center;
            padding: 15px;
            background: #ffe6e6;
            border-radius: 8px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">🔔</div>
            <h1>Recordatorio de Reserva</h1>
        </div>
        
        <div class="content">
            <p style="font-size: 16px; margin-bottom: 20px;">
                Hola <strong>{{ $nombre }}</strong>,
            </p>
            
            <div class="alert-box">
                <strong>⏰ Tienes una reserva próximamente</strong><br>
                Este es un recordatorio automático para que no olvides tu reserva.
            </div>

            <div class="time-highlight">
                📅 <strong>@if(isset($dias) && $dias == 1) Mañana @else En {{ $dias ?? 1 }} días @endif a las {{ $fecha_hora }}</strong>
            </div>
            
            <div style="margin: 25px 0;">
                <div class="info-item">
                    <span class="info-label">📅 Reserva:</span>
                    <span class="info-value">{{ $reserva_nombre }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">🕐 Fecha y Hora:</span>
                    <span class="info-value">{{ $fecha_hora }}</span>
                </div>
                
                @if($descripcion && $descripcion != 'Sin descripción')
                <div class="info-item">
                    <span class="info-label">📝 Descripción:</span>
                    <span class="info-value">{{ $descripcion }}</span>
                </div>
                @endif
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ config('app.url') }}/reservas" class="btn">
                    Ver Mis Reservas
                </a>
            </div>
            
            <div style="margin-top: 25px; padding: 15px; background: #e7f3ff; border-radius: 8px; font-size: 14px;">
                <strong>💡 Consejo:</strong> Te recomendamos llegar unos minutos antes para disfrutar plenamente de tu experiencia.
            </div>
        </div>
        
        <div class="footer">
            <p>
                Este es un correo automático, por favor no respondas a este mensaje.<br>
                <strong>{{ config('app.name') }}</strong><br>
                © {{ date('Y') }} Todos los derechos reservados
            </p>
        </div>
    </div>
</body>
</html>
