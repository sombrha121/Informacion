@extends('layouts.app')

@section('title', 'Editar Consulta')
@section('page-title', 'Editar Consulta')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-pencil"></i> Formulario de Edición de Consulta #{{ $consulta->id }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('consultas.update', $consulta) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="paciente_id" class="form-label">Paciente *</label>
                        <select class="form-select @error('paciente_id') is-invalid @enderror" 
                                id="paciente_id" name="paciente_id" required>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id', $consulta->paciente_id) == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre_completo }} - {{ $paciente->dni }}
                                </option>
                            @endforeach
                        </select>
                        @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Doctor *</label>
                        <select class="form-select @error('doctor_id') is-invalid @enderror" 
                                id="doctor_id" name="doctor_id" required>
                            @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $consulta->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->nombre_completo }} - {{ $doctor->especialidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo de la Consulta *</label>
                <textarea class="form-control @error('motivo') is-invalid @enderror" 
                          id="motivo" name="motivo" rows="3" required>{{ old('motivo', $consulta->motivo) }}</textarea>
                @error('motivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="diagnostico" class="form-label">Diagnóstico</label>
                <textarea class="form-control @error('diagnostico') is-invalid @enderror" 
                          id="diagnostico" name="diagnostico" rows="3">{{ old('diagnostico', $consulta->diagnostico) }}</textarea>
                @error('diagnostico')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                          id="observaciones" name="observaciones" rows="3">{{ old('observaciones', $consulta->observaciones) }}</textarea>
                @error('observaciones')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_hora" class="form-label">Fecha y Hora *</label>
                        <input type="datetime-local" class="form-control @error('fecha_hora') is-invalid @enderror" 
                               id="fecha_hora" name="fecha_hora" 
                               value="{{ old('fecha_hora', $consulta->fecha_hora->format('Y-m-d\TH:i')) }}" required>
                        @error('fecha_hora')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado *</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="Programada" {{ old('estado', $consulta->estado) == 'Programada' ? 'selected' : '' }}>Programada</option>
                            <option value="En Proceso" {{ old('estado', $consulta->estado) == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                            <option value="Concluida" {{ old('estado', $consulta->estado) == 'Concluida' ? 'selected' : '' }}>Concluida</option>
                            <option value="Cancelada" {{ old('estado', $consulta->estado) == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="costo" class="form-label">Costo (S/) *</label>
                        <input type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" 
                               id="costo" name="costo" value="{{ old('costo', $consulta->costo) }}" required>
                        @error('costo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('consultas.show', $consulta) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Actualizar Consulta
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
