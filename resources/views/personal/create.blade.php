@extends('layouts.app')

@section('title', 'Nuevo Personal')
@section('page-title', 'Registrar Nuevo Personal')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-person-plus"></i> Formulario de Registro de Personal</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('personal.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido *</label>
                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
                               id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                        @error('apellido')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI *</label>
                        <input type="text" class="form-control @error('dni') is-invalid @enderror" 
                               id="dni" name="dni" value="{{ old('dni') }}" required>
                        @error('dni')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Personal *</label>
                        <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                            <option value="">Seleccione...</option>
                            <option value="Doctor" {{ old('tipo') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                            <option value="Enfermero" {{ old('tipo') == 'Enfermero' ? 'selected' : '' }}>Enfermero</option>
                            <option value="Administrativo" {{ old('tipo') == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                            <option value="Laboratorio" {{ old('tipo') == 'Laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                        </select>
                        @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="especialidad" class="form-label">Especialidad</label>
                        <input type="text" class="form-control @error('especialidad') is-invalid @enderror" 
                               id="especialidad" name="especialidad" value="{{ old('especialidad') }}">
                        @error('especialidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Este email se usará para iniciar sesión</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" name="telefono" value="{{ old('telefono') }}">
                        @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Mínimo 8 caracteres</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_contratacion" class="form-label">Fecha de Contratación *</label>
                        <input type="date" class="form-control @error('fecha_contratacion') is-invalid @enderror" 
                               id="fecha_contratacion" name="fecha_contratacion" 
                               value="{{ old('fecha_contratacion', now()->format('Y-m-d')) }}" required>
                        @error('fecha_contratacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado *</label>
                <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                    <option value="Activo" {{ old('estado', 'Activo') == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('personal.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar Personal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
