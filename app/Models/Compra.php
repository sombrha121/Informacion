<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'realizado_por',
        'proveedor',
        'descripcion',
        'monto_total',
        'fecha_compra',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'monto_total' => 'decimal:2',
    ];

    // Relaciones
    public function realizadoPor()
    {
        return $this->belongsTo(Personal::class, 'realizado_por');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class);
    }
}
