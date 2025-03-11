<?php

namespace Database\Seeders;

use App\Models\Memorial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class MemorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existe un memorial activo
        $memorialExistente = Memorial::where('estado', true)->exists();
        
        if ($memorialExistente) {
            $this->command->info('Ya existe un memorial activo. No se creará uno nuevo.');
            return;
        }

        // Crear un nuevo memorial
        $memorial = Memorial::create([
            'nombre' => 'Richard',
            'apellidos' => 'Dickson',
            'fecha_nacimiento' => '1945-06-15',
            'fecha_fallecimiento' => '2023-12-10',
            'foto_perfil' => 'richard-dickson.jpg',
            'foto_fondo' => 'playa-tropical.jpg',
            'titulo_cabecera' => 'In Loving Memory of',
            'frase_recordatoria' => 'You taught us to dream!',
            'en_mis_propias_palabras' => 'Aquí compartiré algunos de mis pensamientos y reflexiones sobre la vida...',
            'biografia' => 'Richard Dickson fue un hombre extraordinario que dedicó su vida a inspirar a otros. Desde muy joven, mostró una pasión inquebrantable por ayudar a los demás y por explorar el mundo. Viajó por más de 50 países, aprendiendo de diferentes culturas y compartiendo sus experiencias con todos los que le rodeaban.

Su carrera profesional fue igualmente impresionante, fundando una organización sin fines de lucro dedicada a proporcionar educación a niños en comunidades desfavorecidas. Su lema siempre fue "Aprende, enseña, inspira", palabras que definieron su existencia.

Richard deja un legado de amor, compasión y servicio que continuará inspirando a generaciones futuras. Aunque ya no está físicamente con nosotros, su espíritu permanece en cada vida que tocó.',
            'facebook_url' => 'https://facebook.com/richard.dickson',
            'instagram_url' => 'https://instagram.com/richard.dickson',
            'twitter_url' => 'https://twitter.com/richard_dickson',
            'estado' => true
        ]);

        $this->command->info('Memorial creado exitosamente: ' . $memorial->nombre . ' ' . $memorial->apellidos);
    }
} 