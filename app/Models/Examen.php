<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $table = 'examenes';

    protected $fillable = [
        'paciente_id',
        'consulta_id',
        'solicitado_por',
        'tipo_examen',
        'descripcion',
        'fecha_solicitud',
        'fecha_realizacion',
        'resultados',
        'estado',
        'costo',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_realizacion' => 'datetime',
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

    public function solicitante()
    {
        return $this->belongsTo(Personal::class, 'solicitado_por');
    }

    public const ESTADOS_VALIDOS = ['Solicitado', 'En Proceso', 'Concluido', 'Cancelado'];
    public const TRANSICIONES_VALIDAS = [
        'Solicitado' => ['En Proceso', 'Cancelado'],
        'En Proceso' => ['Concluido', 'Cancelado'],
        'Concluido' => [],
        'Cancelado' => [],
    ];

    public function puedeTransicionarA(string $nuevoEstado): bool
    {
        $estadoActual = $this->estado;
        $transicionesPermitidas = self::TRANSICIONES_VALIDAS[$estadoActual] ?? [];
        return in_array($nuevoEstado, $transicionesPermitidas);
    }
}
