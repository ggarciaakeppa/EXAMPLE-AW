<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña Actualizada</title>
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
        .title {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Actualización contraseña</h1>
        <div class="logo">
            <img src="{{ url('/img/logos/mailLogo.png') }}" alt="Logo de Viadrop">
        </div>
        <h2>Contraseña Actualizada</h2>
        <div class="message">
            <p>Hola {{ $user->name }},</p>
            <p>Te informamos que tu contraseña ha sido actualizada exitosamente en Viadrop. Si no realizaste esta acción, por favor contáctanos de inmediato.</p>
            <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos. Estamos aquí para asistirte.</p>
        </div>
        <div class="footer">
            <p>Gracias por usar Viadrop.</p>
        </div>
    </div>
</body>
</html>
