<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EstiloVisual;
use App\Models\Memorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EstiloVisualController extends Controller
{
    /**
     * Obtener los estilos visuales del memorial principal
     */
    public function index()
    {
        try {
            // Intentar obtener los estilos visuales
            $estilo = EstiloVisual::obtenerEstiloActivo();
            
            // Si no se encuentra un memorial activo
            if (!$estilo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró un memorial activo'
                ], 404);
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $estilo,
                'message' => 'Estilos visuales recuperados exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener estilos visuales:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener los estilos visuales',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
