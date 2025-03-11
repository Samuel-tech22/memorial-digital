<?php

namespace App\Filament\Resources\LineaTiempoResource\Pages;

use App\Filament\Resources\LineaTiempoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLineaTiempo extends EditRecord
{
    protected static string $resource = LineaTiempoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 