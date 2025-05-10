<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Home - Control de Materiales y Trabajos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&display=swap');

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Rajdhani', sans-serif;
        }

        .hero-section {
            background-image: url('/imagenes/hero_section.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .container-content {
            text-align: center;
            z-index: 2;
            color: #fff;
            padding: 0 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        h1 {
            font-weight: bold;
            font-size: 4rem;
            margin-bottom: 20px;
            color: #FFD700; /* amarillo */
        }

        p {
            font-size: 1.5rem;
            margin-bottom: 40px;
        }

        .btn-custom {
            background-color: #FFD700; /* amarillo */
            color: #000;
            font-weight: bold;
            font-size: 1.2rem;
            padding: 12px 30px;
            border: 2px solid #000;
            border-radius: 30px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: #000;
            color: #FFD700;
            border-color: #FFD700;
        }
    </style>
</head>

<body>

<section class="hero-section">
    <div class="overlay"></div>
    <div class="container-content">
        <h1>Easy Home</h1>
        <p>Gestión profesional de stock y trabajos para empresas de instalaciones eléctricas.</p>
        <a href="{{ route('login') }}" class="btn btn-custom">Iniciar sesión</a>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
