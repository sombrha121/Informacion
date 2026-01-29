@extends('layouts.app')

@section('title', 'Reporte Financiero')
@section('page-title', 'Reporte Financiero')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h3>S/ {{ number_format($totalIngresos, 2) }}</h3>
                <p class="mb-0">Ingresos Totales</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h3>S/ {{ number_format($totalGastos, 2) }}</h3>
                <p class="mb-0">Gastos Totales</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h3>S/ {{ number_format($totalIngresos - $totalGastos, 2) }}</h3>
                <p class="mb-0">Ganancia Neta</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h3>{{ $margenGanancia }}%</h3>
                <p class="mb-0">Margen de Ganancia</p>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reportes.financiero') }}" class="row g-3">
            <div class="col-md-3">
                <label for="año" class="form-label">Año</label>
                <select class="form-select" id="año" name="año">
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('año', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label for="mes" class="form-label">Mes</label>
                <select class="form-select" id="mes" name="mes">
                    <option value="">Todos los Meses</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }} - {{ ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'][$i-1] }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>
            <div class="col-md-3">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-success w-100" onclick="exportarExcel()">
                    <i class="bi bi-file-earmark-excel"></i> Exportar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Ingresos por Consultas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Concepto</th>
                                <th>Cantidad</th>
                                <th>Monto (S/)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Consultas Completadas</td>
                                <td>{{ $consultasCompletadas }}</td>
                                <td><strong>S/ {{ number_format($ingresoConsultas, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td>Exámenes Realizados</td>
                                <td>{{ $examenesCompletados }}</td>
                                <td><strong>S/ {{ number_format($ingresoExamenes, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td>Tratamientos</td>
                                <td>{{ $tratamientosCompletados }}</td>
                                <td><strong>S/ {{ number_format($ingresoTratamientos, 2) }}</strong></td>
                            </tr>
                            <tr class="table-primary">
                                <td><strong>TOTAL INGRESOS</strong></td>
                                <td><strong>{{ $consultasCompletadas + $examenesCompletados + $tratamientosCompletados }}</strong></td>
                                <td><strong>S/ {{ number_format($totalIngresos, 2) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-cart-fill"></i> Gastos por Compras</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Concepto</th>
                                <th>Cantidad</th>
                                <th>Monto (S/)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Compras Completadas</td>
                                <td>{{ $comprasCompletadas }}</td>
                                <td><strong>S/ {{ number_format($gastoCompras, 2) }}</strong></td>
                            </tr>
                            <tr class="table-danger">
                                <td><strong>TOTAL GASTOS</strong></td>
                                <td><strong>{{ $comprasCompletadas }}</strong></td>
                                <td><strong>S/ {{ number_format($totalGastos, 2) }}</strong></td>
                            </tr>
                            <tr class="table-success">
                                <td><strong>GANANCIA NETA</strong></td>
                                <td colspan="2"><strong>S/ {{ number_format($totalIngresos - $totalGastos, 2) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportarExcel() {
    let año = document.getElementById('año').value;
    let mes = document.getElementById('mes').value;
    
    let fecha = new Date();
    let nombre = 'reporte_financiero_' + año;
    if (mes) {
        nombre += '_' + String(mes).padStart(2, '0');
    }
    nombre += '.csv';
    
    let datos = [
        ['REPORTE FINANCIERO - ' + año + (mes ? ' - ' + mes : '')],
        [],
        ['INGRESOS', '', ''],
        ['Consultas Completadas', '{{ $consultasCompletadas }}', '{{ number_format($ingresoConsultas, 2) }}'],
        ['Exámenes Realizados', '{{ $examenesCompletados }}', '{{ number_format($ingresoExamenes, 2) }}'],
        ['Tratamientos', '{{ $tratamientosCompletados }}', '{{ number_format($ingresoTratamientos, 2) }}'],
        ['TOTAL INGRESOS', '', 'S/ {{ number_format($totalIngresos, 2) }}'],
        [],
        ['GASTOS', '', ''],
        ['Compras', '{{ $comprasCompletadas }}', 'S/ {{ number_format($totalGastos, 2) }}'],
        ['TOTAL GASTOS', '', 'S/ {{ number_format($totalGastos, 2) }}'],
        [],
        ['GANANCIA NETA', '', 'S/ {{ number_format($totalIngresos - $totalGastos, 2) }}'],
        ['MARGEN DE GANANCIA', '', '{{ $margenGanancia }}%']
    ];
    
    let csv = datos.map(row => row.join(',')).join('\n');
    let blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    let link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = nombre;
    link.click();
}
</script>
@endpush
@endsection
