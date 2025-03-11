<?php

namespace Database\Seeders;

use App\Models\Footer;
use App\Models\Memorial;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el memorial activo
        $memorial = Memorial::where('estado', true)->first();
        
        if (!$memorial) {
            $this->command->info('No se encontró un memorial activo. No se pueden crear datos de footer.');
            return;
        }
        
        // Verificar si ya existe un footer para este memorial
        $footerExistente = Footer::where('memorial_id', $memorial->id)->exists();
        
        if ($footerExistente) {
            $this->command->info('Ya existe una configuración de footer para el memorial activo.');
            return;
        }
        
        // Crear un footer por defecto
        Footer::create([
            'memorial_id' => $memorial->id,
            'texto_copyright' => '© ' . date('Y') . ' ' . $memorial->nombre . ' ' . $memorial->apellidos . '. Todos los derechos reservados.',
            
            // Enlaces por defecto
            'enlace1_texto' => 'Sobre Nosotros',
            'enlace1_url' => '/sobre-nosotros',
            'enlace1_activo' => true,
            
            'enlace2_texto' => 'Conciérnenos',
            'enlace2_url' => '/contacto',
            'enlace2_activo' => true,
            
            'enlace3_texto' => 'Reportar abuso',
            'enlace3_url' => '/reportar',
            'enlace3_activo' => true,
            
            // Personalización visual
            'color_fondo' => '#1E1A2B',
            'color_texto' => '#FFFFFF',
            'color_enlaces' => '#FFFFFF',
            'padding_top' => '1.5rem',
            'padding_bottom' => '1.5rem',
            
            // Opciones adicionales
            'mostrar_redes_sociales' => true,
        ]);
        
        $this->command->info('Se ha creado la configuración del footer por defecto para el memorial.');
    }
} 