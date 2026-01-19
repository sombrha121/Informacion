@extends('layouts.app')

@section('title', 'Detalles de Compra')
@section('page-title', 'Información de la Compra')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-cart-check"></i> Compra #{{ $compra->id }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <p><strong>Proveedor:</strong> {{ $compra->proveedor }}</p>
            </div>
            <div class="col-md-4">
                <p><strong>Realizado Por:</strong><br>{{ $compra->realizadoPor->nombre_completo }}</p>
            </div>
            <div class="col-md-4">
                <p><strong>Estado:</strong>
                <span class="badge bg-{{ $compra->estado == 'Recibida' ? 'success' : ($compra->estado == 'Aprobada' ? 'info' : ($compra->estado == 'Cancelada' ? 'danger' : 'warning')) }}">
                    {{ $compra->estado }}
                </span></p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Fecha de Compra:</strong> {{ $compra->fecha_compra->format('d/m/Y') }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Monto Total:</strong> <span class="fs-4 text-primary">S/ {{ number_format($compra->monto_total, 2) }}</span></p>
            </div>
        </div>

        <div class="mb-3">
            <h6><strong>Descripción:</strong></h6>
            <p class="bg-light p-3 rounded">{{ $compra->descripcion }}</p>
        </div>

        @if($compra->observaciones)
            <div class="mb-3">
                <h6><strong>Observaciones:</strong></h6>
                <p class="bg-light p-3 rounded">{{ $compra->observaciones }}</p>
            </div>
        @endif

        <hr>
        
        <h5><i class="bi bi-list-ul"></i> Detalles de la Compra</h5>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compra->detalles as $index => $detalle)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detalle->producto }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>S/ {{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-secondary">
                        <th colspan="4" class="text-end">Total:</th>
                        <th>S/ {{ number_format($compra->monto_total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="{{ route('compras.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <a href="{{ route('compras.edit', $compra) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
        </div>
    </div>
</div>
@endsection
