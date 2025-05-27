@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detalles del Trabajo</h2>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Descripción: {{ $job->description }}</h5>
                <p><strong>Fecha de Inicio:</strong> {{ $job->start_date }}</p>
                <p><strong>Fecha de Fin:</strong> {{ $job->end_date ?? 'No especificada' }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($job->status) }}</p>
                <p><strong>Responsable:</strong> {{ $job->user->name }}</p>
            </div>
        </div>
        @error('quantity')
        <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
        {{-- Pestañas (Tabs) --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="materials-tab" data-bs-toggle="tab" href="#materials" role="tab" aria-controls="materials" aria-selected="true">Materiales Asignados</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="hours-tab" data-bs-toggle="tab" href="#hours" role="tab" aria-controls="hours" aria-selected="false">Horas de Trabajo</a>
            </li>
        </ul>

        <div class="tab-content mt-4" id="myTabContent">
            {{-- Materiales Tab --}}
            <div class="tab-pane fade show active" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                <h3>Materiales Asignados</h3>
                @if ($stockMovements->isEmpty())
                    <p>No hay materiales asignados a este trabajo.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Material</th>
                            <th>Cantidad</th>
                            <th>Tipo de Movimiento</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($stockMovements as $movement)
                            <tr>
                                <td>{{ $movement->material->name }}</td>
                                <td>{{ $movement->quantity }}</td>
                                <td>{{ ucfirst($movement->movement_type) }}</td>
                                <td>{{ $movement->date }}</td>
                                <td>{{ $movement->user->name }}</td>
                                <td>
                                    <!-- Botón para abrir modal -->
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal-{{ $movement->id }}">
                                        ✏️ Editar
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="editModal-{{ $movement->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $movement->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('jobs.updateMaterial', ['job' => $job->id, 'movement' => $movement->id]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel-{{ $movement->id }}">Editar Cantidad</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="quantity" class="form-label">Cantidad</label>
                                                            <input type="number" class="form-control" name="quantity" value="{{ $movement->quantity }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif

                <h3 class="mt-4">Agregar Material al Trabajo</h3>
                <form action="{{ route('jobs.addMaterial', $job->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="material_id" class="form-label">Seleccionar Material</label>
                        <select class="form-control" id="material_id" name="material_id" required>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" data-quantity="{{ $material->quantity }}">
                                    {{ $material->name }} - {{ $material->quantity }} disponible
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantidad a Asignar</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Añadir Material</button>
                </form>
            </div>

            {{-- Horas Tab --}}
            <div class="tab-pane fade" id="hours" role="tabpanel" aria-labelledby="hours-tab">
                <h3>Horas de Trabajo Asignadas</h3>

                @if($job->workHours->isEmpty())
                    <p>No hay horas registradas para este trabajo.</p>
                @else
                    <table class="table table-bordered">
                        <thead class="table-light">
                        <tr>
                            <th>Usuario</th>
                            <th>Horas</th>
                            <th>Fecha de Registro</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($job->workHours as $hour)
                            <tr>
                                <td>{{ $hour->user->name }}</td>
                                <td>{{ $hour->hours }}</td>
                                <td>{{ $hour->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <!-- Botón para abrir modal -->
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editHourModal-{{ $hour->id }}">
                                        Editar
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="editHourModal-{{ $hour->id }}" tabindex="-1" aria-labelledby="editHourModalLabel-{{ $hour->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('jobs.updateHour', ['job' => $job->id, 'hour' => $hour->id]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editHourModalLabel-{{ $hour->id }}">Editar Horas</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="hours" class="form-label">Horas</label>
                                                            <input type="number" class="form-control" name="hours" step="0.1" min="0.1" max="24" value="{{ $hour->hours }}" required>
                                                            @error('hours')
                                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                @endif

                <h4 class="mt-4">Asignarte Horas</h4>

                <form action="{{ route('jobs.addHours', $job->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="hours" class="form-label">Horas a Registrar</label>
                        <input type="number" step="0.1" min="0.1" max="24" class="form-control" id="hours" name="hours" required>
                    </div>

                    <button type="submit" class="btn btn-success">Registrar Horas</button>
                </form>
            </div>
        </div>
    </div>
@endsection
