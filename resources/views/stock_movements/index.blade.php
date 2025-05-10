@extends('layouts.app') <!-- o el layout que uses -->

@section('content')
    <div class="container">
        <h2 class="mb-4">Historial de Movimientos de Stock</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Material</th>
                <th>Cantidad</th>
                <th>Tipo de Movimiento</th>
                <th>Usuario</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($movements as $movement)
                <tr>
                    <td>{{ $movement->date }}</td>
                    <td>{{ $movement->material_name ?? 'Material eliminado' }}</td>
                    <td>{{ $movement->quantity }}</td>
                    <td>{{ ucfirst($movement->movement_type) }}</td>
                    <td>{{ $movement->user_name ?? 'Usuario eliminado' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
