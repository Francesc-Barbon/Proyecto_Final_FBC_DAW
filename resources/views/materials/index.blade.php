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
        <a href="{{ route('materials.create') }}" class="btn btn-primary mb-3">Añadir Nuevo Material</a>
        <h3 class="mt-4">Lista de Materiales</h3>
        <table class="table table-striped mt-3">
            <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio/Unidad (€)</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($materials as $material)
                <tr>
                    <td>{{ $material->name }}</td>
                    <td>{{ $material->description }}</td>
                    <td>{{ number_format($material->unit_price, 2) }} €</td>
                    <td>{{ $material->quantity }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-warning btn-sm">Almacén</a>
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
        <div class="d-flex justify-content-center mt-4">
            {{ $materials->links() }}
        </div>
    </div>
@endsection
