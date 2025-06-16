<?php

namespace App\Http\Controllers;

use App\Models\EnlaceSesion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EnlaceSesionController extends Controller
{
    /**
     * Obtener el enlace activo actual
     */
    public function obtenerEnlaceActivo(): JsonResponse
    {
        $enlace = EnlaceSesion::obtenerEnlaceActivo();
        
        return response()->json([
            'success' => true,
            'enlace' => $enlace ? $enlace->enlace : 'https://meet.google.com/iqh-ivmz-mrv',
            'nombre' => $enlace ? $enlace->nombre : 'Sesión Virtual'
        ]);
    }

    /**
     * Guardar un nuevo enlace
     */
    public function guardarEnlace(Request $request): JsonResponse
    {
        $request->validate([
            'enlace' => 'required|url',
            'nombre' => 'nullable|string|max:255'
        ]);

        // Desactivar enlaces anteriores
        EnlaceSesion::where('activo', true)->update(['activo' => false]);

        // Crear el nuevo enlace
        $nuevoEnlace = EnlaceSesion::create([
            'nombre' => $request->nombre ?? 'Sesión Virtual',
            'enlace' => $request->enlace,
            'activo' => true
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => 'Enlace guardado correctamente',
            'enlace' => $nuevoEnlace
        ]);
    }

    /**
     * Obtener historial de enlaces
     */
    public function historial(): JsonResponse
    {
        $enlaces = EnlaceSesion::orderBy('created_at', 'desc')
                              ->take(10)
                              ->get();

        return response()->json([
            'success' => true,
            'enlaces' => $enlaces
        ]);
    }
}