<?php

namespace Database\Seeders;

use App\Models\Memorial;
use App\Models\Tributo;
use Illuminate\Database\Seeder;

class TributoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el memorial activo
        $memorial = Memorial::where('estado', true)->first();
        
        if (!$memorial) {
            $this->command->info('No se encontró un memorial activo. No se pueden crear tributos.');
            return;
        }
        
        // Crear tributos de ejemplo con ubicaciones en el mapa
        $tributos = [
            [
                'nombre_remitente' => 'Gina Wilson',
                'email_remitente' => 'gina@example.com',
                'mensaje' => 'He was such an awesome person. He was thoughtful, giving, humble, funny, and always made others feel good about themselves. He was truly missed by all of us.',
                'ciudad' => 'Chicago',
                'estado' => 'Illinois',
                'pais' => 'USA',
                'latitud' => 41.8781,
                'longitud' => -87.6298,
                'relacion' => 'Friend',
                'aprobado' => true
            ],
            [
                'nombre_remitente' => 'Michael Johnson',
                'email_remitente' => 'michael@example.com',
                'mensaje' => 'I will always remember our fishing trips. You were a wonderful mentor and friend.',
                'ciudad' => 'Miami',
                'estado' => 'Florida',
                'pais' => 'USA',
                'latitud' => 25.7617,
                'longitud' => -80.1918,
                'relacion' => 'Colleague',
                'aprobado' => true
            ],
            [
                'nombre_remitente' => 'Sarah Adams',
                'email_remitente' => 'sarah@example.com',
                'mensaje' => 'Your kindness and wisdom changed my life. Thank you for everything.',
                'ciudad' => 'New York',
                'estado' => 'NY',
                'pais' => 'USA',
                'latitud' => 40.7128,
                'longitud' => -74.0060,
                'relacion' => 'Family',
                'aprobado' => true
            ],
            [
                'nombre_remitente' => 'Robert Lee',
                'email_remitente' => 'robert@example.com',
                'mensaje' => 'We had the best times together. Your memory lives on in all of us.',
                'ciudad' => 'Los Angeles',
                'estado' => 'California',
                'pais' => 'USA',
                'latitud' => 34.0522,
                'longitud' => -118.2437,
                'relacion' => 'Friend',
                'aprobado' => true
            ],
            [
                'nombre_remitente' => 'Jennifer Martinez',
                'email_remitente' => 'jennifer@example.com',
                'mensaje' => 'Thank you for being such an inspiration to everyone who knew you.',
                'ciudad' => 'Dallas',
                'estado' => 'Texas',
                'pais' => 'USA',
                'latitud' => 32.7767,
                'longitud' => -96.7970,
                'relacion' => 'Colleague',
                'aprobado' => true
            ],
            [
                'nombre_remitente' => 'David Thompson',
                'email_remitente' => 'david@example.com',
                'mensaje' => 'Your legacy continues through all the lives you touched.',
                'ciudad' => 'Seattle',
                'estado' => 'Washington',
                'pais' => 'USA',
                'latitud' => 47.6062,
                'longitud' => -122.3321,
                'relacion' => 'Neighbor',
                'aprobado' => true
            ],
            [
                'nombre_remitente' => 'Maria Garcia',
                'email_remitente' => 'maria@example.com',
                'mensaje' => 'You always knew how to make everyone smile. We miss you dearly.',
                'ciudad' => 'San Diego',
                'estado' => 'California',
                'pais' => 'USA',
                'latitud' => 32.7157,
                'longitud' => -117.1611,
                'relacion' => 'Family Friend',
                'aprobado' => true
            ],
            [
                'nombre_remitente' => 'James Brown',
                'email_remitente' => 'james@example.com',
                'mensaje' => 'Our fishing trips were the highlight of my summers. Rest in peace, old friend.',
                'ciudad' => 'Portland',
                'estado' => 'Oregon',
                'pais' => 'USA',
                'latitud' => 45.5051,
                'longitud' => -122.6750,
                'relacion' => 'Friend',
                'aprobado' => true
            ]
        ];
        
        foreach ($tributos as $tributoData) {
            Tributo::updateOrCreate(
                [
                    'memorial_id' => $memorial->id,
                    'nombre_remitente' => $tributoData['nombre_remitente'],
                    'email_remitente' => $tributoData['email_remitente']
                ],
                array_merge(
                    $tributoData,
                    [
                        'memorial_id' => $memorial->id, 
                        'mostrar_en_mapa' => true,
                        'foto_remitente' => null // Puedes agregar fotos más tarde
                    ]
                )
            );
        }
        
        $this->command->info('Se han creado tributos de ejemplo con ubicaciones en el mapa');
    }
} 