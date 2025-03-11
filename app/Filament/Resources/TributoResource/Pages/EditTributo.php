<?php

namespace App\Filament\Resources\TributoResource\Pages;

use App\Filament\Resources\TributoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTributo extends EditRecord
{
    protected static string $resource = TributoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 