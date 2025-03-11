<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemorialResource\Pages;
use App\Filament\Resources\MemorialResource\RelationManagers;
use App\Models\Memorial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MemorialResource extends Resource
{
    protected static ?string $model = Memorial::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información básica')
                    ->schema([                        
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Forms\Set $set, Forms\Get $get) {
                                if (! $get('slug') || $get('has_slug_changed_manually')) {
                                    $apellidos = $get('apellidos') ?? '';
                                    $fullName = trim($state . ' ' . $apellidos);
                                    $set('slug', Str::slug($fullName));
                                }
                            }),
                        
                        Forms\Components\TextInput::make('apellidos')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Forms\Set $set, Forms\Get $get) {
                                if (! $get('slug') || ! $get('has_slug_changed_manually')) {
                                    $nombre = $get('nombre') ?? '';
                                    $fullName = trim($nombre . ' ' . $state);
                                    $set('slug', Str::slug($fullName));
                                }
                            }),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Memorial::class, 'slug', ignoreRecord: true)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set) {
                                $set('has_slug_changed_manually', true);
                            })
                            ->helperText('URL amigable para el memorial'),
                        
                        Forms\Components\Hidden::make('has_slug_changed_manually')
                            ->default(false),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Fechas')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha_nacimiento')
                            ->required()
                            ->displayFormat('d/m/Y'),
                        
                        Forms\Components\DatePicker::make('fecha_fallecimiento')
                            ->required()
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Detalles')
                    ->schema([
                        Forms\Components\FileUpload::make('imagen_principal')
                            ->image()
                            ->directory('memoriales')
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('600')
                            ->imageResizeTargetHeight('600'),
                        
                        Forms\Components\Textarea::make('biografia')
                            ->rows(5)
                            ->maxLength(65535),
                        
                        Forms\Components\TextInput::make('frase_recordatoria')
                            ->maxLength(255),
                        
                        Forms\Components\Toggle::make('estado')
                            ->label('Publicado')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagen_principal')
                    ->circular(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apellidos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_fallecimiento')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('estado')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('estado')
                    ->label('Publicado')
                    ->boolean()
                    ->trueLabel('Publicados')
                    ->falseLabel('No publicados')
                    ->placeholder('Todos'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TributosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemorials::route('/'),
            'create' => Pages\CreateMemorial::route('/create'),
            'edit' => Pages\EditMemorial::route('/{record}/edit'),
        ];
    }
} 