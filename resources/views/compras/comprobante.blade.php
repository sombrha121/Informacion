@extends('layouts.app')

@section('title', 'Comprobante de Compra')
@section('page-title', 'Comprobante de Compra')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0"><i class="bi bi-receipt"></i> Comprobante de Compra #{{ $compra->id }}</h5>
            <small class="text-muted">Generado el {{ now()->format('d/m/Y H:i') }}</small>
        </div>
        <div class="d-print-none">
            <button class="btn btn-outline-secondary" onclick="window.print()">
                <i class="bi bi-printer"></i> Imprimir
            </button>
            <a href="{{ route('compras.show', $compra) }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-uppercase text-muted">Proveedor</h6>
                <p class="mb-0 fw-bold">{{ $compra->proveedor }}</p>
                <p class="text-muted mb-0">{{ $compra->descripcion }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h6 class="text-uppercase text-muted">Datos de la Compra</h6>
                <p class="mb-0"><strong>Fecha:</strong> {{ $compra->fecha_compra->format('d/m/Y') }}</p>
                <p class="mb-0"><strong>Estado:</strong>
                    <span class="badge bg-{{ $compra->estado == 'Recibida' ? 'success' : ($compra->estado == 'Aprobada' ? 'info' : ($compra->estado == 'Cancelada' ? 'danger' : 'warning')) }}">
                        {{ $compra->estado }}
                    </span>
                </p>
                <p class="mb-0"><strong>Realizado por:</strong> {{ $compra->realizadoPor->nombre_completo }}</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th class="text-end">Cantidad</th>
                        <th class="text-end">Precio Unitario</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compra->detalles as $index => $detalle)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detalle->producto }}</td>
                            <td class="text-end">{{ $detalle->cantidad }}</td>
                            <td class="text-end">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td class="text-end">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th class="text-end fs-5">S/ {{ number_format($compra->monto_total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($compra->observaciones)
            <div class="mt-3">
                <h6 class="text-uppercase text-muted">Observaciones</h6>
                <p class="mb-0">{{ $compra->observaciones }}</p>
            </div>
        @endif
    </div>
</div>

<style>
@media print {
    body { background: #fff; }
    .card { box-shadow: none !important; }
    .card-header .d-print-none { display: none !important; }
}
</style>
@endsection
