<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'dni',
        'tipo',
        'especialidad',
        'telefono',
        'email',
        'fecha_contratacion',
        'estado',
    ];

    protected $casts = [
        'fecha_contratacion' => 'date',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'doctor_id');
    }

    public function examenesSolicitados()
    {
        return $this->hasMany(Examen::class, 'solicitado_por');
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class, 'doctor_id');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'realizado_por');
    }

    // Accesor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
