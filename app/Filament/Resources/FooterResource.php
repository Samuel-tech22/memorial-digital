<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FooterResource\Pages;
use App\Models\Footer;
use App\Models\Memorial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FooterResource extends Resource
{
    protected static ?string $model = Footer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationLabel = 'Pie de Página';
    protected static ?string $modelLabel = 'Pie de Página';
    protected static ?string $pluralModelLabel = 'Pie de Página';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Configuración del Footer')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\Hidden::make('memorial_id')
                                    ->default(function() {
                                        return Memorial::where('estado', true)->first()?->id ?? 1;
                                    }),
                                
                                Forms\Components\TextInput::make('texto_copyright')
                                    ->label('Texto de Copyright')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                
                                Forms\Components\Toggle::make('mostrar_logo')
                                    ->label('Mostrar Logo en el Footer')
                                    ->default(false),
                                
                                Forms\Components\FileUpload::make('logo_footer')
                                    ->label('Logo para el Footer')
                                    ->directory('footer')
                                    ->image()
                                    ->imageResizeMode('contain')
                                    ->imageCropAspectRatio('3:1')
                                    ->visible(fn (Forms\Get $get) => $get('mostrar_logo')),
                                
                                Forms\Components\Toggle::make('mostrar_redes_sociales')
                                    ->label('Mostrar Redes Sociales en el Footer')
                                    ->default(true)
                                    ->helperText('Las redes sociales se tomarán de la configuración del memorial'),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Enlaces')
                            ->schema([
                                // Enlace 1
                                Forms\Components\Section::make('Enlace 1')
                                    ->schema([
                                        Forms\Components\Toggle::make('enlace1_activo')
                                            ->label('Activo')
                                            ->default(true),
                                        
                                        Forms\Components\TextInput::make('enlace1_texto')
                                            ->label('Texto')
                                            ->required()
                                            ->maxLength(50),
                                        
                                        Forms\Components\TextInput::make('enlace1_url')
                                            ->label('URL')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->columns(3)
                                    ->collapsible(),
                                
                                // Enlace 2
                                Forms\Components\Section::make('Enlace 2')
                                    ->schema([
                                        Forms\Components\Toggle::make('enlace2_activo')
                                            ->label('Activo')
                                            ->default(true),
                                        
                                        Forms\Components\TextInput::make('enlace2_texto')
                                            ->label('Texto')
                                            ->required()
                                            ->maxLength(50),
                                        
                                        Forms\Components\TextInput::make('enlace2_url')
                                            ->label('URL')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->columns(3)
                                    ->collapsible(),
                                
                                // Enlace 3
                                Forms\Components\Section::make('Enlace 3')
                                    ->schema([
                                        Forms\Components\Toggle::make('enlace3_activo')
                                            ->label('Activo')
                                            ->default(true),
                                        
                                        Forms\Components\TextInput::make('enlace3_texto')
                                            ->label('Texto')
                                            ->required()
                                            ->maxLength(50),
                                        
                                        Forms\Components\TextInput::make('enlace3_url')
                                            ->label('URL')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->columns(3)
                                    ->collapsible(),
                                
                                // Enlace 4 (opcional)
                                Forms\Components\Section::make('Enlace 4 (Opcional)')
                                    ->schema([
                                        Forms\Components\Toggle::make('enlace4_activo')
                                            ->label('Activo')
                                            ->default(false),
                                        
                                        Forms\Components\TextInput::make('enlace4_texto')
                                            ->label('Texto')
                                            ->maxLength(50)
                                            ->required(fn (Forms\Get $get) => $get('enlace4_activo')),
                                        
                                        Forms\Components\TextInput::make('enlace4_url')
                                            ->label('URL')
                                            ->maxLength(255)
                                            ->required(fn (Forms\Get $get) => $get('enlace4_activo')),
                                    ])
                                    ->columns(3)
                                    ->collapsible(),
                                
                                // Enlace 5 (opcional)
                                Forms\Components\Section::make('Enlace 5 (Opcional)')
                                    ->schema([
                                        Forms\Components\Toggle::make('enlace5_activo')
                                            ->label('Activo')
                                            ->default(false),
                                        
                                        Forms\Components\TextInput::make('enlace5_texto')
                                            ->label('Texto')
                                            ->maxLength(50)
                                            ->required(fn (Forms\Get $get) => $get('enlace5_activo')),
                                        
                                        Forms\Components\TextInput::make('enlace5_url')
                                            ->label('URL')
                                            ->maxLength(255)
                                            ->required(fn (Forms\Get $get) => $get('enlace5_activo')),
                                    ])
                                    ->columns(3)
                                    ->collapsible(),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Estilos')
                            ->schema([
                                Forms\Components\Section::make('Colores')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('color_fondo')
                                            ->label('Color de Fondo')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_texto')
                                            ->label('Color de Texto')
                                            ->required(),
                                        
                                        Forms\Components\ColorPicker::make('color_enlaces')
                                            ->label('Color de Enlaces')
                                            ->required(),
                                    ])
                                    ->columns(3),
                                
                                Forms\Components\Section::make('Espaciado')
                                    ->schema([
                                        Forms\Components\TextInput::make('padding_top')
                                            ->label('Espacio Superior')
                                            ->placeholder('1rem')
                                            ->required(),
                                        
                                        Forms\Components\TextInput::make('padding_bottom')
                                            ->label('Espacio Inferior')
                                            ->placeholder('1rem')
                                            ->required(),
                                    ])
                                    ->columns(2),
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
                
                Tables\Columns\TextColumn::make('texto_copyright')
                    ->label('Copyright')
                    ->limit(30)
                    ->searchable(),
                
                Tables\Columns\ColorColumn::make('color_fondo')
                    ->label('Color Fondo'),
                
                Tables\Columns\IconColumn::make('mostrar_logo')
                    ->label('Logo')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('mostrar_redes_sociales')
                    ->label('Redes')
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
            'index' => Pages\ListFooters::route('/'),
            'create' => Pages\CreateFooter::route('/create'),
            'edit' => Pages\EditFooter::route('/{record}/edit'),
        ];
    }
} 