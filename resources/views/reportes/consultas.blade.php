@extends('layouts.app')

@section('title', 'Reporte de Consultas')
@section('page-title', 'Reporte de Consultas')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reportes.consultas') }}" class="row g-3">
            <div class="col-md-3">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                       value="{{ request('fecha_inicio') }}">
            </div>
            <div class="col-md-3">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                       value="{{ request('fecha_fin') }}">
            </div>
            <div class="col-md-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="">Todos</option>
                    <option value="Programada" {{ request('estado') == 'Programada' ? 'selected' : '' }}>Programada</option>
                    <option value="En Proceso" {{ request('estado') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                    <option value="Concluida" {{ request('estado') == 'Concluida' ? 'selected' : '' }}>Concluida</option>
                    <option value="Cancelada" {{ request('estado') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-clipboard-pulse"></i> Listado de Consultas</h5>
            <button class="btn btn-sm btn-success" onclick="exportarExcel()">
                <i class="bi bi-file-earmark-excel"></i> Exportar Excel
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaConsultas">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Paciente</th>
                        <th>Doctor</th>
                        <th>Especialidad</th>
                        <th>Fecha y Hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Costo (S/)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultas as $consulta)
                        <tr>
                            <td><strong>#{{ $consulta->id }}</strong></td>
                            <td>{{ $consulta->paciente->nombre_completo }}</td>
                            <td>{{ $consulta->doctor->nombre_completo }}</td>
                            <td>{{ $consulta->doctor->especialidad }}</td>
                            <td>{{ $consulta->fecha_hora->format('d/m/Y H:i') }}</td>
                            <td>
                                <span title="{{ $consulta->motivo }}">
                                    {{ substr($consulta->motivo, 0, 30) }}{{ strlen($consulta->motivo) > 30 ? '...' : '' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $consulta->estado == 'Concluida' ? 'success' : ($consulta->estado == 'En Proceso' ? 'info' : ($consulta->estado == 'Cancelada' ? 'danger' : 'warning')) }}">
                                    {{ $consulta->estado }}
                                </span>
                            </td>
                            <td>{{ number_format($consulta->costo, 2) }}</td>
                            <td>
                                <a href="{{ route('consultas.show', $consulta) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No hay consultas que mostrar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted">
                        <strong>Total:</strong> {{ $consultas->count() }} consultas
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="text-muted">
                        <strong>Ingresos:</strong> S/ {{ number_format($consultas->sum('costo'), 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportarExcel() {
    let table = document.getElementById('tablaConsultas');
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
    let blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    let link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'reporte_consultas_' + new Date().getTime() + '.csv';
    link.click();
}
</script>
@endpush
@endsection
