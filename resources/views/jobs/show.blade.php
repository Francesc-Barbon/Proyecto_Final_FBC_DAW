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
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h3>Agregar Material al Trabajo</h3>
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
@endsection
