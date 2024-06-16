<!DOCTYPE html>
<html>

<head>
    <title>Licencia de Uso</title>
</head>

<body>
    <h1>Bienvenid@ {{ $name }}</h1>
    <p>Tu clave de licencia es: <strong>{{ $licenseKey }}</strong></p>
    <p>Accede con tu email y la contraseña proporcionada por tu administrador desde <a href="{{ route('login') }}">aquí</a> y actívala a continuación.</p>
    <p>Podrás modificar tu contraseña una vez dentro del sistema.</p>
</body>

</html>