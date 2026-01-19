@extends('layouts.app')

@section('title', 'Nueva Consulta')
@section('page-title', 'Registrar Nueva Consulta')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-clipboard-plus"></i> Formulario de Nueva Consulta</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('consultas.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="paciente_id" class="form-label">Paciente *</label>
                        <input type="hidden" id="paciente_id" name="paciente_id" class="form-control @error('paciente_id') is-invalid @enderror" required>
                        <input type="text" id="paciente_search" class="form-control" placeholder="Buscar por nombre o DNI..." autocomplete="off">
                        <div id="pacientes_list" class="list-group mt-2" style="display:none; max-height: 200px; overflow-y: auto;"></div>
                        @error('paciente_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Doctor *</label>
                        <select class="form-select @error('doctor_id') is-invalid @enderror" 
                                id="doctor_id" name="doctor_id" required>
                            <option value="">Seleccione un doctor...</option>
                            @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->nombre_completo }} - {{ $doctor->especialidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_hora" class="form-label">Fecha y Hora *</label>
                        <input type="datetime-local" class="form-control @error('fecha_hora') is-invalid @enderror" 
                               id="fecha_hora" name="fecha_hora" value="{{ old('fecha_hora', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('fecha_hora')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado *</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="En Proceso" {{ old('estado') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                            <option value="Concluida" {{ old('estado') == 'Concluida' ? 'selected' : '' }}>Concluida</option>
                            <option value="Cancelada" {{ old('estado') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="costo" class="form-label">Costo (S/) *</label>
                        <input type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" 
                               id="costo" name="costo" value="{{ old('costo', '0.00') }}" required>
                        @error('costo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo de la Consulta *</label>
                <textarea class="form-control @error('motivo') is-invalid @enderror" 
                          id="motivo" name="motivo" rows="3" required>{{ old('motivo') }}</textarea>
                @error('motivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="diagnostico" class="form-label">Diagnóstico</label>
                <textarea class="form-control @error('diagnostico') is-invalid @enderror" 
                          id="diagnostico" name="diagnostico" rows="3">{{ old('diagnostico') }}</textarea>
                @error('diagnostico')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                          id="observaciones" name="observaciones" rows="2">{{ old('observaciones') }}</textarea>
                @error('observaciones')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar Consulta
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const paciente_search = document.getElementById('paciente_search');
const pacientes_list = document.getElementById('pacientes_list');
const paciente_id = document.getElementById('paciente_id');

let searchTimeout;
paciente_search.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const query = this.value;
    
    if (query.length < 2) {
        pacientes_list.style.display = 'none';
        return;
    }
    
    searchTimeout = setTimeout(() => {
        fetch('/api/pacientes/search?q=' + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                pacientes_list.innerHTML = '';
                if (data.length === 0) {
                    pacientes_list.innerHTML = '<div class="list-group-item">No se encontraron pacientes</div>';
                } else {
                    data.forEach(paciente => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        item.innerHTML = `<strong>${paciente.nombre}</strong><br><small>${paciente.dni} - ${paciente.edad} años</small>`;
                        item.onclick = (e) => {
                            e.preventDefault();
                            paciente_id.value = paciente.id;
                            paciente_search.value = paciente.nombre;
                            pacientes_list.style.display = 'none';
                        };
                        pacientes_list.appendChild(item);
                    });
                }
                pacientes_list.style.display = 'block';
            });
    }, 300);
});

document.addEventListener('click', (e) => {
    if (e.target !== paciente_search && e.target !== pacientes_list) {
        pacientes_list.style.display = 'none';
    }
});
</script>
@endpush
@endsection
