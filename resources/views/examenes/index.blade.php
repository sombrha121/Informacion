@extends('layouts.app')

@section('title', 'Exámenes')
@section('page-title', 'Gestión de Exámenes de Laboratorio')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clipboard-data"></i> Lista de Exámenes</h5>
        <a href="{{ route('examenes.create') }}" class="btn btn-light">
            <i class="bi bi-clipboard-plus"></i> Nuevo Examen
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Tipo de Examen</th>
                        <th>Solicitado Por</th>
                        <th>Fecha Solicitud</th>
                        <th>Estado</th>
                        <th>Costo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($examenes as $examen)
                        <tr>
                            <td>{{ $examen->id }}</td>
                            <td>{{ $examen->paciente->nombre_completo }}</td>
                            <td>{{ $examen->tipo_examen }}</td>
                            <td>{{ $examen->solicitante->nombre_completo }}</td>
                            <td>{{ $examen->fecha_solicitud->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $examen->estado == 'Concluido' ? 'success' : ($examen->estado == 'En Proceso' ? 'info' : ($examen->estado == 'Cancelado' ? 'danger' : 'warning')) }}">
                                    {{ $examen->estado }}
                                </span>
                            </td>
                            <td>S/ {{ number_format($examen->costo, 2) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('examenes.show', $examen) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('examenes.edit', $examen) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay exámenes registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $examenes->links() }}
        </div>
    </div>
</div>
@endsection
