<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Cita::orderBy('fecha')
                    ->orderBy('hora')
                    ->paginate(10);
        
        $citasHoy = Cita::hoy()->count();
        $proximaCita = Cita::proximas()->first();
        
        return view('citas.index', compact('citas', 'citasHoy', 'proximaCita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('citas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente' => 'required|string|max:255',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'psicologo' => 'required|string|max:255',
            'duracion' => 'required|integer|min:15|max:180',
            'notas' => 'nullable|string'
        ]);

        Cita::create($validated);

        return redirect()->route('citas.index')
                        ->with('success', 'Cita creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cita $cita)
    {
        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cita $cita)
    {
        return view('citas.edit', compact('cita'));
    }

    /**
 * Obtener datos de una cita para edición (AJAX)
 */
public function editData(Cita $cita)
{
    return response()->json([
        'paciente' => $cita->paciente,
        'psicologo' => $cita->psicologo,
        'fecha' => $cita->fecha->format('Y-m-d'),
        'hora' => $cita->hora->format('H:i'),
        'duracion' => $cita->duracion,
        'estado' => $cita->estado,
        'notas' => $cita->notas
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cita $cita)
    {
        $validated = $request->validate([
            'paciente' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'psicologo' => 'required|string|max:255',
            'duracion' => 'required|integer|min:15|max:180',
            'estado' => 'required|in:programada,confirmada,completada,cancelada',
            'notas' => 'nullable|string'
        ]);

        $cita->update($validated);

        return redirect()->route('citas.index')
                        ->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cita $cita)
    {
        $cita->delete();

        return redirect()->route('citas.index')
                        ->with('success', 'Cita eliminada exitosamente.');
    }

    /**
     * Confirmar una cita
     */
    public function confirmar(Cita $cita)
    {
        $cita->update(['estado' => 'confirmada']);

        return response()->json([
            'success' => true,
            'message' => 'Cita confirmada exitosamente.'
        ]);
    }

    /**
     * Completar una cita
     */
    public function completar(Cita $cita)
    {
        $cita->update(['estado' => 'completada']);

        return response()->json([
            'success' => true,
            'message' => 'Cita marcada como completada.'
        ]);
    }

    /**
     * Obtener citas para el calendario
     */
    public function calendario()
    {
        $citas = Cita::all()->map(function ($cita) {
            return [
                'id' => $cita->id,
                'title' => $cita->paciente,
                'start' => $cita->fecha_hora->toISOString(),
                'end' => $cita->hora_fin->toISOString(),
                'backgroundColor' => $this->getColorByEstado($cita->estado),
                'extendedProps' => [
                    'psicologo' => $cita->psicologo,
                    'estado' => $cita->estado,
                    'duracion' => $cita->duracion,
                    'notas' => $cita->notas
                ]
            ];
        });

        return response()->json($citas);
    }

    private function getColorByEstado($estado)
    {
        return match($estado) {
            'programada' => '#6c757d',
            'confirmada' => '#0dcaf0',
            'completada' => '#198754',
            'cancelada' => '#dc3545',
            default => '#6c757d'
        };
    }
}