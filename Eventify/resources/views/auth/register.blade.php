<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>

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

        /* Estilos del cuerpo y del formulario */
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
            height: 80vh;
        }

        .card {
            background-color: rgb(250, 243, 228);
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

        .form-control {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid rgb(108, 92, 57);
            border-radius: 5px;
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
    </style>
</head>
<body>

    <div class="header-div">
        <p class="header-text">Pagina de Registro</p>
        <div class="auth-buttons">
            <a href="/login">Iniciar sesión</a>
            <a href="/register">Registrar</a>
        </div>
    </div>


    <div class="container">
        <div class="card">
            <div class="card-header">Registro</div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <input id="name" type="text" class="form-control" name="name" placeholder="Nombre" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <input id="email" type="email" class="form-control" name="email" placeholder="Correo Electrónico" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Contraseña" required>

                <button type="submit" class="btn-primary">Registrar</button>
            </form>
        </div>
    </div>
</body>
</html>
