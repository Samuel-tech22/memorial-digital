<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstiloVisualResource\Pages;
use App\Filament\Resources\EstiloVisualResource\RelationManagers;
use App\Models\EstiloVisual;
use App\Models\Memorial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstiloVisualResource extends Resource
{
    protected static ?string $model = EstiloVisual::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Estilos Visuales';
    protected static ?string $modelLabel = 'Estilo Visual';
    protected static ?string $pluralModelLabel = 'Estilos Visuales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Configuración de Estilos')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\Hidden::make('memorial_id')
                                    ->default(function() {
                                        return Memorial::where('estado', true)->first()?->id ?? 1;
                                    }),
                                
                                Forms\Components\Section::make('Colores Principales')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_primario')
                                            ->label('Color Primario')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_secundario')
                                            ->label('Color Secundario')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_acento')
                                            ->label('Color Acento')
                                            ->required(),
                                    ])
                                    ->columns(3),
                                
                                Forms\Components\Section::make('Fondo y Texto')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_fondo')
                                            ->label('Color de Fondo')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_texto')
                                            ->label('Color de Texto')
                                            ->required(),
                                    ])
                                    ->columns(2),
                                
                                Forms\Components\Section::make('Fuentes')
                                    ->schema([
                                        Forms\Components\Select::make('fuente_titulos')
                                            ->label('Fuente para Títulos')
                                            ->options([
                                                'Merriweather, serif' => 'Merriweather',
                                                'Playfair Display, serif' => 'Playfair Display',
                                                'Roboto Slab, serif' => 'Roboto Slab',
                                                'Lora, serif' => 'Lora',
                                                'Georgia, serif' => 'Georgia',
                                            ])
                                            ->required(),
                                        
                                        Forms\Components\Select::make('fuente_texto')
                                            ->label('Fuente para Texto')
                                            ->options([
                                                'Inter, sans-serif' => 'Inter',
                                                'Lato, sans-serif' => 'Lato',
                                                'Roboto, sans-serif' => 'Roboto',
                                                'Open Sans, sans-serif' => 'Open Sans',
                                                'Arial, sans-serif' => 'Arial',
                                            ])
                                            ->required(),
                                    ])
                                    ->columns(2),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Cabecera y Menú')
                            ->schema([
                                Forms\Components\Section::make('Cabecera')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_fondo_cabecera')
                                            ->label('Color de Fondo')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_texto_cabecera')
                                            ->label('Color de Texto')
                                            ->required(),
                                    ])
                                    ->columns(2),
                                
                                Forms\Components\Section::make('Menú de Navegación')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_fondo_menu')
                                            ->label('Color de Fondo')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_texto_menu')
                                            ->label('Color de Texto')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_menu_activo')
                                            ->label('Color de Elemento Activo')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_texto_menu_activo')
                                            ->label('Color de Texto Activo')
                                            ->required(),
                                    ])
                                    ->columns(2),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Secciones y Tarjetas')
                            ->schema([
                                Forms\Components\Section::make('Secciones')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_fondo_seccion')
                                            ->label('Color de Fondo')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_titulo_seccion')
                                            ->label('Color de Título')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_separador_seccion')
                                            ->label('Color de Separador')
                                            ->required(),
                                    ])
                                    ->columns(3),
                                
                                Forms\Components\Section::make('Tarjetas')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_fondo_tarjeta')
                                            ->label('Color de Fondo')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_borde_tarjeta')
                                            ->label('Color de Borde')
                                            ->required(),
                                        
                                        Forms\Components\TextInput::make('radio_borde_tarjeta')
                                            ->label('Radio de Bordes')
                                            ->placeholder('0.5rem')
                                            ->required(),
                                    ])
                                    ->columns(3),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Botones')
                            ->schema([
                                Forms\Components\Section::make('Botón Primario')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_boton_primario')
                                            ->label('Color de Fondo')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_texto_boton_primario')
                                            ->label('Color de Texto')
                                            ->required(),
                                    ])
                                    ->columns(2),
                                
                                Forms\Components\Section::make('Botón Secundario')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_boton_secundario')
                                            ->label('Color de Fondo')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_texto_boton_secundario')
                                            ->label('Color de Texto')
                                            ->required(),
                                    ])
                                    ->columns(2),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Características Especiales')
                            ->schema([
                                Forms\Components\Section::make('Línea de Tiempo')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_linea_tiempo')
                                            ->label('Color de la Línea')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_marcador_tiempo')
                                            ->label('Color de Marcadores')
                                            ->required(),
                                    ])
                                    ->columns(2),
                                
                                Forms\Components\Section::make('Mapa')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_marcador_mapa')
                                            ->label('Color de Marcadores')
                                            ->required(),
                                    ]),
                                
                                Forms\Components\Section::make('Características Adicionales')
                                    ->schema([
                                        Forms\Components\FileUpload::make('imagen_fondo_memorial')
                                            ->label('Imagen de Fondo')
                                            ->directory('fondos')
                                            ->image()
                                            ->imagePreviewHeight('200'),
                                        
                                        Forms\Components\Toggle::make('usar_imagen_fondo')
                                            ->label('¿Usar imagen de fondo?')
                                            ->default(false),
                                        
                                        Forms\Components\Toggle::make('modo_oscuro')
                                            ->label('¿Activar modo oscuro?')
                                            ->default(false)
                                            ->helperText('Activa una paleta de colores oscuros para el sitio'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('memorial.nombre')
                    ->label('Memorial')
                    ->searchable(),
                
                Tables\Columns\ColorColumn::make('color_primario')
                    ->label('Color Primario'),
                
                Tables\Columns\ColorColumn::make('color_secundario')
                    ->label('Color Secundario'),
                
                Tables\Columns\ColorColumn::make('color_acento')
                    ->label('Color Acento'),
                
                Tables\Columns\TextColumn::make('fuente_titulos')
                    ->label('Fuente Títulos')
                    ->limit(20),
                
                Tables\Columns\IconColumn::make('modo_oscuro')
                    ->label('Modo Oscuro')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEstiloVisuals::route('/'),
            'create' => Pages\CreateEstiloVisual::route('/create'),
            'edit' => Pages\EditEstiloVisual::route('/{record}/edit'),
        ];
    }
}
