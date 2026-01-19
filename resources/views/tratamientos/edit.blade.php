@extends('layouts.app')

@section('title', 'Editar Tratamiento')
@section('page-title', 'Editar Tratamiento')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-pencil"></i> Formulario de Edición de Tratamiento</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('tratamientos.update', $tratamiento) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="paciente_id" class="form-label">Paciente *</label>
                        <select class="form-select @error('paciente_id') is-invalid @enderror" 
                                id="paciente_id" name="paciente_id" required>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id', $tratamiento->paciente_id) == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre_completo }} - {{ $paciente->dni }}
                                </option>
                            @endforeach
                        </select>
                        @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Doctor Responsable *</label>
                        <select class="form-select @error('doctor_id') is-invalid @enderror" 
                                id="doctor_id" name="doctor_id" required>
                            @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $tratamiento->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->nombre_completo }} - {{ $doctor->especialidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="consulta_id" class="form-label">Consulta Asociada</label>
                <select class="form-select @error('consulta_id') is-invalid @enderror" 
                        id="consulta_id" name="consulta_id">
                    <option value="">Ninguna</option>
                    @foreach($consultas as $consulta)
                        <option value="{{ $consulta->id }}" {{ old('consulta_id', $tratamiento->consulta_id) == $consulta->id ? 'selected' : '' }}>
                            #{{ $consulta->id }} - {{ $consulta->paciente->nombre_completo }} ({{ $consulta->fecha_hora->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                @error('consulta_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="nombre_tratamiento" class="form-label">Nombre del Tratamiento *</label>
                <input type="text" class="form-control @error('nombre_tratamiento') is-invalid @enderror" 
                       id="nombre_tratamiento" name="nombre_tratamiento" 
                       value="{{ old('nombre_tratamiento', $tratamiento->nombre_tratamiento) }}" required>
                @error('nombre_tratamiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción del Tratamiento *</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                          id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $tratamiento->descripcion) }}</textarea>
                @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="medicamentos" class="form-label">Medicamentos</label>
                <textarea class="form-control @error('medicamentos') is-invalid @enderror" 
                          id="medicamentos" name="medicamentos" rows="3">{{ old('medicamentos', $tratamiento->medicamentos) }}</textarea>
                @error('medicamentos')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="indicaciones" class="form-label">Indicaciones</label>
                <textarea class="form-control @error('indicaciones') is-invalid @enderror" 
                          id="indicaciones" name="indicaciones" rows="3">{{ old('indicaciones', $tratamiento->indicaciones) }}</textarea>
                @error('indicaciones')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
                        <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
                               id="fecha_inicio" name="fecha_inicio" 
                               value="{{ old('fecha_inicio', $tratamiento->fecha_inicio->format('Y-m-d')) }}" required>
                        @error('fecha_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" 
                               id="fecha_fin" name="fecha_fin" 
                               value="{{ old('fecha_fin', $tratamiento->fecha_fin ? $tratamiento->fecha_fin->format('Y-m-d') : '') }}">
                        @error('fecha_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="costo" class="form-label">Costo (S/) *</label>
                        <input type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" 
                               id="costo" name="costo" value="{{ old('costo', $tratamiento->costo) }}" required>
                        @error('costo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado *</label>
                <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                    <option value="Pendiente" {{ old('estado', $tratamiento->estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="En Proceso" {{ old('estado', $tratamiento->estado) == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                    <option value="Completado" {{ old('estado', $tratamiento->estado) == 'Completado' ? 'selected' : '' }}>Completado</option>
                    <option value="Cancelado" {{ old('estado', $tratamiento->estado) == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
                @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('tratamientos.show', $tratamiento) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Actualizar Tratamiento
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
