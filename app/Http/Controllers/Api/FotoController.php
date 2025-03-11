<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Memorial;
use Illuminate\Support\Facades\Log;

class FotoController extends Controller
{
    /**
     * Obtener las fotos del memorial principal
     */
    public function principal()
    {
        try {
            // Obtener el primer memorial activo
            $memorial = Memorial::where('estado', true)->first();
            
            // Verificar que el memorial exista
            if (!$memorial) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró un memorial activo'
                ], 404);
            }
            
            $fotos = $memorial->fotos()
                             ->orderBy('orden')
                             ->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $fotos,
                'message' => 'Fotos recuperadas exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener las fotos del memorial principal:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener las fotos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener las fotos de un memorial
     */
    public function index(Memorial $memorial)
    {
        // Verificar que el memorial esté activo
        if (!$memorial->estado) {
            return response()->json(['message' => 'Memorial no encontrado'], 404);
        }
        
        return $memorial->fotos()
                        ->orderBy('orden')
                        ->get();
    }
} 