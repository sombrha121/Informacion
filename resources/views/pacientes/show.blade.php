@extends('layouts.app')

@section('title', 'Detalles del Paciente')
@section('page-title', 'Información del Paciente')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-person-circle"></i> Datos Personales</h5>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $paciente->nombre_completo }}</p>
                <p><strong>DNI:</strong> {{ $paciente->dni }}</p>
                <p><strong>Fecha Nacimiento:</strong> {{ $paciente->fecha_nacimiento->format('d/m/Y') }}</p>
                <p><strong>Edad:</strong> {{ $paciente->edad }} años</p>
                <p><strong>Género:</strong> {{ $paciente->genero == 'M' ? 'Masculino' : ($paciente->genero == 'F' ? 'Femenino' : 'Otro') }}</p>
                <p><strong>Teléfono:</strong> {{ $paciente->telefono ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $paciente->email ?? 'N/A' }}</p>
                <p><strong>Dirección:</strong> {{ $paciente->direccion ?? 'N/A' }}</p>
                <hr>
                <p><strong>Grupo Sanguíneo:</strong> {{ $paciente->grupo_sanguineo ?? 'N/A' }}</p>
                <p><strong>Alergias:</strong> {{ $paciente->alergias ?? 'Ninguna' }}</p>
                <p><strong>Enfermedades Crónicas:</strong> {{ $paciente->enfermedades_cronicas ?? 'Ninguna' }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-warning w-100">
                    <i class="bi bi-pencil"></i> Editar Información
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Consultas -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clipboard2-pulse"></i> Consultas ({{ $paciente->consultas->count() }})</h5>
                <a href="{{ route('consultas.create') }}?paciente_id={{ $paciente->id }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Nueva Consulta
                </a>
            </div>
            <div class="card-body">
                @if($paciente->consultas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Doctor</th>
                                    <th>Motivo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paciente->consultas->take(5) as $consulta)
                                    <tr>
                                        <td>{{ $consulta->fecha_hora->format('d/m/Y') }}</td>
                                        <td>{{ $consulta->doctor->nombre_completo }}</td>
                                        <td>{{ \Str::limit($consulta->motivo, 30) }}</td>
                                        <td><span class="badge bg-{{ $consulta->estado == 'Concluida' ? 'success' : 'warning' }}">{{ $consulta->estado }}</span></td>
                                        <td>
                                            <a href="{{ route('consultas.show', $consulta) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No hay consultas registradas</p>
                @endif
            </div>
        </div>

        <!-- Exámenes -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clipboard-data"></i> Exámenes ({{ $paciente->examenes->count() }})</h5>
                <a href="{{ route('examenes.create') }}?paciente_id={{ $paciente->id }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Nuevo Examen
                </a>
            </div>
            <div class="card-body">
                @if($paciente->examenes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Solicitado Por</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paciente->examenes->take(5) as $examen)
                                    <tr>
                                        <td>{{ $examen->fecha_solicitud->format('d/m/Y') }}</td>
                                        <td>{{ $examen->tipo_examen }}</td>
                                        <td>{{ $examen->solicitante->nombre_completo }}</td>
                                        <td><span class="badge bg-{{ $examen->estado == 'Concluido' ? 'success' : 'warning' }}">{{ $examen->estado }}</span></td>
                                        <td>
                                            <a href="{{ route('examenes.show', $examen) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No hay exámenes registrados</p>
                @endif
            </div>
        </div>

        <!-- Tratamientos -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-capsule"></i> Tratamientos ({{ $paciente->tratamientos->count() }})</h5>
                <a href="{{ route('tratamientos.create') }}?paciente_id={{ $paciente->id }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Nuevo Tratamiento
                </a>
            </div>
            <div class="card-body">
                @if($paciente->tratamientos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Fecha Inicio</th>
                                    <th>Tratamiento</th>
                                    <th>Doctor</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paciente->tratamientos->take(5) as $tratamiento)
                                    <tr>
                                        <td>{{ $tratamiento->fecha_inicio->format('d/m/Y') }}</td>
                                        <td>{{ $tratamiento->nombre_tratamiento }}</td>
                                        <td>{{ $tratamiento->doctor->nombre_completo }}</td>
                                        <td><span class="badge bg-{{ $tratamiento->estado == 'Completado' ? 'success' : 'info' }}">{{ $tratamiento->estado }}</span></td>
                                        <td>
                                            <a href="{{ route('tratamientos.show', $tratamiento) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No hay tratamientos registrados</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver a la Lista
    </a>
</div>
@endsection
