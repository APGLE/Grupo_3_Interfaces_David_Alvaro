<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        .config-button {
            font-size: 18px;
            background-color: rgb(250, 243, 228);
            color: rgb(108, 92, 57);
            padding: 8px 15px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        .config-button:hover {
            background-color: rgb(108, 92, 57);
            color: rgb(250, 243, 228);
        }

        .offcanvas-top-custom {
            height: 80vh;
        }

        .offcanvas-header {
            background-color: rgb(108, 92, 57);
            color: rgb(250, 243, 228);
        }

        .offcanvas-body {
            background-color: rgb(250, 243, 228);
            padding: 20px;
        }

        .table {
            background-color: rgb(250, 243, 228);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .btn-success,
        .btn-warning,
        .btn-info,
        .btn-danger {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .btn-close {
            color: rgb(250, 243, 228);
        }
    </style>
</head>




<body>
    <div class="header-div">
        <p class="header-text">Bienvenido a la página web</p>
        @can('admin-access')
            <button class="config-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAdmin"
                aria-controls="offcanvasAdmin">
                <i class="bi bi-gear"></i> Configuración de Admin
            </button>
        @endcan
    </div>

    @can('admin-access')
        <div class="offcanvas offcanvas-top offcanvas-top-custom" tabindex="-1" id="offcanvasAdmin"
            aria-labelledby="offcanvasAdminLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAdminLabel">Administración de Usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->actived ? 'Activo' : 'Inactivo' }}</td>
                                <td>
                                    <!-- Activar/Desactivar -->
                                    @if ($user->email_confirmed && !$user->actived)
                                        <form method="POST" action="{{ route('admin.users.activate', $user->id) }}"
                                            style="display:inline;">
                                            @csrf
                                            <button class="btn btn-success btn-sm" type="submit">Activar</button>
                                        </form>
                                    @endif
                                    @if ($user->actived)
                                        <form method="POST" action="{{ route('admin.users.deactivate', $user->id) }}"
                                            style="display:inline;">
                                            @csrf
                                            <button class="btn btn-warning btn-sm" type="submit">Desactivar</button>
                                        </form>
                                    @endif

                                    <!-- Editar -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-info btn-sm">Editar</a>

                                    <!-- Eliminar -->
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endcan


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
