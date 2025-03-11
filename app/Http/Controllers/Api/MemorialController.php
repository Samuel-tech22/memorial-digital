<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Memorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MemorialController extends Controller
{
    /**
     * Obtener los datos del memorial principal
     * Este método devuelve los datos del memorial único que se mostrará en la página principal
     */
    public function principal()
    {
        try {
            // Obtener el primer memorial activo (sin cargar relaciones)
            $memorial = Memorial::where('estado', true)->first();

            // Si no hay ningún memorial activo
            if (!$memorial) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró un memorial activo'
                ], 404);
            }
            
            // Estructurar la respuesta solo con datos básicos del memorial
            $response = [
                'id' => $memorial->id,
                'nombre_completo' => $memorial->nombre . ' ' . $memorial->apellidos,
                'nombre' => $memorial->nombre,
                'apellidos' => $memorial->apellidos,
                'titulo_cabecera' => $memorial->titulo_cabecera,
                'foto_perfil' => $memorial->foto_perfil,
                'foto_fondo' => $memorial->foto_fondo,
                'fecha_nacimiento' => $memorial->fecha_nacimiento->format('Y-m-d'),
                'fecha_fallecimiento' => $memorial->fecha_fallecimiento->format('Y-m-d'),
                'frase_recordatoria' => $memorial->frase_recordatoria,
                'en_mis_propias_palabras' => $memorial->en_mis_propias_palabras,
                'biografia' => $memorial->biografia,
                'pdf_biografia' => $memorial->pdf_biografia,
                'redes_sociales' => [
                    'facebook' => $memorial->facebook_url,
                    'instagram' => $memorial->instagram_url,
                    'twitter' => $memorial->twitter_url,
                ],
            ];
            
            return response()->json([
                'status' => 'success',
                'data' => $response,
                'message' => 'Memorial recuperado exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener el memorial principal:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener el memorial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener listado de memoriales con paginación
     * Este método se mantiene por compatibilidad, pero no se usará en la nueva estructura
     */
    public function index(Request $request)
    {
        try {
            $query = Memorial::where('estado', true);

            
            // Búsqueda por nombre o apellidos
            if ($request->has('q')) {
                $searchTerm = $request->q;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('nombre', 'like', "%{$searchTerm}%")
                      ->orWhere('apellidos', 'like', "%{$searchTerm}%");
                });
            }
            
            $memoriales = $query->orderBy('fecha_fallecimiento', 'desc')
                              ->paginate(10);

            // Log para depuración
            Log::info('Memoriales encontrados:', ['count' => $memoriales->count()]);
            
            return response()->json([
                'status' => 'success',
                'data' => $memoriales,
                'message' => 'Memoriales recuperados exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener memoriales:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener los memoriales',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un memorial específico
     * Este método se mantiene por compatibilidad, pero no se usará en la nueva estructura
     */
    public function show(Memorial $memorial)
    {
        try {
            if (!$memorial->estado) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Memorial no encontrado'
                ], 404);
            }
            
            // Ya no cargamos relaciones

            return response()->json([
                'status' => 'success',
                'data' => $memorial,
                'message' => 'Memorial recuperado exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener memorial específico:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener el memorial',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 