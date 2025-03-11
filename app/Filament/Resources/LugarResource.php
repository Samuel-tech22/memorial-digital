<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LugarResource\Pages;
use App\Models\Lugar;
use App\Models\Memorial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LugarResource extends Resource
{
    protected static ?string $model = Lugar::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?int $navigationSort = 4;
    protected static ?string $recordTitleAttribute = 'titulo';
    protected static ?string $navigationLabel = 'Lugares';
    protected static ?string $modelLabel = 'Lugar';
    protected static ?string $pluralModelLabel = 'Lugares';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Información del lugar')
                            ->schema([
                                Forms\Components\Hidden::make('memorial_id')
                                    ->default(function() {
                                        return Memorial::where('estado', true)->first()?->id ?? 1;
                                    }),
                                
                                Forms\Components\TextInput::make('titulo')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\FileUpload::make('imagen')
                                    ->directory('lugares')
                                    ->image()
                                    ->imagePreviewHeight('250')
                                    ->panelAspectRatio('2:1')
                                    ->panelLayout('integrated')
                                    ->required(),
                                
                                Forms\Components\RichEditor::make('descripcion')
                                    ->required()
                                    ->columnSpanFull(),
                                
                                Forms\Components\TextInput::make('url_relacionada')
                                    ->label('URL relacionada')
                                    ->url()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                
                                Forms\Components\TextInput::make('ubicacion_mapa')
                                    ->label('URL de Google Maps')
                                    ->helperText('Ejemplo: https://maps.google.com/?q=34.0103,-118.4961')
                                    ->url()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Configuración')
                            ->schema([
                                Forms\Components\Toggle::make('activo')
                                    ->label('¿Activo?')
                                    ->helperText('Determina si el lugar es visible en el memorial')
                                    ->default(true),
                                
                                Forms\Components\TextInput::make('orden')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Orden de aparición (menor número aparece primero)'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\ImageColumn::make('imagen')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('descripcion')
                    ->html()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('orden')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->boolean()
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos')
                    ->placeholder('Todos'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activar')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) => !$record->activo)
                    ->action(fn ($record) => $record->update(['activo' => true])),
                Tables\Actions\Action::make('desactivar')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn ($record) => $record->activo)
                    ->action(fn ($record) => $record->update(['activo' => false])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activar')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['activo' => true])),
                    Tables\Actions\BulkAction::make('desactivar')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['activo' => false])),
                ]),
            ])
            ->defaultSort('orden', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLugares::route('/'),
            'create' => Pages\CreateLugar::route('/create'),
            'edit' => Pages\EditLugar::route('/{record}/edit'),
        ];
    }
} 