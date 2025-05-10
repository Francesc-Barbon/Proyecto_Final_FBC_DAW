<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
<div class="container">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
    <h1>Bienvenido, {{ $user->name }}</h1>
    <p>Tu rol es: <strong>{{ $user->role }}</strong></p>

    @if ($user->role === 'admin')

            <a href="{{ route('jobs.index') }}" class="btn btn-info">Ver Trabajos</a>
            <a href="{{ route('users.index') }}" class="btn btn-primary">Administrar Usuarios</a>
            <a href="{{ route('users.create') }}" class="btn btn-success">Crear Usuario</a>
            <a href="{{ route('materials.index') }}" class="btn btn-warning">Gestionar Materiales</a>
    @endif

    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button class="btn btn-outline-danger">Cerrar sesión</button>
    </form>
</div>
</body>
</html>
