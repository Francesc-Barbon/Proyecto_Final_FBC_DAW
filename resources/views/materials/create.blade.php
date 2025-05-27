@extends('layouts.app')

@section('content')
    <div class="container mt-5 pt-4">
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

            <div class="mb-3">
                <label for="unit_price" class="form-label">Precio por unidad (€)</label>
                <input type="number" name="unit_price" class="form-control" step="0.01" min="0" value="{{ old('unit_price', 0) }}">
            </div>

            <div class="mb-3">
                <label for="material_code" class="form-label">Código de Material</label>
                <input type="text" name="material_code" id="material_code" class="form-control @error('material_code') is-invalid @enderror" value="{{ old('material_code') }}" required>
                @error('material_code')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            <button type="submit" class="btn btn-success">Añadir Material</button>
        </form>
    </div>
@endsection
