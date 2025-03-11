<?php

namespace Database\Seeders;

use App\Models\Foto;
use App\Models\Memorial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class FotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el memorial activo
        $memorial = Memorial::where('estado', true)->first();
        
        if (!$memorial) {
            $this->command->info('No se encontró un memorial activo. No se pueden crear fotos.');
            return;
        }
        
        // Crear fotos de ejemplo para el memorial
        $fotos = [
            [
                'url' => 'fotos/foto1.jpg',
                'titulo' => 'Viaje a las montañas',
                'descripcion' => 'Richard disfrutando de un día de senderismo en las montañas Rocosas.',
                'orden' => 1
            ],
            [
                'url' => 'fotos/foto2.jpg',
                'titulo' => 'Celebración familiar',
                'descripcion' => 'Una reunión familiar donde Richard compartió momentos especiales con sus seres queridos.',
                'orden' => 2
            ],
            [
                'url' => 'fotos/foto3.jpg',
                'titulo' => 'En el trabajo',
                'descripcion' => 'Richard dedicado a su pasión por ayudar a otros a través de su fundación.',
                'orden' => 3
            ],
            [
                'url' => 'fotos/foto4.jpg',
                'titulo' => 'Juventud',
                'descripcion' => 'Richard en sus años de universidad, cuando comenzó a interesarse por el trabajo humanitario.',
                'orden' => 4
            ],
            [
                'url' => 'fotos/foto5.jpg',
                'titulo' => 'De vacaciones',
                'descripcion' => 'Disfrutando de unas merecidas vacaciones en la playa con amigos cercanos.',
                'orden' => 5
            ],
            [
                'url' => 'fotos/foto6.jpg',
                'titulo' => 'Conferencia internacional',
                'descripcion' => 'Richard dando una charla inspiradora sobre el impacto del voluntariado.',
                'orden' => 6
            ],
            [
                'url' => 'fotos/foto7.jpg',
                'titulo' => 'Con su mascota',
                'descripcion' => 'Richard y su fiel compañero Max, quien lo acompañó durante más de 15 años.',
                'orden' => 7
            ],
            [
                'url' => 'fotos/foto8.jpg',
                'titulo' => 'Celebrando su cumpleaños',
                'descripcion' => 'Una celebración especial por su 70 cumpleaños rodeado de familiares y amigos.',
                'orden' => 8
            ],
            [
                'url' => 'fotos/foto9.jpg',
                'titulo' => 'Voluntariado',
                'descripcion' => 'Richard participando en un proyecto de construcción de escuelas en África.',
                'orden' => 9
            ]
        ];
        
        foreach ($fotos as $fotoData) {
            Foto::updateOrCreate(
                [
                    'memorial_id' => $memorial->id,
                    'url' => $fotoData['url']
                ],
                array_merge(
                    $fotoData,
                    ['memorial_id' => $memorial->id]
                )
            );
        }
        
        $this->command->info('Se han creado ' . count($fotos) . ' fotos de ejemplo para el memorial');
    }
} 