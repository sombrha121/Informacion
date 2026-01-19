<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'email',
        'direccion',
        'grupo_sanguineo',
        'alergias',
        'enfermedades_cronicas',
        'tipo_sangre',
        'enfermedades_previas',
        'medicamentos_habituales',
        'contacto_emergencia',
        'estado',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // Relaciones
    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function examenes()
    {
        return $this->hasMany(Examen::class);
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class);
    }

    // Accesor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    // Accesor para edad
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento->age;
    }
}
