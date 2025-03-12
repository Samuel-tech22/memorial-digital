<?php

namespace App\Filament\Resources\TributoResource\Pages;

use App\Filament\Resources\TributoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTributos extends ListRecords
{
    protected static string $resource = TributoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('verMapa')
                ->label('Ver en mapa')
                ->icon('heroicon-o-map')
                ->color('success')
                ->url(static::getResource()::getUrl('map')),
                
            Actions\CreateAction::make(),
        ];
    }
} 