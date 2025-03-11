<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Memorial;
use App\Models\Tributo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TributoController extends Controller
{
    /**
     * Obtener los tributos del memorial principal
     */
    public function index(Request $request)
    {
        try {
            // Obtener el memorial activo
            $memorial = Memorial::where('estado', true)->first();
            
            if (!$memorial) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró un memorial activo'
                ], 404);
            }
            
            $query = $memorial->tributos()->where('aprobado', true);
            
            // Filtrar por vista específica (para mapa)
            if ($request->has('vista') && $request->vista === 'mapa') {
                $query->where('mostrar_en_mapa', true)
                      ->whereNotNull('latitud')
                      ->whereNotNull('longitud');
            }
            
            $tributos = $query->orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $tributos,
                'message' => 'Tributos recuperados exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener tributos:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener los tributos',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Almacenar un nuevo tributo
     */
    public function store(Request $request)
    {
        try {
            // Validar la entrada
            $validator = Validator::make($request->all(), [
                'nombre_remitente' => 'required|string|max:255',
                'email_remitente' => 'nullable|email|max:255',
                'mensaje' => 'required|string',
                'foto_remitente' => 'nullable|image|max:2048', // 2MB max
                'ciudad' => 'nullable|string|max:255',
                'estado' => 'nullable|string|max:255',
                'pais' => 'nullable|string|max:255',
                'latitud' => 'nullable|numeric',
                'longitud' => 'nullable|numeric',
                'relacion' => 'nullable|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validación fallida',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Obtener el memorial activo
            $memorial = Memorial::where('estado', true)->first();
            
            if (!$memorial) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró un memorial activo'
                ], 404);
            }
            
            // Manejo de la foto
            $fotoPath = null;
            if ($request->hasFile('foto_remitente')) {
                $fotoPath = $request->file('foto_remitente')->store('tributos/fotos', 'public');
            }
            
            // Crear el tributo
            $tributo = new Tributo([
                'memorial_id' => $memorial->id,
                'nombre_remitente' => $request->nombre_remitente,
                'email_remitente' => $request->email_remitente,
                'mensaje' => $request->mensaje,
                'foto_remitente' => $fotoPath,
                'ciudad' => $request->ciudad,
                'estado' => $request->estado,
                'pais' => $request->pais,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
                'relacion' => $request->relacion,
                'mostrar_en_mapa' => $request->has('latitud') && $request->has('longitud'),
                'aprobado' => false // Requiere aprobación manual
            ]);
            
            $tributo->save();
            
            return response()->json([
                'status' => 'success',
                'data' => $tributo,
                'message' => 'Tributo enviado exitosamente y está pendiente de aprobación'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear tributo:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el tributo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 