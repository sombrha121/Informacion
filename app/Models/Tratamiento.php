<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    protected $table = 'tratamientos';

    protected $fillable = [
        'paciente_id',
        'consulta_id',
        'doctor_id',
        'nombre_tratamiento',
        'descripcion',
        'medicamentos',
        'indicaciones',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'costo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'costo' => 'decimal:2',
    ];

    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Personal::class, 'doctor_id');
    }

    public const ESTADOS_VALIDOS = ['Pendiente', 'En Proceso', 'Completado', 'Cancelado'];
    public const TRANSICIONES_VALIDAS = [
        'Pendiente' => ['En Proceso', 'Cancelado'],
        'En Proceso' => ['Completado', 'Cancelado'],
        'Completado' => [],
        'Cancelado' => [],
    ];

    public function puedeTransicionarA(string $nuevoEstado): bool
    {
        $estadoActual = $this->estado;
        $transicionesPermitidas = self::TRANSICIONES_VALIDAS[$estadoActual] ?? [];
        return in_array($nuevoEstado, $transicionesPermitidas);
    }
}
