<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Mensaje de contacto') }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h2 {
            font-weight: 600;
            font-size: 22px;
            margin: 0;
            color: #111;
        }
        .info p {
            margin: 8px 0;
            font-size: 14px;
        }
        .info strong {
            color: #555;
        }
        .mensaje {
            margin-top: 20px;
            font-size: 14px;
            line-height: 1.5;
            white-space: pre-wrap;
            color: #444;
        }
        hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ __('Nuevo mensaje de contacto') }}</h2>
        </div>
        <div class="info">
            <p><strong>{{ __('De') }}:</strong> {{ $usuario }} ({{ $email }})</p>
            <p><strong>{{ __('Asunto') }}:</strong> {{ $asunto }}</p>
        </div>
        <hr>
        <div class="mensaje">{{ $mensaje }}</div>
    </div>
</body>
</html>
