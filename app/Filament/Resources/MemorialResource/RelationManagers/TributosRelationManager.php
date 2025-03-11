<?php

namespace App\Filament\Resources\MemorialResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TributosRelationManager extends RelationManager
{
    protected static string $relationship = 'tributos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_remitente')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('email_remitente')
                    ->email()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('mensaje')
                    ->required()
                    ->maxLength(65535),
                
                Forms\Components\Toggle::make('aprobado')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre_remitente')
            ->columns([
                Tables\Columns\TextColumn::make('nombre_remitente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_remitente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mensaje')
                    ->limit(50),
                Tables\Columns\IconColumn::make('aprobado')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('aprobado')
                    ->boolean()
                    ->trueLabel('Aprobados')
                    ->falseLabel('Pendientes')
                    ->placeholder('Todos'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('aprobar')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) => !$record->aprobado)
                    ->action(fn ($record) => $record->update(['aprobado' => true])),
                Tables\Actions\Action::make('rechazar')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn ($record) => $record->aprobado)
                    ->action(fn ($record) => $record->update(['aprobado' => false])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('aprobar')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['aprobado' => true])),
                    Tables\Actions\BulkAction::make('rechazar')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['aprobado' => false])),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
} 