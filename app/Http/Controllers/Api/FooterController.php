<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FooterController extends Controller
{
    /**
     * Obtener la configuración del footer del memorial principal
     */
    public function index()
    {
        try {
            // Intentar obtener el footer
            $footer = Footer::obtenerFooterActivo();
            
            // Si no se encuentra un memorial activo
            if (!$footer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró un memorial activo'
                ], 404);
            }
            
            // Preparar datos para la respuesta
            $response = [
                'texto_copyright' => $footer->texto_copyright,
                'enlaces' => $footer->getEnlacesActivos(),
                'estilos' => [
                    'color_fondo' => $footer->color_fondo,
                    'color_texto' => $footer->color_texto,
                    'color_enlaces' => $footer->color_enlaces,
                    'padding_top' => $footer->padding_top,
                    'padding_bottom' => $footer->padding_bottom,
                ],
                'mostrar_logo' => $footer->mostrar_logo,
                'logo_footer' => $footer->logo_footer,
                'mostrar_redes_sociales' => $footer->mostrar_redes_sociales,
            ];
            
            return response()->json([
                'status' => 'success',
                'data' => $response,
                'message' => 'Configuración del footer recuperada exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener configuración del footer:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener la configuración del footer',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 