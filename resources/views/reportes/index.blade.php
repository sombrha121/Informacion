@extends('layouts.app')

@section('title', 'Reportes')
@section('page-title', 'Reportes y Estadísticas')

@section('content')
<div class="row mb-4">
    <!-- Estadísticas Generales -->
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h3>{{ $totalPacientes }}</h3>
                <p class="mb-0">Total Pacientes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h3>{{ $consultasHoy }}</h3>
                <p class="mb-0">Consultas Hoy</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h3>{{ $examenesPendientes }}</h3>
                <p class="mb-0">Exámenes Pendientes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h3>{{ $tratamientosActivos }}</h3>
                <p class="mb-0">Tratamientos Activos</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Consultas por Mes</h5>
            </div>
            <div class="card-body">
                <canvas id="consultasChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-cash-stack"></i> Ingresos por Mes</h5>
            </div>
            <div class="card-body">
                <canvas id="ingresosChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Reportes Disponibles</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('reportes.pacientes') }}" class="card h-100 text-decoration-none text-dark" style="border-left: 4px solid #3498db; transition: all 0.3s;">
                            <div class="card-body text-center">
                                <i class="bi bi-people" style="font-size: 2.5rem; color: #3498db;"></i>
                                <h5 class="card-title mt-3">Reporte de Pacientes</h5>
                                <p class="card-text text-muted small">Listado completo de pacientes con estadísticas</p>
                                <div class="badge bg-primary">Total Pacientes: {{ $totalPacientes }}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 mb-3">
                        <a href="{{ route('reportes.consultas') }}" class="card h-100 text-decoration-none text-dark" style="border-left: 4px solid #27ae60; transition: all 0.3s;">
                            <div class="card-body text-center">
                                <i class="bi bi-clipboard-pulse" style="font-size: 2.5rem; color: #27ae60;"></i>
                                <h5 class="card-title mt-3">Reporte de Consultas</h5>
                                <p class="card-text text-muted small">Registro de todas las consultas realizadas</p>
                                <div class="badge bg-success">Consultas Hoy: {{ $consultasHoy }}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 mb-3">
                        <a href="{{ route('reportes.financiero') }}" class="card h-100 text-decoration-none text-dark" style="border-left: 4px solid #e74c3c; transition: all 0.3s;">
                            <div class="card-body text-center">
                                <i class="bi bi-currency-dollar" style="font-size: 2.5rem; color: #e74c3c;"></i>
                                <h5 class="card-title mt-3">Reporte Financiero</h5>
                                <p class="card-text text-muted small">Ingresos, gastos y análisis financiero</p>
                                <div class="badge bg-danger">Examenes Pendientes: {{ $examenesPendientes }}</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Consultas
    const ctxConsultas = document.getElementById('consultasChart').getContext('2d');
    fetch('/api/charts/data?tipo=consultas')
        .then(res => res.json())
        .then(chartData => {
            new Chart(ctxConsultas, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Consultas',
                        data: chartData.data,
                        backgroundColor: 'rgba(52, 152, 219, 0.5)',
                        borderColor: 'rgba(52, 152, 219, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });

    // Gráfico de Ingresos
    const ctxIngresos = document.getElementById('ingresosChart').getContext('2d');
    fetch('/api/charts/data?tipo=ingresos')
        .then(res => res.json())
        .then(chartData => {
            new Chart(ctxIngresos, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Ingresos (S/)',
                        data: chartData.data,
                        backgroundColor: 'rgba(39, 174, 96, 0.2)',
                        borderColor: 'rgba(39, 174, 96, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
</script>
@endpush
