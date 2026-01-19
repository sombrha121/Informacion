@extends('layouts.app')

@section('title', 'Nuevo Examen')
@section('page-title', 'Solicitar Nuevo Examen de Laboratorio')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-clipboard-plus"></i> Formulario de Solicitud de Examen</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('examenes.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="paciente_id" class="form-label">Paciente *</label>
                        <select class="form-select @error('paciente_id') is-invalid @enderror" 
                                id="paciente_id" name="paciente_id" required>
                            <option value="">Seleccione un paciente...</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id', request('paciente_id')) == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre_completo }} - {{ $paciente->dni }}
                                </option>
                            @endforeach
                        </select>
                        @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="consulta_id" class="form-label">Consulta Asociada (Opcional)</label>
                        <select class="form-select @error('consulta_id') is-invalid @enderror" 
                                id="consulta_id" name="consulta_id">
                            <option value="">Ninguna</option>
                            @foreach($consultas as $consulta)
                                <option value="{{ $consulta->id }}" {{ old('consulta_id', request('consulta_id')) == $consulta->id ? 'selected' : '' }}>
                                    #{{ $consulta->id }} - {{ $consulta->paciente->nombre_completo }} ({{ $consulta->fecha_hora->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('consulta_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tipo_examen" class="form-label">Tipo de Examen *</label>
                        <select class="form-select @error('tipo_examen') is-invalid @enderror" id="tipo_examen" name="tipo_examen" required>
                            <option value="">Seleccione...</option>
                            <option value="Sangre Completa" {{ old('tipo_examen') == 'Sangre Completa' ? 'selected' : '' }}>Sangre Completa</option>
                            <option value="Orina" {{ old('tipo_examen') == 'Orina' ? 'selected' : '' }}>Orina</option>
                            <option value="Heces" {{ old('tipo_examen') == 'Heces' ? 'selected' : '' }}>Heces</option>
                            <option value="Rayos X" {{ old('tipo_examen') == 'Rayos X' ? 'selected' : '' }}>Rayos X</option>
                            <option value="Ecografía" {{ old('tipo_examen') == 'Ecografía' ? 'selected' : '' }}>Ecografía</option>
                            <option value="Electrocardiograma" {{ old('tipo_examen') == 'Electrocardiograma' ? 'selected' : '' }}>Electrocardiograma</option>
                            <option value="Glucosa" {{ old('tipo_examen') == 'Glucosa' ? 'selected' : '' }}>Glucosa</option>
                            <option value="Colesterol" {{ old('tipo_examen') == 'Colesterol' ? 'selected' : '' }}>Colesterol</option>
                            <option value="Otro" {{ old('tipo_examen') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('tipo_examen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="solicitado_por" class="form-label">Solicitado Por *</label>
                        <select class="form-select @error('solicitado_por') is-invalid @enderror" 
                                id="solicitado_por" name="solicitado_por" required>
                            <option value="">Seleccione...</option>
                            @foreach($personal as $persona)
                                <option value="{{ $persona->id }}" {{ old('solicitado_por') == $persona->id ? 'selected' : '' }}>
                                    {{ $persona->nombre_completo }} - {{ $persona->tipo }}
                                </option>
                            @endforeach
                        </select>
                        @error('solicitado_por')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="fecha_solicitud" class="form-label">Fecha de Solicitud *</label>
                        <input type="datetime-local" class="form-control @error('fecha_solicitud') is-invalid @enderror" 
                               id="fecha_solicitud" name="fecha_solicitud" 
                               value="{{ old('fecha_solicitud', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('fecha_solicitud')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado *</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="Solicitado" {{ old('estado', 'Solicitado') == 'Solicitado' ? 'selected' : '' }}>Solicitado</option>
                            <option value="En Proceso" {{ old('estado') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                            <option value="Concluido" {{ old('estado') == 'Concluido' ? 'selected' : '' }}>Concluido</option>
                            <option value="Cancelado" {{ old('estado') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="costo" class="form-label">Costo (S/) *</label>
                        <input type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" 
                               id="costo" name="costo" value="{{ old('costo', '0.00') }}" required>
                        @error('costo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción del Examen</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                          id="descripcion" name="descripcion" rows="2">{{ old('descripcion') }}</textarea>
                @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="fecha_realizacion" class="form-label">Fecha de Realización</label>
                <input type="datetime-local" class="form-control @error('fecha_realizacion') is-invalid @enderror" 
                       id="fecha_realizacion" name="fecha_realizacion" value="{{ old('fecha_realizacion') }}">
                @error('fecha_realizacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="resultados" class="form-label">Resultados</label>
                <textarea class="form-control @error('resultados') is-invalid @enderror" 
                          id="resultados" name="resultados" rows="4">{{ old('resultados') }}</textarea>
                @error('resultados')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('examenes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar Examen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
