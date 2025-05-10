@extends('layouts.app') <!-- o usa tu layout base -->

@section('content')
    <div class="container">
        <h2>Editar Cantidad de Material: {{ $material->name }}</h2>

        <form method="POST" action="{{ route('materials.update', $material->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="movement_type" class="form-label">Tipo de Movimiento</label>
                <select name="movement_type" id="movement_type" class="form-select" required>
                    <option value="added">Entrada</option>
                    <option value="removed">Salida</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Cantidad</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('materials.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection

