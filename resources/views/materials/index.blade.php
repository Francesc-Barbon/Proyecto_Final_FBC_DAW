<!DOCTYPE html>
<html>
<head>
    <title>Materiales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
<div class="container">

    <h1>Materiales</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <h3>Lista de Materiales</h3>
    <table class="table table-striped mt-3">
        <thead>
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
                <td>
                    <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-warning btn-sm">Editar Cantidad</a>
                    <form action="{{ route('materials.destroy', $material->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>

                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3>Añadir Material</h3>
    <form action="{{ route('materials.store') }}" method="POST">
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
</body>
</html>
