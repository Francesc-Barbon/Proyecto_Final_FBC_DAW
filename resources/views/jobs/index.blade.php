<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Trabajos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <style>
        .column {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            min-width: 200px;
        }
        .card {
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="p-5">
<div class="container">
    <h1>Dashboard de Trabajos</h1>

    <div class="row">
        <!-- Sin Empezar -->
        <div class="col-3">
            <h3>Sin Empezar</h3>
            <div id="sin_empezar" class="column" data-status="sin_empezar">
                @foreach ($jobs as $job)
                    @if($job->status == 'sin_empezar')
                        <div class="card" data-id="{{ $job->id }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $job->description }}</h5>
                                <p class="card-text">Estado: {{ $job->status }}</p>
                                <p class="card-text">Fecha de inicio: {{ $job->start_date }}</p>
                                <p class="card-text">Fecha de fin: {{ $job->end_date }}</p>

                                <!-- Botón para ir al Show del trabajo -->
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary">Ver Trabajo</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- En Curso -->
        <div class="col-3">
            <h3>En Curso</h3>
            <div id="en_curso" class="column" data-status="en_curso">
                @foreach ($jobs as $job)
                    @if($job->status == 'en_curso')
                        <div class="card" data-id="{{ $job->id }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $job->description }}</h5>
                                <p class="card-text">Estado: {{ $job->status }}</p>
                                <p class="card-text">Fecha de inicio: {{ $job->start_date }}</p>
                                <p class="card-text">Fecha de fin: {{ $job->end_date }}</p>

                                <!-- Botón para ir al Show del trabajo -->
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary">Ver Trabajo</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Finalizado -->
        <div class="col-3">
            <h3>Finalizado</h3>
            <div id="finalizado" class="column" data-status="finalizado">
                @foreach ($jobs as $job)
                    @if($job->status == 'finalizado')
                        <div class="card" data-id="{{ $job->id }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $job->description }}</h5>
                                <p class="card-text">Estado: {{ $job->status }}</p>
                                <p class="card-text">Fecha de inicio: {{ $job->start_date }}</p>
                                <p class="card-text">Fecha de fin: {{ $job->end_date }}</p>

                                <!-- Botón para ir al Show del trabajo -->
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary">Ver Trabajo</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateStatus = (id, status) => {
            fetch(`/jobs/${id}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        console.log("Error al actualizar el estado");
                        alert('Error al actualizar el estado');
                    }
                });
        };

        const columns = document.querySelectorAll('.column');
        columns.forEach(column => {
            new Sortable(column, {
                group: 'jobs',
                onEnd(evt) {
                    // Obtener el ID del trabajo desde el atributo data-id
                    const jobId = evt.item.getAttribute('data-id');

                    // Obtener el estado de la columna donde el item fue soltado
                    const status = evt.to.getAttribute('data-status');  // Usamos evt.to para obtener la columna de destino

                    // Mostrar por consola el ID del trabajo y el nuevo estado
                    console.log(`Trabajo con ID: ${jobId} ha sido movido a la columna de estado: ${status}`);

                    // Llamar a la función para actualizar el estado en el servidor
                    updateStatus(jobId, status);

                    // Actualiza el atributo data-status del trabajo (esto es necesario para no hacer la actualización repetida)
                    evt.item.setAttribute('data-status', status);
                }
            });
        });
    });
</script>



</body>
</html>
