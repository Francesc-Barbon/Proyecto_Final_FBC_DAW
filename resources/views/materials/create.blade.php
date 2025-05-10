@extends('layouts.app')

@section('content')

    <h1>Crear Nuevo Material</h1>

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

    <a href="{{ route('materials.index') }}" class="btn btn-primary mt-3">Volver a la lista de Materiales</a>
</div>
</body>
@endsection

