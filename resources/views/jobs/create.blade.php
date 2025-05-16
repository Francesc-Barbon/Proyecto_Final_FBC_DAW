@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear nuevo trabajo</h2>

        <form method="POST" action="{{ route('jobs.store') }}">
            @csrf
            <div class="mb-3">
                <label>Descripción</label>
                <input type="text" name="description" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Fecha de inicio</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Asignar Usuario</label>
                <select name="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
