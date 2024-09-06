<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu contraseña ha sido actualizada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: transparent;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            text-align: center;
        }
        .message {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
        .footer a {
            color: #333;
            text-decoration: none;
        }
        .title {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Restablecimiento de contraseña</h1>
        <div class="logo">
            <img src="{{ url('/img/logos/logo.png') }}" alt="Logo de la empresa" style="max-width: 50px; width: 100%; height: auto;">
        </div>
        <h2>Solicitud restablecimiento de contraseña</h2>
        <div class="message">
            <p>Hola {{ $user->name }},</p>
            <p>Hemos recibido una solicitud para restablecer tu contraseña.</p>
            <p>Para restablecer tu contraseña, por favor haz clic en el siguiente enlace:</p>
            <p><a href="{{ $resetPasswordUrl }}">Restablecer Contraseña</a></p>
            <p>Si no solicitaste este cambio, puedes ignorar este correo electrónico.</p>
            <p>¡Esperamos que disfrutes de nuestros servicios!</p>   
        </div>
        <div class="footer">
            <p>Gracias por utilizar ViaDrop.</p>
            <p>Para ingresar al sistema, visita: <a href="{{ url('/') }}">Iniciar Sesión</a></p>
        </div>
    </div>
</body>
</html>
