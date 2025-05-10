@extends('layouts.app')

@section('content')
<body class="p-5">
<div class="container">

    <div class="container mt-5 pt-4">
        <h1 class="mb-4">Materiales</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <h3 class="mt-4">Lista de Materiales</h3>
        <table class="table table-striped mt-3">
            <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($materials as $material)
                <tr>
                    <td>{{ $material->name }}</td>
                    <td>{{ $material->description }}</td>
                    <td>{{ $material->quantity }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este material?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3 class="mt-5">Añadir Material</h3>
        <form action="{{ route('materials.store') }}" method="POST" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Material</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <button type="submit" class="btn btn-success">Añadir Material</button>
        </form>
    </div>
@endsection
