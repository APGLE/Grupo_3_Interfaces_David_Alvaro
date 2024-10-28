<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificación de correo electrónico</title>

    <style>
        .header-div {
            background-color: rgb(108, 92, 57);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            color: rgb(250, 243, 228);
            padding-right: 70px;
            padding-left: 70px;
        }

        .header-text {
            font-size: 42px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
        }

        .auth-buttons a {
            text-decoration: none;
            background-color: rgb(250, 243, 228);
            color: rgb(108, 92, 57);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s, color 0.3s;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-buttons a:hover {
            background-color: rgb(108, 92, 57);
            color: rgb(250, 243, 228);
        }

        body {
            margin: 0;
            padding: 0;
            background-color: rgb(250, 243, 228);
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: rgb(250, 243, 228);
            border: 1px solid rgba(108, 92, 57, 0.8); /* Borde más oscuro */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }

        .card-header {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-primary {
            background-color: rgb(108, 92, 57);
            color: rgb(250, 243, 228);
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-primary:hover {
            background-color: rgb(250, 243, 228);
            color: rgb(108, 92, 57);
        }

        .alert-success {
            background-color: rgb(204, 255, 204);
            color: rgb(34, 139, 34);
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="header-div">
        <p class="header-text">
            Verificación de correo electrónico
        </p>
        <div class="auth-buttons">
            <a href="/login">Iniciar sesión</a>
            <a href="/register">Registrar</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">Verifique su dirección de correo electrónico</div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="alert-success" role="alert">
                        Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.
                    </div>
                @endif

                <p>Antes de continuar, consulte su correo electrónico para obtener un enlace de verificación.</p>
                <p>Si no recibiste el correo electrónico,</p>

                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn-primary">Haz clic aquí para solicitar otro</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
