@extends('layouts.app')

@section('content')
    <div class="container mt-5 pt-5">
        <h1 class="mb-4">Dashboard de Trabajos</h1>

        <div class="row g-4">
            <!-- Sin Empezar -->
            <div class="col-12 col-md-4">
                <h3>Sin Empezar</h3>
                <div id="sin_empezar" class="column" data-status="sin_empezar">
                    @foreach ($jobs as $job)
                        @if($job->status == 'sin_empezar')
                            <div class="card" data-id="{{ $job->id }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $job->description }}</h5>
                                    <p class="card-text">Estado: {{ $job->status }}</p>
                                    <p class="card-text">Inicio: {{ $job->start_date }}</p>
                                    <p class="card-text">Fin: {{ $job->end_date }}</p>
                                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">Ver Trabajo</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- En Curso -->
            <div class="col-12 col-md-4">
                <h3>En Curso</h3>
                <div id="en_curso" class="column" data-status="en_curso">
                    @foreach ($jobs as $job)
                        @if($job->status == 'en_curso')
                            <div class="card" data-id="{{ $job->id }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $job->description }}</h5>
                                    <p class="card-text">Estado: {{ $job->status }}</p>
                                    <p class="card-text">Inicio: {{ $job->start_date }}</p>
                                    <p class="card-text">Fin: {{ $job->end_date }}</p>
                                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">Ver Trabajo</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Finalizado -->
            <div class="col-12 col-md-4">
                <h3>Finalizado</h3>
                <div id="finalizado" class="column" data-status="finalizado">
                    @foreach ($jobs as $job)
                        @if($job->status == 'finalizado')
                            <div class="card" data-id="{{ $job->id }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $job->description }}</h5>
                                    <p class="card-text">Estado: {{ $job->status }}</p>
                                    <p class="card-text">Inicio: {{ $job->start_date }}</p>
                                    <p class="card-text">Fin: {{ $job->end_date }}</p>
                                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">Ver Trabajo</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .column {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            min-height: 300px;
            background-color: #f8f9fa;
        }
        .card {
            margin-bottom: 10px;
            cursor: grab;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function initSortable() {
                document.querySelectorAll('.column').forEach(function (column) {
                    Sortable.create(column, {
                        group: 'jobs',
                        animation: 150,
                        onEnd: function (evt) {
                            const jobId = evt.item.getAttribute('data-id');
                            const status = evt.to.getAttribute('data-status');
                            updateStatus(jobId, status);
                            evt.item.setAttribute('data-status', status);
                        }
                    });
                });
            }

            function updateStatus(id, status) {
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
            }

            initSortable();
        });
    </script>

@endsection
