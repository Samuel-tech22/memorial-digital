<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Memorial;
use Illuminate\Support\Facades\Log;

class LineaTiempoController extends Controller
{
    /**
     * Obtener los eventos de la línea de tiempo del memorial principal
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
            
            $eventos = $memorial->lineaTiempo()
                              ->where('activo', true)
                              ->orderBy('fecha', 'asc')
                              ->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $eventos,
                'message' => 'Eventos de línea de tiempo recuperados exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener los eventos de línea de tiempo:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener los eventos de línea de tiempo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 