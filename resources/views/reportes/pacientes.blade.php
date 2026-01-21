@extends('layouts.app')

@section('title', 'Reporte de Pacientes')
@section('page-title', 'Reporte de Pacientes')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reportes.pacientes') }}" class="row g-3">
            <div class="col-md-4">
                <label for="buscar" class="form-label">Buscar Paciente</label>
                <input type="text" class="form-control" id="buscar" name="buscar" 
                       placeholder="Nombre o DNI" value="{{ request('buscar') }}">
            </div>
            <div class="col-md-4">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="">Todos</option>
                    <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-people"></i> Listado de Pacientes</h5>
            <button class="btn btn-sm btn-success" onclick="exportarExcel()">
                <i class="bi bi-file-earmark-excel"></i> Exportar Excel
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaPacientes">
                <thead class="table-dark">
                    <tr>
                        <th>DNI</th>
                        <th>Nombre Completo</th>
                        <th>Edad</th>
                        <th>Teléfono</th>
                        <th>Consultas</th>
                        <th>Exámenes</th>
                        <th>Tratamientos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pacientes as $paciente)
                        <tr>
                            <td><strong>{{ $paciente->dni }}</strong></td>
                            <td>{{ $paciente->nombre_completo }}</td>
                            <td>{{ $paciente->edad }}</td>
                            <td>{{ $paciente->telefono ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $paciente->consultas_count }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $paciente->examenes_count }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warning">{{ $paciente->tratamientos_count }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $paciente->estado == 'Activo' ? 'success' : 'danger' }}">
                                    {{ $paciente->estado }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pacientes.show', $paciente) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                @if(request('buscar') || request('estado'))
                                    <i class="bi bi-search"></i> No se encontraron pacientes que coincidan con los criterios de búsqueda
                                @else
                                    No hay pacientes registrados
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            @if($pacientes->count() > 0)
                <p class="text-muted">
                    <strong>Total:</strong> {{ $pacientes->count() }} 
                    @if(request('buscar') || request('estado'))
                        pacientes encontrados
                    @else
                        pacientes registrados
                    @endif
                </p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportarExcel() {
    let table = document.getElementById('tablaPacientes');
    let html = table.outerHTML.replace(/<th>Acciones<\/th>/g, '');
    let rows = html.split('<tr>');
    rows.forEach((row, index) => {
        if (index > 0) {
            row = row.replace(/<td>.*?<a href.*?<\/a>.*?<\/td>/g, '');
            rows[index] = row;
        }
    });
    
    let csv = [];
    let trs = table.querySelectorAll('tr');
    
    trs.forEach(function(tr) {
        let row = [];
        tr.querySelectorAll('th, td').forEach(function(td, index) {
            if (index < tr.querySelectorAll('th, td').length - 1) {
                row.push(td.innerText.trim());
            }
        });
        csv.push(row.join(','));
    });
    
    let csvContent = csv.join('\n');
    let blob = new Blob([csvContent], { type: 'text/csv' });
    let link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'reporte_pacientes_' + new Date().getTime() + '.csv';
    link.click();
}
</script>
@endpush
@endsection
