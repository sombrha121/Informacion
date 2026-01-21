@extends('layouts.app')

@section('title', 'Editar Paciente')
@section('page-title', 'Editar Información del Paciente')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-pencil"></i> Editar Paciente: {{ $paciente->nombre_completo }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('pacientes.update', $paciente) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" name="nombre" value="{{ old('nombre', $paciente->nombre) }}" required>
                        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido *</label>
                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
                               id="apellido" name="apellido" value="{{ old('apellido', $paciente->apellido) }}" required>
                        @error('apellido')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI *</label>
                        <input type="text" class="form-control @error('dni') is-invalid @enderror" 
                               id="dni" name="dni" value="{{ old('dni', $paciente->dni) }}" required>
                        @error('dni')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                               id="fecha_nacimiento" name="fecha_nacimiento" 
                               value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento->format('Y-m-d')) }}" required>
                        @error('fecha_nacimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="meses_vida" class="form-label">Meses (Recién Nacido)</label>
                        <input type="number" class="form-control @error('meses_vida') is-invalid @enderror" 
                               id="meses_vida" name="meses_vida" min="0" max="11" 
                               value="{{ old('meses_vida', $paciente->meses_vida) }}" 
                               placeholder="0-11">
                        <small class="form-text text-muted">Solo si es menor de 1 año</small>
                        @error('meses_vida')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="genero" class="form-label">Género *</label>
                        <select class="form-select @error('genero') is-invalid @enderror" id="genero" name="genero" required>
                            <option value="">Seleccione...</option>
                            <option value="M" {{ old('genero', $paciente->genero) == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('genero', $paciente->genero) == 'F' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('genero', $paciente->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('genero')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" name="telefono" value="{{ old('telefono', $paciente->telefono) }}">
                        @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $paciente->email) }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <textarea class="form-control @error('direccion') is-invalid @enderror" 
                          id="direccion" name="direccion" rows="2">{{ old('direccion', $paciente->direccion) }}</textarea>
                @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="grupo_sanguineo" class="form-label">Grupo Sanguíneo</label>
                        <select class="form-select" id="grupo_sanguineo" name="grupo_sanguineo">
                            <option value="">Seleccione...</option>
                            <option value="A+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="alergias" class="form-label">Alergias</label>
                <textarea class="form-control" id="alergias" name="alergias" rows="2">{{ old('alergias', $paciente->alergias) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="enfermedades_cronicas" class="form-label">Enfermedades Crónicas</label>
                <textarea class="form-control" id="enfermedades_cronicas" name="enfermedades_cronicas" rows="2">{{ old('enfermedades_cronicas', $paciente->enfermedades_cronicas) }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('pacientes.show', $paciente) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Actualizar Paciente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
