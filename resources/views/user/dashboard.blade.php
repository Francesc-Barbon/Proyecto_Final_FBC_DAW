@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">
            @if (auth()->user()->role === 'admin')
                Dashboard de administración
            @else
                Mi desempeño
            @endif
        </h2>
        @if (auth()->user()->role === 'admin')
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-bg-success">
                        <div class="card-header">Coste total en mano de obra</div>
                        <div class="card-body">
                            <h4>{{ number_format($totalLaborCost, 2) }} €</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-bg-warning">
                        <div class="card-header">Coste total en materiales</div>
                        <div class="card-body">
                            <h4>{{ number_format($totalMaterialCost, 2) }} €</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-bg-danger">
                        <div class="card-header">Coste total de la empresa</div>
                        <div class="card-body">
                            <h4>{{ number_format($totalCompanyCost, 2) }} €</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            @foreach ($userStats as $stats)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            {{ $stats['user']->name }}
                        </div>
                        <div class="card-body">
                            <p><strong>Trabajos realizados:</strong> {{ $stats['jobCount'] }}</p>
                            <p><strong>Horas trabajadas:</strong> {{ number_format($stats['totalHours'], 2) }} h</p>
                            <p><strong>Costo generado:</strong> {{ number_format($stats['totalCost'], 2) }} €</p>
                            <p><strong>Materiales gestionados:</strong> {{ $stats['materialsManaged'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
