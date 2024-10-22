<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

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
        }
    </style>
</head>
<body>
    <div class="header-div">
        <p class="header-text">
            Bienvenido a la página web
        </p>
        <div class="auth-buttons">
            <a href="{{ route('login') }}">Iniciar sesion</a>
            <a href="{{ route('register') }}">Registrar</a>
        </div>
    </div>
    
    <div class="content">
    </div>
</body>
</html>
