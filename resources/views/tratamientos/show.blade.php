@extends('layouts.app')

@section('title', 'Detalles de Tratamiento')
@section('page-title', 'Información del Tratamiento')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-capsule"></i> {{ $tratamiento->nombre_tratamiento }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Paciente:</strong><br>
                <a href="{{ route('pacientes.show', $tratamiento->paciente) }}">{{ $tratamiento->paciente->nombre_completo }}</a></p>
                <p><strong>DNI:</strong> {{ $tratamiento->paciente->dni }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Doctor Responsable:</strong><br>{{ $tratamiento->doctor->nombre_completo }}</p>
                <p><strong>Especialidad:</strong> {{ $tratamiento->doctor->especialidad }}</p>
            </div>
        </div>
        
        <hr>
        
        @if($tratamiento->consulta)
            <div class="mb-3">
                <p><strong>Consulta Asociada:</strong> 
                <a href="{{ route('consultas.show', $tratamiento->consulta) }}">#{{ $tratamiento->consulta_id }}</a>
                - {{ $tratamiento->consulta->fecha_hora->format('d/m/Y') }}</p>
            </div>
        @endif

        <div class="mb-3">
            <h6><strong>Descripción:</strong></h6>
            <p class="bg-light p-3 rounded">{{ $tratamiento->descripcion }}</p>
        </div>

        @if($tratamiento->medicamentos)
            <div class="mb-3">
                <h6><strong>Medicamentos:</strong></h6>
                <p class="bg-light p-3 rounded">{{ $tratamiento->medicamentos }}</p>
            </div>
        @endif

        @if($tratamiento->indicaciones)
            <div class="mb-3">
                <h6><strong>Indicaciones:</strong></h6>
                <p class="bg-light p-3 rounded">{{ $tratamiento->indicaciones }}</p>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-4">
                <p><strong>Fecha de Inicio:</strong> {{ $tratamiento->fecha_inicio->format('d/m/Y') }}</p>
            </div>
            <div class="col-md-4">
                <p><strong>Fecha de Fin:</strong> {{ $tratamiento->fecha_fin ? $tratamiento->fecha_fin->format('d/m/Y') : 'No especificada' }}</p>
            </div>
            <div class="col-md-4">
                <p><strong>Costo:</strong> S/ {{ number_format($tratamiento->costo, 2) }}</p>
            </div>
        </div>

        <div class="mb-3">
            <p><strong>Estado:</strong>
            <span class="badge bg-{{ $tratamiento->estado == 'Completado' ? 'success' : ($tratamiento->estado == 'En Proceso' ? 'info' : ($tratamiento->estado == 'Cancelado' ? 'danger' : 'warning')) }}">
                {{ $tratamiento->estado }}
            </span></p>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="{{ route('tratamientos.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <div>
                @if($tratamiento->estado == 'Pendiente')
                    <form action="{{ route('tratamientos.aceptar', $tratamiento) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-info">
                            <i class="bi bi-play-circle"></i> Iniciar Tratamiento
                        </button>
                    </form>
                @endif
                @if($tratamiento->estado == 'En Proceso')
                    <form action="{{ route('tratamientos.completar', $tratamiento) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Completar Tratamiento
                        </button>
                    </form>
                @endif
                <a href="{{ route('tratamientos.edit', $tratamiento) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
