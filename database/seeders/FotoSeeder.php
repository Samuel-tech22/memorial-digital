<?php

namespace Database\Seeders;

use App\Models\Foto;
use App\Models\Memorial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
        
        // Verificar si ya existen fotos para este memorial
        if (Foto::where('memorial_id', $memorial->id)->exists()) {
            $this->command->info('Ya existen fotos para el memorial activo.');
            return;
        }
        
        // Crear directorio para fotos si no existe
        Storage::disk('public')->makeDirectory('memoriales/fotos');
        
        // Copiar imágenes de ejemplo a storage/app/public/memoriales/fotos
        $this->copyExampleImages();
        
        // Crear fotos de ejemplo para el memorial
        $fotos = [
            [
                'url' => 'memoriales/fotos/ejemplo1.jpg',
                'titulo' => 'Viaje a las montañas',
                'descripcion' => 'Richard disfrutando de un día de senderismo en las montañas Rocosas.',
                'orden' => 1
            ],
            [
                'url' => 'memoriales/fotos/ejemplo2.jpg',
                'titulo' => 'Celebración familiar',
                'descripcion' => 'Una reunión familiar donde Richard compartió momentos especiales con sus seres queridos.',
                'orden' => 2
            ],
            [
                'url' => 'memoriales/fotos/ejemplo3.jpg',
                'titulo' => 'En el trabajo',
                'descripcion' => 'Richard dedicado a su pasión por ayudar a otros a través de su fundación.',
                'orden' => 3
            ],
            [
                'url' => 'memoriales/fotos/ejemplo4.jpg',
                'titulo' => 'Juventud',
                'descripcion' => 'Richard en sus años de universidad, cuando comenzó a interesarse por el trabajo humanitario.',
                'orden' => 4
            ],
            [
                'url' => 'memoriales/fotos/ejemplo5.jpg',
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
            Foto::create([
                'memorial_id' => $memorial->id,
                'url' => $fotoData['url'],
                'titulo' => $fotoData['titulo'],
                'descripcion' => $fotoData['descripcion'],
                'orden' => $fotoData['orden'],
            ]);
        }
        
        $this->command->info('Se han creado ' . count($fotos) . ' fotos de ejemplo para el memorial.');
    }
    
    /**
     * Copiar imágenes de ejemplo a storage/app/public/memoriales/fotos
     */
    private function copyExampleImages()
    {
        // Directorio de origen en el proyecto (database/seeders/example_images)
        $sourceDir = database_path('seeders/example_images');
        
        // Si no existe el directorio de origen, crear imágenes dummy
        if (!File::exists($sourceDir)) {
            $this->createDummyImages();
            return;
        }
        
        // Copiar imágenes existentes
        $files = File::files($sourceDir);
        foreach ($files as $file) {
            $filename = $file->getFilename();
            $newFilename = 'ejemplo' . substr($filename, -5); // Renombrar como ejemplo1.jpg, ejemplo2.jpg, etc.
            
            // Copiar al storage público
            Storage::disk('public')->put(
                'memoriales/fotos/' . $newFilename, 
                File::get($file->getPathname())
            );
        }
    }
    
    /**
     * Crear imágenes dummy si no existen imágenes de ejemplo
     */
    private function createDummyImages()
    {
        // Crear 5 imágenes dummy con colores diferentes
        $colors = ['#FF5733', '#33FF57', '#3357FF', '#F033FF', '#FFFF33'];
        
        for ($i = 1; $i <= 5; $i++) {
            // Crear una imagen simple con GD
            $img = imagecreatetruecolor(800, 600);
            
            // Color de fondo
            $colorIndex = $i - 1;
            $color = $colors[$colorIndex];
            
            // Convertir color hexadecimal a RGB
            list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
            $bgColor = imagecolorallocate($img, $r, $g, $b);
            
            // Llenar la imagen con el color
            imagefill($img, 0, 0, $bgColor);
            
            // Añadir texto
            $textColor = imagecolorallocate($img, 255, 255, 255);
            $text = "Imagen de ejemplo " . $i;
            imagestring($img, 5, 300, 280, $text, $textColor);
            
            // Guardar la imagen
            ob_start();
            imagejpeg($img, null, 80);
            $imageData = ob_get_clean();
            
            // Guardar en storage
            Storage::disk('public')->put("memoriales/fotos/ejemplo{$i}.jpg", $imageData);
            
            // Liberar memoria
            imagedestroy($img);
        }
    }
} 