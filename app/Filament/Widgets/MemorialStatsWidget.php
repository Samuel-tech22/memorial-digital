<?php

namespace App\Filament\Widgets;

use App\Models\Tributo;
use App\Models\Foto;
use App\Models\Lugar;
use App\Models\LineaTiempo;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MemorialStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';
    
    protected function getStats(): array
    {
        return [
            Stat::make('Tributos', Tributo::count())
                ->description('Mensajes de condolencia')
                ->descriptionIcon('heroicon-m-heart')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('Fotos', Foto::count())
                ->description('Imágenes en galería')
                ->descriptionIcon('heroicon-m-photo')
                ->color('primary')
                ->chart([15, 8, 12, 10, 15, 10, 18])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('Lugares', Lugar::count())
                ->description('Ubicaciones importantes')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('warning')
                ->chart([5, 3, 8, 5, 8, 10, 12])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
                
            Stat::make('Eventos', LineaTiempo::count())
                ->description('Momentos registrados')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('danger')
                ->chart([3, 5, 7, 8, 9, 10, 12])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),
        ];
    }
} 