@extends('layouts.app')

@section('title', 'Editar Compra')
@section('page-title', 'Editar Compra')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-pencil"></i> Formulario de Edición de Compra #{{ $compra->id }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('compras.update', $compra) }}" method="POST" id="compraForm">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="proveedor" class="form-label">Proveedor *</label>
                        <input type="text" class="form-control @error('proveedor') is-invalid @enderror" 
                               id="proveedor" name="proveedor" value="{{ old('proveedor', $compra->proveedor) }}" required>
                        @error('proveedor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="realizado_por" class="form-label">Realizado Por *</label>
                        <select class="form-select @error('realizado_por') is-invalid @enderror" 
                                id="realizado_por" name="realizado_por" required>
                            @foreach($personal as $persona)
                                <option value="{{ $persona->id }}" {{ old('realizado_por', $compra->realizado_por) == $persona->id ? 'selected' : '' }}>
                                    {{ $persona->nombre_completo }} - {{ $persona->tipo }}
                                </option>
                            @endforeach
                        </select>
                        @error('realizado_por')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_compra" class="form-label">Fecha de Compra *</label>
                        <input type="date" class="form-control @error('fecha_compra') is-invalid @enderror" 
                               id="fecha_compra" name="fecha_compra" 
                               value="{{ old('fecha_compra', $compra->fecha_compra->format('Y-m-d')) }}" required>
                        @error('fecha_compra')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado *</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="Pendiente" {{ old('estado', $compra->estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Aprobada" {{ old('estado', $compra->estado) == 'Aprobada' ? 'selected' : '' }}>Aprobada</option>
                            <option value="Recibida" {{ old('estado', $compra->estado) == 'Recibida' ? 'selected' : '' }}>Recibida</option>
                            <option value="Cancelada" {{ old('estado', $compra->estado) == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción *</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                          id="descripcion" name="descripcion" rows="2" required>{{ old('descripcion', $compra->descripcion) }}</textarea>
                @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                          id="observaciones" name="observaciones" rows="2">{{ old('observaciones', $compra->observaciones) }}</textarea>
                @error('observaciones')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <hr>
            <h5><i class="bi bi-list-ul"></i> Detalles de la Compra</h5>
            
            <div id="detalles-container">
                @foreach($compra->detalles as $index => $detalle)
                    <div class="detalle-item mb-3 p-3 border rounded">
                        <input type="hidden" name="detalles[{{ $index }}][id]" value="{{ $detalle->id }}">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label">Producto *</label>
                                <input type="text" class="form-control" name="detalles[{{ $index }}][producto]" 
                                       value="{{ old("detalles.$index.producto", $detalle->producto) }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Cantidad *</label>
                                <input type="number" class="form-control cantidad" name="detalles[{{ $index }}][cantidad]" 
                                       min="1" value="{{ old("detalles.$index.cantidad", $detalle->cantidad) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Precio Unit. (S/) *</label>
                                <input type="number" step="0.01" class="form-control precio" 
                                       name="detalles[{{ $index }}][precio_unitario]" min="0" 
                                       value="{{ old("detalles.$index.precio_unitario", $detalle->precio_unitario) }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-danger w-100 btn-remove-detalle" {{ $index === 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-success mb-3" id="btn-add-detalle">
                <i class="bi bi-plus-circle"></i> Agregar Producto
            </button>

            <div class="alert alert-info">
                <strong>Monto Total:</strong> S/ <span id="monto-total">{{ number_format($compra->monto_total, 2) }}</span>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('compras.show', $compra) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Actualizar Compra
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let detalleIndex = {{ count($compra->detalles) }};

document.getElementById('btn-add-detalle').addEventListener('click', function() {
    const container = document.getElementById('detalles-container');
    const newDetalle = `
        <div class="detalle-item mb-3 p-3 border rounded">
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Producto *</label>
                    <input type="text" class="form-control" name="detalles[${detalleIndex}][producto]" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Cantidad *</label>
                    <input type="number" class="form-control cantidad" name="detalles[${detalleIndex}][cantidad]" min="1" value="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Precio Unit. (S/) *</label>
                    <input type="number" step="0.01" class="form-control precio" name="detalles[${detalleIndex}][precio_unitario]" min="0" value="0.00" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-danger w-100 btn-remove-detalle">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newDetalle);
    detalleIndex++;
    actualizarTotal();
});

document.getElementById('detalles-container').addEventListener('click', function(e) {
    if (e.target.closest('.btn-remove-detalle')) {
        e.target.closest('.detalle-item').remove();
        actualizarTotal();
    }
});

document.getElementById('detalles-container').addEventListener('input', function(e) {
    if (e.target.classList.contains('cantidad') || e.target.classList.contains('precio')) {
        actualizarTotal();
    }
});

function actualizarTotal() {
    let total = 0;
    document.querySelectorAll('.detalle-item').forEach(item => {
        const cantidad = parseFloat(item.querySelector('.cantidad').value) || 0;
        const precio = parseFloat(item.querySelector('.precio').value) || 0;
        total += cantidad * precio;
    });
    document.getElementById('monto-total').textContent = total.toFixed(2);
}

// Calcular total inicial
actualizarTotal();
</script>
@endpush
@endsection
