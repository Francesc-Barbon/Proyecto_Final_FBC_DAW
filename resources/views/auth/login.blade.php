<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Easy Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Rajdhani', sans-serif;
            background: url('/imagenes/hero_section.png') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 0;
        }

        .card {
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
        }

        .btn-custom {
            background-color: #FFD700;
            color: #000;
            font-weight: bold;
            border: 2px solid #000;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #000;
            color: #FFD700;
            border-color: #FFD700;
        }

        h3 {
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
<div class="overlay"></div>

<div class="card p-4 shadow w-100" style="max-width: 400px;">
    <h3 class="mb-4 text-center">Iniciar Sesión</h3>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="remember" id="remember">
            <label class="form-check-label" for="remember">Recordarme</label>
        </div>

        <button type="submit" class="btn btn-custom w-100">Iniciar Sesión</button>
    </form>
</div>
</body>
</html>
