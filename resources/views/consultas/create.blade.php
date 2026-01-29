@extends('layouts.app')

@section('title', 'Nueva Consulta')
@section('page-title', 'Registrar Nueva Consulta')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-clipboard-plus"></i> Formulario de Nueva Consulta</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('consultas.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="paciente_id" class="form-label">Paciente *</label>
                        <select class="form-select @error('paciente_id') is-invalid @enderror" 
                                id="paciente_id" name="paciente_id" required>
                            <option value="">Seleccione un paciente...</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->dni }}
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
                            <option value="">Seleccione un doctor...</option>
                            @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->nombre }} {{ $doctor->apellido }} - {{ $doctor->especialidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_hora" class="form-label">Fecha y Hora *</label>
                        <input type="datetime-local" class="form-control @error('fecha_hora') is-invalid @enderror" 
                               id="fecha_hora" name="fecha_hora" value="{{ old('fecha_hora', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('fecha_hora')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado *</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="En Proceso" {{ old('estado') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                            <option value="Concluida" {{ old('estado') == 'Concluida' ? 'selected' : '' }}>Concluida</option>
                            <option value="Cancelada" {{ old('estado') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="costo" class="form-label">Costo (S/) *</label>
                        <input type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" 
                               id="costo" name="costo" value="{{ old('costo', '0.00') }}" required>
                        @error('costo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo de la Consulta *</label>
                <textarea class="form-control @error('motivo') is-invalid @enderror" 
                          id="motivo" name="motivo" rows="3" required>{{ old('motivo') }}</textarea>
                @error('motivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="diagnostico" class="form-label">Diagnóstico</label>
                <textarea class="form-control @error('diagnostico') is-invalid @enderror" 
                          id="diagnostico" name="diagnostico" rows="3">{{ old('diagnostico') }}</textarea>
                @error('diagnostico')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                          id="observaciones" name="observaciones" rows="2">{{ old('observaciones') }}</textarea>
                @error('observaciones')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar Consulta
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@endpush
@endsection
