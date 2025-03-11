<?php

namespace App\Filament\Resources\EstiloVisualResource\Pages;

use App\Filament\Resources\EstiloVisualResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEstiloVisuals extends ListRecords
{
    protected static string $resource = EstiloVisualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
