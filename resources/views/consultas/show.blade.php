@extends('layouts.app')

@section('title', 'Detalles de Consulta')
@section('page-title', 'Información de la Consulta')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clipboard2-pulse"></i> Datos de la Consulta #{{ $consulta->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Paciente:</strong><br>
                        <a href="{{ route('pacientes.show', $consulta->paciente) }}">{{ $consulta->paciente->nombre_completo }}</a></p>
                        <p><strong>DNI:</strong> {{ $consulta->paciente->dni }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Doctor:</strong><br>{{ $consulta->doctor->nombre_completo }}</p>
                        <p><strong>Especialidad:</strong> {{ $consulta->doctor->especialidad }}</p>
                    </div>
                </div>
                
                <hr>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Fecha y Hora:</strong> {{ $consulta->fecha_hora->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Estado:</strong>
                        <span class="badge bg-{{ $consulta->estado == 'Concluida' ? 'success' : ($consulta->estado == 'En Proceso' ? 'info' : ($consulta->estado == 'Cancelada' ? 'danger' : 'warning')) }}">
                            {{ $consulta->estado }}
                        </span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Costo:</strong> S/ {{ number_format($consulta->costo, 2) }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <h6><strong>Motivo de la Consulta:</strong></h6>
                    <p class="bg-light p-3 rounded">{{ $consulta->motivo }}</p>
                </div>

                @if($consulta->diagnostico)
                    <div class="mb-3">
                        <h6><strong>Diagnóstico:</strong></h6>
                        <p class="bg-light p-3 rounded">{{ $consulta->diagnostico }}</p>
                    </div>
                @endif

                @if($consulta->observaciones)
                    <div class="mb-3">
                        <h6><strong>Observaciones:</strong></h6>
                        <p class="bg-light p-3 rounded">{{ $consulta->observaciones }}</p>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                    <div>
                        @if($consulta->estado != 'Concluida')
                            <form action="{{ route('consultas.concluir', $consulta) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Concluir Consulta
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('consultas.edit', $consulta) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Exámenes relacionados -->
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-clipboard-data"></i> Exámenes</h6>
            </div>
            <div class="card-body">
                @if($consulta->examenes->count() > 0)
                    <ul class="list-group">
                        @foreach($consulta->examenes as $examen)
                            <li class="list-group-item">
                                <strong>{{ $examen->tipo_examen }}</strong><br>
                                <small>{{ $examen->fecha_solicitud->format('d/m/Y') }}</small>
                                <span class="badge bg-{{ $examen->estado == 'Concluido' ? 'success' : 'warning' }} float-end">
                                    {{ $examen->estado }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No hay exámenes asociados</p>
                @endif
                <a href="{{ route('examenes.create') }}?consulta_id={{ $consulta->id }}" class="btn btn-sm btn-primary mt-2 w-100">
                    <i class="bi bi-plus"></i> Nuevo Examen
                </a>
            </div>
        </div>

        <!-- Tratamientos relacionados -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-capsule"></i> Tratamientos</h6>
            </div>
            <div class="card-body">
                @if($consulta->tratamientos->count() > 0)
                    <ul class="list-group">
                        @foreach($consulta->tratamientos as $tratamiento)
                            <li class="list-group-item">
                                <strong>{{ $tratamiento->nombre_tratamiento }}</strong><br>
                                <small>{{ $tratamiento->fecha_inicio->format('d/m/Y') }}</small>
                                <span class="badge bg-{{ $tratamiento->estado == 'Completado' ? 'success' : 'info' }} float-end">
                                    {{ $tratamiento->estado }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No hay tratamientos asociados</p>
                @endif
                <a href="{{ route('tratamientos.create') }}?consulta_id={{ $consulta->id }}" class="btn btn-sm btn-primary mt-2 w-100">
                    <i class="bi bi-plus"></i> Nuevo Tratamiento
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
