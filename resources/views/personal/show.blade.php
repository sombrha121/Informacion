@extends('layouts.app')

@section('title', 'Detalles de Personal')
@section('page-title', 'Información del Personal')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-person-badge"></i> {{ $personal->nombre_completo }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Nombre Completo:</strong> {{ $personal->nombre_completo }}</p>
                <p><strong>DNI:</strong> {{ $personal->dni }}</p>
                <p><strong>Email:</strong> {{ $personal->email }}</p>
                @if($personal->telefono)
                    <p><strong>Teléfono:</strong> {{ $personal->telefono }}</p>
                @endif
            </div>
            <div class="col-md-6">
                <p><strong>Tipo:</strong> 
                <span class="badge bg-{{ $personal->tipo == 'Doctor' ? 'primary' : ($personal->tipo == 'Enfermero' ? 'info' : 'secondary') }}">
                    {{ $personal->tipo }}
                </span></p>
                @if($personal->especialidad)
                    <p><strong>Especialidad:</strong> {{ $personal->especialidad }}</p>
                @endif
                <p><strong>Estado:</strong> 
                <span class="badge bg-{{ $personal->estado == 'Activo' ? 'success' : 'danger' }}">
                    {{ $personal->estado }}
                </span></p>
                <p><strong>Fecha de Contratación:</strong> {{ $personal->fecha_contratacion->format('d/m/Y') }}</p>
            </div>
        </div>

        <hr>

        <h5><i class="bi bi-activity"></i> Actividad</h5>
        
        @if($personal->tipo == 'Doctor')
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <h3>{{ $personal->consultas->count() }}</h3>
                            <p class="mb-0">Consultas Realizadas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">
                            <h3>{{ $personal->tratamientos->count() }}</h3>
                            <p class="mb-0">Tratamientos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body">
                            <h3>{{ $personal->examenesSolicitados->count() }}</h3>
                            <p class="mb-0">Exámenes Solicitados</p>
                        </div>
                    </div>
                </div>
            </div>

            <h6 class="mt-4">Últimas Consultas</h6>
            @if($personal->consultas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Paciente</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personal->consultas->take(5) as $consulta)
                                <tr>
                                    <td><a href="{{ route('consultas.show', $consulta) }}">#{{ $consulta->id }}</a></td>
                                    <td>{{ $consulta->paciente->nombre_completo }}</td>
                                    <td>{{ $consulta->fecha_hora->format('d/m/Y H:i') }}</td>
                                    <td><span class="badge bg-{{ $consulta->estado == 'Concluida' ? 'success' : 'info' }}">{{ $consulta->estado }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No hay consultas registradas</p>
            @endif
        @else
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body">
                            <h3>{{ $personal->examenesSolicitados->count() }}</h3>
                            <p class="mb-0">Exámenes Solicitados</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-warning text-dark mb-3">
                        <div class="card-body">
                            <h3>{{ $personal->compras->count() }}</h3>
                            <p class="mb-0">Compras Realizadas</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="{{ route('personal.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <a href="{{ route('personal.edit', $personal) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
        </div>
    </div>
</div>
@endsection
