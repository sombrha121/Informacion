@extends('layouts.app')

@section('title', 'Dashboard - Sistema Médico')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card" style="border-left-color: #3498db;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Pacientes</h6>
                            <h2 class="mb-0">{{ \App\Models\Paciente::count() }}</h2>
                        </div>
                        <div>
                            <i class="bi bi-people-fill" style="font-size: 3rem; color: #3498db;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card" style="border-left-color: #27ae60;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Consultas Hoy</h6>
                            <h2 class="mb-0">{{ \App\Models\Consulta::whereDate('fecha_hora', today())->count() }}</h2>
                        </div>
                        <div>
                            <i class="bi bi-clipboard2-pulse" style="font-size: 3rem; color: #27ae60;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card" style="border-left-color: #f39c12;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Exámenes Pendientes</h6>
                            <h2 class="mb-0">{{ \App\Models\Examen::where('estado', 'Solicitado')->count() }}</h2>
                        </div>
                        <div>
                            <i class="bi bi-clipboard-data" style="font-size: 3rem; color: #f39c12;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card" style="border-left-color: #e74c3c;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Tratamientos Activos</h6>
                            <h2 class="mb-0">{{ \App\Models\Tratamiento::where('estado', 'En Proceso')->count() }}</h2>
                        </div>
                        <div>
                            <i class="bi bi-capsule" style="font-size: 3rem; color: #e74c3c;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Próximas Consultas -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Próximas Consultas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Doctor</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Consulta::with(['paciente', 'doctor'])->where('fecha_hora', '>=', now())->orderBy('fecha_hora')->limit(5)->get() as $consulta)
                                    <tr>
                                        <td>{{ $consulta->paciente->nombre_completo }}</td>
                                        <td>{{ $consulta->doctor->nombre_completo }}</td>
                                        <td>{{ $consulta->fecha_hora->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $consulta->estado == 'Pendiente' ? 'warning' : 'info' }}">
                                                {{ $consulta->estado }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay consultas programadas</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exámenes Recientes -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clipboard-data"></i> Exámenes Recientes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Tipo</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Examen::with('paciente')->latest('fecha_solicitud')->limit(5)->get() as $examen)
                                    <tr>
                                        <td>{{ $examen->paciente->nombre_completo }}</td>
                                        <td>{{ $examen->tipo_examen }}</td>
                                        <td>{{ $examen->fecha_solicitud->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $examen->estado == 'Concluido' ? 'success' : ($examen->estado == 'En Proceso' ? 'info' : 'warning') }}">
                                                {{ $examen->estado }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay exámenes registrados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lightning-fill"></i> Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{ route('pacientes.create') }}" class="btn btn-outline-primary w-100 mb-2">
                                <i class="bi bi-person-plus"></i><br>Nuevo Paciente
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('consultas.create') }}" class="btn btn-outline-success w-100 mb-2">
                                <i class="bi bi-clipboard-plus"></i><br>Nueva Consulta
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('examenes.create') }}" class="btn btn-outline-info w-100 mb-2">
                                <i class="bi bi-clipboard-data"></i><br>Nuevo Examen
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('tratamientos.create') }}" class="btn btn-outline-warning w-100 mb-2">
                                <i class="bi bi-capsule"></i><br>Nuevo Tratamiento
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('compras.create') }}" class="btn btn-outline-danger w-100 mb-2">
                                <i class="bi bi-cart-plus"></i><br>Nueva Compra
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary w-100 mb-2">
                                <i class="bi bi-graph-up"></i><br>Ver Reportes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
