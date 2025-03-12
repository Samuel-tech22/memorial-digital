<?php

namespace App\Filament\Widgets;

use App\Models\Tributo;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestTributosWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tributo::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('foto_remitente')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(asset('images/default-user.png')),
                
                Tables\Columns\TextColumn::make('nombre_remitente')
                    ->label('Remitente')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('mensaje')
                    ->label('Mensaje')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('relacion')
                    ->label('Relación')
                    ->badge(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('aprobado')
                    ->label('Aprobado')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->url(fn (Tributo $record): string => route('filament.admin.resources.tributos.edit', $record))
                    ->icon('heroicon-m-eye'),
            ]);
    }
} 