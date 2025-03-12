<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TributoResource\Pages;
use App\Models\Memorial;
use App\Models\Tributo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TributoResource extends Resource
{
    protected static ?string $model = Tributo::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?int $navigationSort = 3;
    protected static ?string $recordTitleAttribute = 'nombre_remitente';
    protected static ?string $navigationLabel = 'Tributos';
    protected static ?string $modelLabel = 'Tributo';
    protected static ?string $pluralModelLabel = 'Tributos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Información del tributo')
                            ->schema([
                                Forms\Components\Hidden::make('memorial_id')
                                    ->default(function() {
                                        return Memorial::where('estado', true)->first()?->id ?? 1;
                                    }),
                                
                                Forms\Components\TextInput::make('nombre_remitente')
                                    ->required()
                                    ->label('Nombre del remitente')
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('email_remitente')
                                    ->email()
                                    ->label('Email del remitente')
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('relacion')
                                    ->label('Relación con el fallecido')
                                    ->maxLength(100),
                                
                                Forms\Components\Textarea::make('mensaje')
                                    ->required()
                                    ->columnSpanFull()
                                    ->maxLength(65535),
                                
                                Forms\Components\FileUpload::make('foto_remitente')
                                    ->label('Foto del remitente')
                                    ->directory('tributos/fotos')
                                    ->image()
                                    ->imagePreviewHeight('150')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                            
                        Forms\Components\Section::make('Ubicación')
                            ->schema([
                                Forms\Components\TextInput::make('ciudad')
                                    ->maxLength(100),
                                
                                Forms\Components\TextInput::make('estado')
                                    ->label('Estado/Provincia')
                                    ->maxLength(100),
                                
                                Forms\Components\TextInput::make('pais')
                                    ->label('País')
                                    ->maxLength(100),
                                
                                Forms\Components\TextInput::make('latitud')
                                    ->numeric()
                                    ->step(0.000001)
                                    ->helperText('Coordenadas para el mapa (ej. 41.8781)'),
                                
                                Forms\Components\TextInput::make('longitud')
                                    ->numeric()
                                    ->step(0.000001)
                                    ->helperText('Coordenadas para el mapa (ej. -87.6298)'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Configuración')
                            ->schema([
                                Forms\Components\Toggle::make('aprobado')
                                    ->label('¿Aprobado?')
                                    ->helperText('Solo los tributos aprobados serán visibles')
                                    ->default(false),
                                
                                Forms\Components\Toggle::make('mostrar_en_mapa')
                                    ->label('¿Mostrar en mapa?')
                                    ->helperText('Determina si este tributo aparece en la vista de mapa')
                                    ->default(true),
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
                Tables\Columns\TextColumn::make('nombre_remitente')
                    ->label('Remitente')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('relacion')
                    ->label('Relación')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('mensaje')
                    ->wrap()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('ciudad')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('pais')
                    ->label('País')
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('mostrar_en_mapa')
                    ->label('En mapa')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('aprobado')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('aprobado')
                    ->boolean()
                    ->trueLabel('Aprobados')
                    ->falseLabel('Pendientes')
                    ->placeholder('Todos')
                    ->default(false),
                
                Tables\Filters\TernaryFilter::make('mostrar_en_mapa')
                    ->label('En mapa')
                    ->boolean()
                    ->trueLabel('Visible en mapa')
                    ->falseLabel('Oculto en mapa')
                    ->placeholder('Todos'),
                
                Tables\Filters\SelectFilter::make('memorial')
                    ->relationship('memorial', 'nombre')
                    ->searchable()
                    ->preload(),
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
                Tables\Actions\Action::make('toggleMapa')
                    ->icon('heroicon-o-map')
                    ->color(fn ($record) => $record->mostrar_en_mapa ? 'danger' : 'success')
                    ->label(fn ($record) => $record->mostrar_en_mapa ? 'Ocultar del mapa' : 'Mostrar en mapa')
                    ->action(fn ($record) => $record->update(['mostrar_en_mapa' => !$record->mostrar_en_mapa])),
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
                    Tables\Actions\BulkAction::make('mostrarEnMapa')
                        ->icon('heroicon-o-map')
                        ->color('success')
                        ->label('Mostrar en mapa')
                        ->action(fn ($records) => $records->each->update(['mostrar_en_mapa' => true])),
                    Tables\Actions\BulkAction::make('ocultarDelMapa')
                        ->icon('heroicon-o-map')
                        ->color('danger')
                        ->label('Ocultar del mapa')
                        ->action(fn ($records) => $records->each->update(['mostrar_en_mapa' => false])),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListTributos::route('/'),
            'create' => Pages\CreateTributo::route('/create'),
            'edit' => Pages\EditTributo::route('/{record}/edit'),
            'map' => Pages\MapTributos::route('/map'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('aprobado', false)->count() ?: null;
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
} 