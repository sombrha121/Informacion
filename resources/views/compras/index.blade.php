@extends('layouts.app')

@section('title', 'Compras')
@section('page-title', 'Gestión de Compras e Inventario')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-cart-fill"></i> Lista de Compras</h5>
        <a href="{{ route('compras.create') }}" class="btn btn-light">
            <i class="bi bi-cart-plus"></i> Nueva Compra
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Proveedor</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Monto Total</th>
                        <th>Estado</th>
                        <th>Realizado Por</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($compras as $compra)
                        <tr>
                            <td>{{ $compra->id }}</td>
                            <td>{{ $compra->proveedor }}</td>
                            <td>{{ \Str::limit($compra->descripcion, 40) }}</td>
                            <td>{{ $compra->fecha_compra->format('d/m/Y') }}</td>
                            <td>S/ {{ number_format($compra->monto_total, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $compra->estado == 'Recibida' ? 'success' : ($compra->estado == 'Aprobada' ? 'info' : ($compra->estado == 'Cancelada' ? 'danger' : 'warning')) }}">
                                    {{ $compra->estado }}
                                </span>
                            </td>
                            <td>{{ $compra->realizadoPor->nombre_completo }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('compras.show', $compra) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('compras.comprobante', $compra) }}" class="btn btn-sm btn-success" target="_blank" title="Comprobante">
                                        <i class="bi bi-receipt"></i>
                                    </a>
                                    <a href="{{ route('compras.edit', $compra) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay compras registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $compras->links() }}
        </div>
    </div>
</div>
@endsection
