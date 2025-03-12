<?php

namespace App\Filament\Widgets;

use App\Models\Foto;
use Filament\Widgets\Widget;

class RecentPhotosWidget extends Widget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    
    protected static string $view = 'filament.widgets.recent-photos-widget';
    
    public function getPhotos()
    {
        // Obtener las últimas 6 fotos activas
        $fotos = Foto::where('activo', true)->latest()->take(6)->get();
        
        // Comprobar si hay fotos
        if ($fotos->isEmpty()) {
            return collect();
        }
        
        // Depurar la primera foto para ver la estructura real
        \Log::info('Primera foto:', [
            'foto' => $fotos->first()->toArray()
        ]);
        
        return $fotos;
    }
} 