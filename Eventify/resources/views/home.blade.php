<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Bienvenido a la página web</h1>

        <!-- Verificar si el usuario tiene permiso de administrador -->
        @can('admin-access')
            <!-- Botón para abrir el offcanvas de configuración de administrador -->
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAdmin" aria-controls="offcanvasAdmin">
                <i class="bi bi-gear"></i> Configuración de Admin
            </button>

            <!-- Offcanvas de Administración de Usuarios -->
            <div class="offcanvas offcanvas-top offcanvas-fullscreen" tabindex="-1" id="offcanvasAdmin" aria-labelledby="offcanvasAdminLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasAdminLabel">Administración de Usuarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" style="overflow-y: auto;">
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
                            <!-- Iteración de usuarios y opciones de activación/desactivación -->
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->actived ? 'Activo' : 'Inactivo' }}</td>
                                    <td>
                                        @if($user->email_confirmed && !$user->actived)
                                            <form method="POST" action="{{ route('admin.users.activate', $user->id) }}">
                                                @csrf
                                                <button class="btn btn-success btn-sm" type="submit">Activar</button>
                                            </form>
                                        @endif
                                        @if($user->actived)
                                            <form method="POST" action="{{ route('admin.users.deactivate', $user->id) }}">
                                                @csrf
                                                <button class="btn btn-warning btn-sm" type="submit">Desactivar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>