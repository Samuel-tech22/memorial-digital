<?php

namespace Database\Seeders;

use App\Models\EstiloVisual;
use App\Models\Memorial;
use Illuminate\Database\Seeder;

class EstiloVisualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el memorial activo
        $memorial = Memorial::where('estado', true)->first();
        
        if (!$memorial) {
            $this->command->info('No se encontró un memorial activo. No se pueden crear estilos visuales.');
            return;
        }
        
        // Verificar si ya existe un estilo para este memorial
        $estiloExistente = EstiloVisual::where('memorial_id', $memorial->id)->exists();
        
        if ($estiloExistente) {
            $this->command->info('Ya existe un estilo visual para el memorial activo.');
            return;
        }
        
        // Crear un estilo por defecto con tema "Memoria Serena"
        EstiloVisual::create([
            'memorial_id' => $memorial->id,
            'color_primario' => '#3B82F6', // Azul
            'color_secundario' => '#10B981', // Verde
            'color_acento' => '#F59E0B', // Ámbar
            'color_fondo' => '#F8FAFC', // Gris muy claro
            'color_texto' => '#334155', // Gris azulado
            
            // Cabecera
            'color_fondo_cabecera' => '#1E3A8A', // Azul más oscuro
            'color_texto_cabecera' => '#FFFFFF', // Blanco
            
            // Menú
            'color_fondo_menu' => '#F1F5F9', // Gris claro
            'color_texto_menu' => '#64748B', // Gris medio
            'color_menu_activo' => '#3B82F6', // Azul
            'color_texto_menu_activo' => '#FFFFFF', // Blanco
            
            // Secciones
            'color_separador_seccion' => '#E2E8F0', // Gris claro
            'color_fondo_seccion' => '#FFFFFF', // Blanco
            'color_titulo_seccion' => '#0F172A', // Azul muy oscuro
            
            // Tarjetas/Elementos
            'color_fondo_tarjeta' => '#FFFFFF', // Blanco
            'color_borde_tarjeta' => '#E2E8F0', // Gris claro
            'radio_borde_tarjeta' => '0.75rem', // Bordes más redondeados
            
            // Botones
            'color_boton_primario' => '#3B82F6', // Azul
            'color_texto_boton_primario' => '#FFFFFF', // Blanco
            'color_boton_secundario' => '#64748B', // Gris medio
            'color_texto_boton_secundario' => '#FFFFFF', // Blanco
            
            // Fuentes
            'fuente_titulos' => 'Playfair Display, serif',
            'fuente_texto' => 'Lato, sans-serif',
            
            // Línea de tiempo
            'color_linea_tiempo' => '#3B82F6', // Azul
            'color_marcador_tiempo' => '#2563EB', // Azul más oscuro
            
            // Mapa
            'color_marcador_mapa' => '#F59E0B', // Ámbar
            
            // Extras
            'usar_imagen_fondo' => false,
            'modo_oscuro' => false,
        ]);
        
        $this->command->info('Se ha creado el estilo visual por defecto para el memorial.');
    }
}
