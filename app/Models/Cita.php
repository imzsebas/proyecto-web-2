<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente',
        'fecha',
        'hora',
        'psicologo',
        'duracion',
        'estado',
        'notas'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime:H:i',
    ];

    // Accessor para obtener fecha y hora juntas
    public function getFechaHoraAttribute()
    {
        return Carbon::parse($this->fecha->format('Y-m-d') . ' ' . $this->hora->format('H:i:s'));
    }

    // Accessor para obtener la hora de fin
    public function getHoraFinAttribute()
    {
        return $this->fecha_hora->addMinutes($this->duracion);
    }

    // Scope para citas del día actual
    public function scopeHoy($query)
    {
        return $query->whereDate('fecha', today());
    }

    // Scope para citas próximas
    public function scopeProximas($query)
    {
        return $query->where('fecha', '>=', today())
                    ->where('estado', '!=', 'completada')
                    ->orderBy('fecha')
                    ->orderBy('hora');
    }

    // Scope para citas por estado
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }
}