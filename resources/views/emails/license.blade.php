<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Licencia de Uso') }}</title>
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
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        h1 {
            font-weight: 600;
            font-size: 22px;
            margin-bottom: 20px;
            color: #111;
        }
        p {
            font-size: 14px;
            line-height: 1.5;
            margin: 12px 0;
        }
        strong {
            color: #111;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ __('Bienvenid@') }} {{ $name }}</h1>
        <p>{{ __('Tu clave de licencia es:') }} <strong>{{ $licenseKey }}</strong></p>
        <p>{{ __('Accede con tu email y la contraseña proporcionada por tu administrador desde') }} <a href="{{ route('login') }}">{{ __('aquí') }}</a> {{ __('y actívala a continuación.') }}</p>
        <p>{{ __('Podrás modificar tu contraseña una vez dentro del sistema.') }}</p>
    </div>
</body>
</html>
