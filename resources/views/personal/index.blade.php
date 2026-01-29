@extends('layouts.app')

@section('title', 'Personal')
@section('page-title', 'Gestión de Personal Médico')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-person-badge"></i> Lista de Personal</h5>
        <a href="{{ route('personal.create') }}" class="btn btn-light">
            <i class="bi bi-person-plus"></i> Nuevo Personal
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>DNI</th>
                        <th>Tipo</th>
                        <th>Especialidad</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($personal as $persona)
                        <tr>
                            <td>{{ $persona->id }}</td>
                            <td>{{ $persona->nombre_completo }}</td>
                            <td>{{ $persona->dni }}</td>
                            <td><span class="badge bg-primary">{{ $persona->tipo }}</span></td>
                            <td>{{ $persona->especialidad ?? 'N/A' }}</td>
                            <td>{{ $persona->email }}</td>
                            <td>{{ $persona->telefono ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $persona->estado == 'Activo' ? 'success' : 'danger' }}">
                                    {{ $persona->estado }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('personal.show', $persona) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('personal.edit', $persona) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay personal registrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $personal->links() }}
        </div>
    </div>
</div>
@endsection
