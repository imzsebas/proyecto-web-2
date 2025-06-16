<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnlaceSesion extends Model
{
    use HasFactory;

    protected $table = 'enlaces_sesion';

    protected $fillable = [
        'nombre',
        'enlace',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Obtener el enlace activo más reciente
     */
    public static function obtenerEnlaceActivo()
    {
        return self::where('activo', true)
                   ->orderBy('created_at', 'desc')
                   ->first();
    }
}