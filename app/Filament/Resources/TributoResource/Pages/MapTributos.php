<?php

namespace App\Filament\Resources\TributoResource\Pages;

use App\Filament\Resources\TributoResource;
use App\Models\Tributo;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;

class MapTributos extends Page
{
    protected static string $resource = TributoResource::class;

    protected static string $view = 'filament.resources.tributo-resource.pages.map-tributos';
    
    protected static ?string $title = 'Mapa de Tributos';

    public function getTributos()
    {
        return Tributo::query()
            ->where('aprobado', true)
            ->where('mostrar_en_mapa', true)
            ->whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->with('memorial')
            ->get()
            ->map(function ($tributo) {
                return [
                    'id' => $tributo->id,
                    'nombre' => $tributo->nombre_remitente,
                    'mensaje' => $tributo->mensaje,
                    'relacion' => $tributo->relacion,
                    'ciudad' => $tributo->ciudad,
                    'pais' => $tributo->pais,
                    'lat' => (float) $tributo->latitud,
                    'lng' => (float) $tributo->longitud,
                    'foto' => $tributo->foto_remitente ? asset('storage/' . $tributo->foto_remitente) : null,
                ];
            });
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('volver')
                ->label('Volver a la lista')
                ->url(TributoResource::getUrl())
                ->color('gray')
                ->icon('heroicon-o-arrow-left'),
        ];
    }
} 