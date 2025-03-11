<?php

namespace App\Filament\Resources\LineaTiempoResource\Pages;

use App\Filament\Resources\LineaTiempoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLineaTiempos extends ListRecords
{
    protected static string $resource = LineaTiempoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 