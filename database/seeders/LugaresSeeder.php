<?php

namespace Database\Seeders;

use App\Models\Lugar;
use App\Models\Memorial;
use Illuminate\Database\Seeder;

class LugaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el memorial existente o salir si no existe
        $memorial = Memorial::where('estado', true)->first();
        
        if (!$memorial) {
            $this->command->info('No se encontró un memorial activo. No se pueden crear lugares.');
            return;
        }
        
        // Agregar algunos lugares de ejemplo
        $lugares = [
            [
                'titulo' => 'Acantilados de Møns Klint',
                'imagen' => 'lugares/acantilados.jpg',
                'descripcion' => 'Impresionantes acantilados blancos en Dinamarca, uno de los lugares favoritos de Richard.',
                'url_relacionada' => 'https://visitdenmark.com/denmark/explore/mons-klint-gdk607895',
                'ubicacion_mapa' => 'https://maps.google.com/?q=54.9674,12.5453',
                'orden' => 1
            ],
            [
                'titulo' => 'Playa de Whitehaven',
                'imagen' => 'lugares/playa.jpg',
                'descripcion' => 'Una de las playas más hermosas del mundo, ubicada en Australia.',
                'url_relacionada' => 'https://www.australia.com/en/places/whitsundays-and-surrounds/guide-to-whitehaven-beach.html',
                'ubicacion_mapa' => 'https://maps.google.com/?q=-20.2758,149.0060',
                'orden' => 2
            ],
            [
                'titulo' => 'Arco de la Puerta',
                'imagen' => 'lugares/arco.jpg',
                'descripcion' => 'Formación rocosa natural en Malta que Richard visitó durante sus viajes.',
                'url_relacionada' => 'https://www.visitmalta.com/en/azure-window',
                'ubicacion_mapa' => 'https://maps.google.com/?q=36.0514,14.1836',
                'orden' => 3
            ],
            [
                'titulo' => 'Costa de California',
                'imagen' => 'lugares/costa.jpg',
                'descripcion' => 'Hermosas vistas de la costa de California donde Richard pasó su juventud.',
                'url_relacionada' => 'https://www.visitcalifornia.com/places-to-visit/north-coast/',
                'ubicacion_mapa' => 'https://maps.google.com/?q=36.3615,-121.8563',
                'orden' => 4
            ],
            [
                'titulo' => 'Muelle de Santa Mónica',
                'imagen' => 'lugares/muelle.jpg',
                'descripcion' => 'El histórico muelle de Santa Mónica, lugar donde Richard conoció a su esposa.',
                'url_relacionada' => 'https://www.santamonica.com/what-to-do/santa-monica-pier/',
                'ubicacion_mapa' => 'https://maps.google.com/?q=34.0103,-118.4961',
                'orden' => 5
            ]
        ];
        
        foreach ($lugares as $lugar) {
            Lugar::updateOrCreate(
                [
                    'memorial_id' => $memorial->id,
                    'titulo' => $lugar['titulo']
                ],
                array_merge(
                    $lugar,
                    ['memorial_id' => $memorial->id]
                )
            );
        }
        
        $this->command->info('Se han creado 5 lugares para el memorial');
    }
} 