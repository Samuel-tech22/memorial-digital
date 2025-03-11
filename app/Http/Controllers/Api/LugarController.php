<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Memorial;
use App\Models\Lugar;
use Illuminate\Support\Facades\Log;

class LugarController extends Controller
{
    /**
     * Obtener los lugares del memorial principal
     */
    public function index()
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
            
            $lugares = $memorial->lugares()
                              ->where('activo', true)
                              ->orderBy('orden')
                              ->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $lugares,
                'message' => 'Lugares recuperados exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener los lugares del memorial principal:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener los lugares',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 