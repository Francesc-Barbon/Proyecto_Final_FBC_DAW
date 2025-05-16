<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Easy Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tipografía técnica --}}
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: #fdfdfd;
            color: #212529;
            padding-top: 70px;
        }

        .navbar {
            background-color: #000;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107;
        }

        .btn-primary, .btn-success, .btn-warning {
            border-radius: 8px;
        }

        footer {
            background-color: #f8f9fa;
            padding: 1rem;
            margin-top: 60px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
@stack('scripts')
<body>
{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('user.dashboard') }}">Easy Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    @if (auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('jobs.index') }}">Trabajos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.create') }}">Crear Usuario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('materials.index') }}">Materiales</a>
                        </li>
                    @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('jobs.index') }}">Trabajos</a>
                        </li>
                @endauth
            </ul>
            @auth
                <form class="d-flex" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-warning" type="submit">Cerrar sesión</button>
                </form>
            @endauth
        </div>
    </div>
</nav>


{{-- Contenido principal --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
<footer>
    <p class="mb-0">© {{ date('Y') }} Easy Home. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
