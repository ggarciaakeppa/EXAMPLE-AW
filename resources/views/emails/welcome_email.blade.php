<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Viadrop</title>
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
        <h1 class="title">Bienvenida</h1>
        <div class="logo">
            <img src="{{ url('/img/logos/logo.png') }}" alt="Logo de Viadrop" style="max-width: 50px; width: 100%; height: auto;">
        </div>
        <h2>Bienvenido a Viadrop</h2>
        <div class="message">
            <p>Hola {{ $user->name }},</p>
            <p>Nos complace darte la bienvenida a Viadrop, tu herramienta integral para la gestión y optimización de rutas. Con nuestra plataforma, podrás planificar, monitorear y mejorar la eficiencia de tus rutas en tiempo real. Gracias por confiar en nosotros para optimizar la logística de tu empresa.</p>
            <p>Para comenzar, utiliza la siguiente contraseña temporal para iniciar sesión:</p>
            <p><strong>Contraseña: {{ $generatedPassword }}</strong></p>
            <p>Te recomendamos cambiar esta contraseña después de tu primer acceso para garantizar la seguridad de tu cuenta.</p>
            <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos. Estamos aquí para asistirte.</p>
        </div>
        <div class="footer">
            <p>Gracias y bienvenido a Viadrop...</p>
            <p>Para ingresar al sistema, visita: <a href="{{ url('/') }}">Iniciar Sesión</a></p>
        </div>
    </div>
</body>
</html>
