<?php

namespace App\Filament\Resources\LineaTiempoResource\Pages;

use App\Filament\Resources\LineaTiempoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLineaTiempo extends CreateRecord
{
    protected static string $resource = LineaTiempoResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 