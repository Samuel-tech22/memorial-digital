<?php

namespace App\Filament\Widgets;

use App\Models\Memorial;
use Filament\Widgets\Widget;

class MemorialStatusWidget extends Widget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    
    protected static string $view = 'filament.widgets.memorial-status-widget';
    
    public function getMemorial()
    {
        return Memorial::where('estado', true)->first();
    }
    
    public function getStatusItems()
    {
        $memorial = $this->getMemorial();
        
        if (!$memorial) {
            return [];
        }
        
        return [
            [
                'label' => 'Foto de Perfil',
                'status' => !empty($memorial->foto_perfil),
                'icon' => 'heroicon-o-user-circle',
            ],
            [
                'label' => 'Foto de Portada',
                'status' => !empty($memorial->foto_fondo),
                'icon' => 'heroicon-o-photo',
            ],
            [
                'label' => 'Datos Personales',
                'status' => !empty($memorial->nombre) && !empty($memorial->fecha_nacimiento) && !empty($memorial->fecha_fallecimiento),
                'icon' => 'heroicon-o-identification',
            ],
            [
                'label' => 'Frase Recordatoria',
                'status' => !empty($memorial->frase_recordatoria),
                'icon' => 'heroicon-o-chat-bubble-left-right',
            ],
            [
                'label' => 'Biografía',
                'status' => !empty($memorial->biografia),
                'icon' => 'heroicon-o-document-text',
            ],
            [
                'label' => 'Redes Sociales',
                'status' => !empty($memorial->facebook_url) || !empty($memorial->instagram_url) || !empty($memorial->twitter_url),
                'icon' => 'heroicon-o-share',
            ],
        ];
    }
    
    public function getCompletionPercentage()
    {
        $items = $this->getStatusItems();
        
        if (empty($items)) {
            return 0;
        }
        
        $completed = collect($items)->filter(fn ($item) => $item['status'])->count();
        
        return round(($completed / count($items)) * 100);
    }
} 