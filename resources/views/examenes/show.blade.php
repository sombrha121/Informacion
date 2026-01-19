@extends('layouts.app')

@section('title', 'Detalles de Examen')
@section('page-title', 'Información del Examen')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-clipboard-data"></i> Examen #{{ $examen->id }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Paciente:</strong><br>
                <a href="{{ route('pacientes.show', $examen->paciente) }}">{{ $examen->paciente->nombre_completo }}</a></p>
                <p><strong>DNI:</strong> {{ $examen->paciente->dni }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Solicitado Por:</strong><br>{{ $examen->solicitante->nombre_completo }}</p>
                <p><strong>Tipo:</strong> {{ $examen->solicitante->tipo }}</p>
            </div>
        </div>
        
        <hr>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Tipo de Examen:</strong> {{ $examen->tipo_examen }}</p>
                @if($examen->consulta)
                    <p><strong>Consulta Asociada:</strong> 
                    <a href="{{ route('consultas.show', $examen->consulta) }}">#{{ $examen->consulta_id }}</a></p>
                @endif
            </div>
            <div class="col-md-3">
                <p><strong>Estado:</strong>
                <span class="badge bg-{{ $examen->estado == 'Concluido' ? 'success' : ($examen->estado == 'En Proceso' ? 'info' : ($examen->estado == 'Cancelado' ? 'danger' : 'warning')) }}">
                    {{ $examen->estado }}
                </span></p>
            </div>
            <div class="col-md-3">
                <p><strong>Costo:</strong> S/ {{ number_format($examen->costo, 2) }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Fecha de Solicitud:</strong> {{ $examen->fecha_solicitud->format('d/m/Y H:i') }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Fecha de Realización:</strong> 
                {{ $examen->fecha_realizacion ? $examen->fecha_realizacion->format('d/m/Y H:i') : 'Pendiente' }}</p>
            </div>
        </div>

        @if($examen->descripcion)
            <div class="mb-3">
                <h6><strong>Descripción:</strong></h6>
                <p class="bg-light p-3 rounded">{{ $examen->descripcion }}</p>
            </div>
        @endif

        @if($examen->resultados)
            <div class="mb-3">
                <h6><strong>Resultados:</strong></h6>
                <p class="bg-light p-3 rounded">{{ $examen->resultados }}</p>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="{{ route('examenes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <div>
                @if($examen->estado != 'Concluido')
                    <form action="{{ route('examenes.concluir', $examen) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Concluir Examen
                        </button>
                    </form>
                @endif
                <a href="{{ route('examenes.edit', $examen) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
