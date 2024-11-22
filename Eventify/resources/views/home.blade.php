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

        .config-button, .logout-button {
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

        .config-button:hover, .logout-button:hover {
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

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: rgb(250, 243, 228);

        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .card img {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 180px;
            object-fit: cover;
        }

        .card-title {
            font-weight: bold;
            color: rgb(108, 92, 57);
        }

        .action-buttons {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 5px;
            
        }

        .action-buttons .btn {
            border-radius: 50%;
            padding: 8px;
            
        }

        .event-card-body {
            position: relative;
            padding-top: 15px;
        }

.custom-navbar {
    background-color: rgb(108, 92, 57);
    border-radius: 8px; 
    display: inline-block; 
    padding: 8px 15px; 
    margin-left: 31px;
}


.custom-navbar .nav-link {
    color: white;
}


.custom-dropdown {
    background-color: rgb(255, 255, 255);
    border-radius: 8px;
    border: none;
    min-width: 100px;
}

.custom-dropdown .dropdown-item {
    color: black;
    padding: 10px 20px;
}


.custom-dropdown .dropdown-item:hover {
    background-color: rgb(108, 92, 57);
    color: white;
    border-radius: 8px;
}

.div-navbar{
    display: flex;
    align-items: center;
    justify-content: end;
    margin: 30px;
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

        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="logout-button">Cerrar sesión</button>
        </form>
    </div>
    
    <form action="{{ url('/events/create') }}" method="GET" style="display: inline;">
        <div style="margin:30px">
            <button type="submit" style="border-radius:10px;padding:10px;background-color:rgb(108, 92, 57);color:rgb(250, 243, 228);width:100%">
                Crear evento
            </button>
        </div>
    </form>

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
                                    @if ($user->email_confirmed && !$user->actived)
                                        <form method="POST" action="{{ route('admin.users.activate', $user->id) }}" style="display:inline;">
                                            @csrf
                                            <button class="btn btn-success btn-sm" type="submit">Activar</button>
                                        </form>
                                    @endif
                                    @if ($user->actived)
                                        <form method="POST" action="{{ route('admin.users.deactivate', $user->id) }}" style="display:inline;">
                                            @csrf
                                            <button class="btn btn-warning btn-sm" type="submit">Desactivar</button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm">Editar</a>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display:inline;">
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

    <nav class="navbar navbar-expand-lg custom-navbar">
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tipos
                </a>
                <div class="dropdown-menu custom-dropdown">
                    <a class="dropdown-item" href="{{ route('musica') }}">Música</a>
                    <a class="dropdown-item" href="{{ route('deporte') }}">Deporte</a>
                    <a class="dropdown-item" href="{{ route('tecnologia') }}">Tecnología</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="eventDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Eventos
                </a>
                <div class="dropdown-menu custom-dropdown">
                    <a class="dropdown-item" href="{{ route('Registrados') }}">Registrados</a>
                    <a class="dropdown-item" href="{{ route('Noregistrados') }}">No registrados</a>
                </div>
            </li>

        </ul>
    </div>
</nav>

<div class="container mt-4">

    @if ($events->isEmpty())
        <div class="alert alert-warning">
            No hay eventos en esta categoría.
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>




<div class="container mt-4">
    <div class="row">
        @foreach($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($event->image_url)
                    <img src="{{ asset('images/' . $event->image_url) }}" class="card-img-top" alt="Imagen del Evento">

                    @endif

                    <div class="event-card-body card-body">
                    <div class="action-buttons">
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm" style="background-color: rgb(108, 92, 57); color:white">
                                Editar
                            </a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Borrar
                                </button>
                            </form>
                        </div>
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text">{{ $event->description }}</p>

                        <ul class="list-unstyled">
                            <li><strong>Ubicación:</strong> {{ $event->location }}</li>
                            <li><strong>Inicio:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, h:i A') }}</li>
                            <li><strong>Fin:</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('d M Y, h:i A') }}</li>
                            <li><strong>Precio:</strong> ${{ number_format($event->price, 2) }}</li>
                            <li><strong>Capacidad Máxima:</strong> {{ $event->max_attendees }}</li>
                        </ul>

                        @if(Auth::check())
                            @php
                                $attendee = DB::table('event_attendees')
                                    ->where('event_id', $event->id)
                                    ->where('user_id', auth()->user()->id)
                                    ->where('deleted', 0)
                                    ->first();
                            @endphp

                            @if($attendee)
                                <form action="{{ route('events.unsubscribe', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        Desapuntarse
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('events.subscribe', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Apuntarse
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>


<div style="margin:30px">
    <form action="{{ route('enviar.pdf') }}" method="POST">
        @csrf
        <button type="submit" style="border-radius:10px;padding:10px;background-color:rgb(108, 92, 57);color:rgb(250, 243, 228);width:100%">
            Exportar y enviar por mail (PDF)
        </button>
    </form>
</div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
