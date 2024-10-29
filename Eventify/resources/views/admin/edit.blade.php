<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-div {
            background-color: rgb(108, 92, 57);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 70px;
            color: rgb(250, 243, 228);
        }

        .header-text {
            font-size: 36px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-custom {
            background-color: rgb(250, 243, 228);
            padding: 30px;
            border-radius: 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-label, .form-control {
            font-size: 16px;
        }

        .btn-primary, .btn-secondary {
            font-size: 16px;
            padding: 8px 20px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header-div">
        <p class="header-text">Editar Usuario</p>
    </div>

    <div class="container mt-5 container-custom">
        <h3 class="mb-4">Editar Información del Usuario</h3>
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Rol</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="u" {{ $user->role === 'u' ? 'selected' : '' }}>Usuario</option>
                    <option value="o" {{ $user->role === 'o' ? 'selected' : '' }}>Organizador</option>
                    <option value="a" {{ $user->role === 'a' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
