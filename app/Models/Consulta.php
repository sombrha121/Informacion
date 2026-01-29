<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'doctor_id',
        'fecha_hora',
        'motivo',
        'diagnostico',
        'observaciones',
        'estado',
        'costo',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'costo' => 'decimal:2',
    ];

    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Personal::class, 'doctor_id');
    }

    public function examenes()
    {
        return $this->hasMany(Examen::class);
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class);
    }

    /**
     * Estados permitidos
     */
    public const ESTADOS_VALIDOS = ['Programada', 'En Proceso', 'Concluida', 'Cancelada'];
    
    /**
     * Transiciones de estado válidas
     */
    public const TRANSICIONES_VALIDAS = [
        'Programada' => ['En Proceso', 'Cancelada'],
        'En Proceso' => ['Concluida', 'Cancelada'],
        'Concluida' => [],
        'Cancelada' => [],
    ];

    /**
     * Validar si la transición de estado es permitida
     */
    public function puedeTransicionarA(string $nuevoEstado): bool
    {
        if (!in_array($nuevoEstado, self::ESTADOS_VALIDOS)) {
            return false;
        }

        $estadoActual = $this->estado;
        $transicionesPermitidas = self::TRANSICIONES_VALIDAS[$estadoActual] ?? [];

        return in_array($nuevoEstado, $transicionesPermitidas);
    }

    /**
     * Obtener mensaje de error si la transición no es válida
     */
    public function obtenerErrorTransicion(string $nuevoEstado): ?string
    {
        if (!$this->puedeTransicionarA($nuevoEstado)) {
            $estadoActual = $this->estado;
            return "No se puede cambiar de '$estadoActual' a '$nuevoEstado'";
        }
        return null;
    }
}
