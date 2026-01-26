@extends('layouts.app')

@section('title', 'Tratamientos')
@section('page-title', 'Gestión de Tratamientos')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-capsule"></i> Lista de Tratamientos</h5>
        <a href="{{ route('tratamientos.create') }}" class="btn btn-light">
            <i class="bi bi-plus-circle"></i> Nuevo Tratamiento
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Tratamiento</th>
                        <th>Doctor</th>
                        <th>Fecha Inicio</th>
                        <th>Estado</th>
                        <th>Costo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tratamientos as $tratamiento)
                        <tr>
                            <td>{{ $tratamiento->id }}</td>
                            <td>{{ $tratamiento->paciente->nombre_completo }}</td>
                            <td>{{ $tratamiento->nombre_tratamiento }}</td>
                            <td>{{ $tratamiento->doctor->nombre_completo }}</td>
                            <td>{{ $tratamiento->fecha_inicio->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $tratamiento->estado == 'Completado' ? 'success' : ($tratamiento->estado == 'En Proceso' ? 'info' : ($tratamiento->estado == 'Cancelado' ? 'danger' : 'warning')) }}">
                                    {{ $tratamiento->estado }}
                                </span>
                            </td>
                            <td>S/ {{ number_format($tratamiento->costo, 2) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tratamientos.show', $tratamiento) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('tratamientos.edit', $tratamiento) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay tratamientos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $tratamientos->links() }}
        </div>
    </div>
</div>
@endsection
