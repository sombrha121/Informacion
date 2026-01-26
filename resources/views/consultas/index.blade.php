@extends('layouts.app')

@section('title', 'Consultas')
@section('page-title', 'Gestión de Consultas')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clipboard2-pulse"></i> Lista de Consultas</h5>
        <a href="{{ route('consultas.create') }}" class="btn btn-light">
            <i class="bi bi-clipboard-plus"></i> Nueva Consulta
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Doctor</th>
                        <th>Fecha/Hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Costo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultas as $consulta)
                        <tr>
                            <td>{{ $consulta->id }}</td>
                            <td>{{ $consulta->paciente->nombre_completo }}</td>
                            <td>{{ $consulta->doctor->nombre_completo }}</td>
                            <td>{{ $consulta->fecha_hora->format('d/m/Y H:i') }}</td>
                            <td>{{ \Str::limit($consulta->motivo, 30) }}</td>
                            <td>
                                <span class="badge bg-{{ $consulta->estado == 'Concluida' ? 'success' : ($consulta->estado == 'En Proceso' ? 'info' : ($consulta->estado == 'Cancelada' ? 'danger' : 'warning')) }}">
                                    {{ $consulta->estado }}
                                </span>
                            </td>
                            <td>S/ {{ number_format($consulta->costo, 2) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('consultas.show', $consulta) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('consultas.edit', $consulta) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($consulta->estado != 'Concluida')
                                        <form action="{{ route('consultas.concluir', $consulta) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Concluir">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay consultas registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $consultas->links() }}
        </div>
    </div>
</div>
@endsection
