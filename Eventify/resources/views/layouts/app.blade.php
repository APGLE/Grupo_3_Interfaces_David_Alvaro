<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: rgb(250, 243, 228);
            margin: 0;
            padding: 0;
        }

        /* Estilo global para asegurar que la cabecera no se desborde */
        .navbar {
            background-color: rgb(108, 92, 57);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px; /* Definimos un max-width para que no se salga del contenedor */
            margin: 0 auto;
            padding: 0 20px; /* Aseguramos que haya padding a los lados */
        }

        .navbar-brand {
            color: rgb(250, 243, 228);
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-toggler {
            background-color: rgb(250, 243, 228);
        }

        .navbar-toggler-icon {
            background-color: rgb(108, 92, 57);
        }

        .navbar-nav .nav-item .nav-link {
            color: rgb(250, 243, 228);
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: rgb(108, 92, 57);
            background-color: rgb(250, 243, 228);
        }

        .navbar-nav .dropdown-menu {
            background-color: rgb(250, 243, 228);
        }

        .navbar-nav .dropdown-item:hover {
            background-color: rgb(108, 92, 57);
            color: rgb(250, 243, 228);
        }

        .navbar-nav .dropdown-item {
            color: rgb(108, 92, 57);
        }

        /* Ajustes para la navegación en pantallas pequeñas */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .navbar-brand {
                font-size: 20px;
            }

            .navbar-nav .nav-link {
                font-size: 14px;
            }
        }
    </style>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <!-- Aquí puedes agregar enlaces si los necesitas -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
