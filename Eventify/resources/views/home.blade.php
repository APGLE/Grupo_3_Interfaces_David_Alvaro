<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Página con Offcanvas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-div {
            background-color: rgb(108, 92, 57);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 70px;
            color: rgb(250, 243, 228);
        }
        .header-text {
            font-size: 42px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .settings-icon {
            font-size: 24px;
            cursor: pointer;
            color: rgb(250, 243, 228);
            transition: color 0.3s;
        }

        .settings-icon:hover {
            color: rgb(200, 180, 150);
        }
        .offcanvas-custom{
            width: 50% !important;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: rgb(250, 243, 228);
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body>
    <div class="header-div">
        <p class="header-text">
            Bienvenido a la página web
        </p>
        <div class="settings-icon" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSettings" aria-controls="offcanvasSettings">
            &#9881; <!-- Unicode para el icono de una rueda dentada -->
        </div>
    </div>
    
    <div class="offcanvas offcanvas-end offcanvas-custom" tabindex="-1" id="offcanvasSettings" aria-labelledby="offcanvasSettingsLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasSettingsLabel">Configuración</h5>
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
                        <!-- Ejemplo de usuarios estáticos -->
                        <tr>
                            <td>Juan Pérez</td>
                            <td>juan.perez@example.com</td>
                            <td>Activo</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Desactivar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Ana Gómez</td>
                            <td>ana.gomez@example.com</td>
                            <td>Inactivo</td>
                            <td>
                                <button class="btn btn-success btn-sm">Activar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Carlos Ruiz</td>
                            <td>carlos.ruiz@example.com</td>
                            <td>Inactivo</td>
                            <td>
                                <button class="btn btn-success btn-sm">Activar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Laura García</td>
                            <td>laura.garcia@example.com</td>
                            <td>Activo</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Desactivar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>