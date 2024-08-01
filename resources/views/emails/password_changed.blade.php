<!DOCTYPE html>
<html>
<head>
    <title>Su contraseña ha sido cambiada</title>
</head>
<body>
    <h1>Hola, {{ $user->name }}</h1>
    <p>Su contraseña ha sido cambiada por un administrador. Su nueva contraseña es:</p>
    <p><strong>{{ $password }}</strong></p>
    <p>Le recomendamos que inicie sesión y cambie esta contraseña por una que usted elija.</p>
    <p>Gracias,</p>
    <p>El equipo de {{ config('app.name') }}</p>
</body>
</html>
