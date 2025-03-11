<?php

namespace Database\Seeders;

use App\Models\LineaTiempo;
use App\Models\Memorial;
use Illuminate\Database\Seeder;

class LineaTiempoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el memorial existente o salir si no existe
        $memorial = Memorial::where('estado', true)->first();
        
        if (!$memorial) {
            $this->command->info('No se encontró un memorial activo. No se pueden crear eventos de línea de tiempo.');
            return;
        }
        
        // Agregar eventos de línea de tiempo de ejemplo
        $eventos = [
            [
                'titulo' => 'Born in Paterson, New Jersey, the first child of Ken & Linda Kinsey',
                'descripcion' => 'Richard nació en el Hospital General de Paterson, un día lluvioso de primavera.',
                'fecha' => '1945-05-03',
                'ubicacion' => 'Paterson, New Jersey',
                'orden' => 1
            ],
            [
                'titulo' => 'Graduated from Pierce College with a Bachelors Degree in Accounting',
                'descripcion' => 'Se graduó con honores y fue el orador de su clase durante la ceremonia.',
                'fecha' => '1967-06-15',
                'ubicacion' => 'Los Angeles, California',
                'orden' => 2
            ],
            [
                'titulo' => 'Met Linda Simpson, her future sweetheart',
                'descripcion' => 'Se conocieron durante una fiesta en la playa organizada por amigos en común.',
                'fecha' => '1968-07-22',
                'ubicacion' => 'Santa Monica, California',
                'orden' => 3
            ],
            [
                'titulo' => 'Married Harold Simpson, her High School sweetheart',
                'descripcion' => 'La ceremonia se celebró en la iglesia local con familiares y amigos cercanos.',
                'fecha' => '1969-09-18',
                'ubicacion' => 'Beverly Hills, California',
                'orden' => 4
            ],
            [
                'titulo' => 'Gave birth to twins, Patrick & Carolyn, in Hackensack, NJ',
                'descripcion' => 'Los gemelos nacieron saludables en el Hospital Universitario de Hackensack.',
                'fecha' => '1971-03-12',
                'ubicacion' => 'Hackensack, New Jersey',
                'orden' => 5
            ],
        ];
        
        foreach ($eventos as $evento) {
            LineaTiempo::updateOrCreate(
                [
                    'memorial_id' => $memorial->id,
                    'titulo' => $evento['titulo']
                ],
                array_merge(
                    $evento,
                    ['memorial_id' => $memorial->id]
                )
            );
        }
        
        $this->command->info('Se han creado 5 eventos de línea de tiempo para el memorial');
    }
} 