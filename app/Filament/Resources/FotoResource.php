<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FotoResource\Pages;
use App\Filament\Resources\FotoResource\RelationManagers;
use App\Models\Foto;
use App\Models\Memorial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class FotoResource extends Resource
{
    protected static ?string $model = Foto::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Galería de Fotos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('memorial_id')
                    ->default(function() {
                        return Memorial::where('estado', true)->first()?->id ?? 1;
                    }),
                    
                FileUpload::make('url')
                    ->label('Imagen')
                    ->image()
                    ->directory('memoriales/fotos')
                    ->required()
                    ->maxSize(2048)
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('1200')
                    ->imageResizeTargetHeight('800'),

                TextInput::make('titulo')
                    ->maxLength(255),

                Textarea::make('descripcion')
                    ->maxLength(65535),

                TextInput::make('orden')
                    ->numeric()
                    ->placeholder('Se autoasignará el siguiente número disponible')
                    ->helperText('Si se deja vacío, se asignará automáticamente el siguiente número de orden')
                    ->hint('Opcional')
                    ->nullable()
                    ->hidden(),
                    
                Toggle::make('activo')
                    ->label('Activo')
                    ->helperText('Determina si la foto se mostrará o no en la galería')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('url')
                    ->label('Imagen')
                    ->disk('public')
                    ->size(100)
                    ->extraImgAttributes(['class' => 'object-cover']),
                    
                TextColumn::make('titulo')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('memorial.nombre')
                    ->label('Memorial')
                    ->searchable(),
                    
                TextColumn::make('orden')
                    ->sortable(),
                    
                ToggleColumn::make('activo')
                    ->label('Visible')
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('orden')
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('toggle_active')
                        ->label(fn (Model $record): string => $record->activo ? 'Desactivar' : 'Activar')
                        ->icon(fn (Model $record): string => $record->activo ? 'heroicon-m-eye-slash' : 'heroicon-m-eye')
                        ->color(fn (Model $record): string => $record->activo ? 'danger' : 'success')
                        ->action(function (Model $record): void {
                            $record->update(['activo' => !$record->activo]);
                        }),
                    Action::make('move_up')
                        ->label('Subir')
                        ->icon('heroicon-m-arrow-up')
                        ->color('warning')
                        ->action(function (Model $record) {
                            // Obtener la foto anterior en orden
                            $prevFoto = Foto::where('memorial_id', $record->memorial_id)
                                            ->where('orden', '<', $record->orden)
                                            ->orderBy('orden', 'desc')
                                            ->first();
                            
                            // Si hay una foto anterior, intercambiar posiciones
                            if ($prevFoto) {
                                $tempOrden = $prevFoto->orden;
                                $prevFoto->update(['orden' => $record->orden]);
                                $record->update(['orden' => $tempOrden]);
                            }
                        }),
                    Action::make('move_down')
                        ->label('Bajar')
                        ->icon('heroicon-m-arrow-down')
                        ->color('warning')
                        ->action(function (Model $record) {
                            // Obtener la siguiente foto en orden
                            $nextFoto = Foto::where('memorial_id', $record->memorial_id)
                                            ->where('orden', '>', $record->orden)
                                            ->orderBy('orden', 'asc')
                                            ->first();
                            
                            // Si hay una siguiente foto, intercambiar posiciones
                            if ($nextFoto) {
                                $tempOrden = $nextFoto->orden;
                                $nextFoto->update(['orden' => $record->orden]);
                                $record->update(['orden' => $tempOrden]);
                            }
                        }),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activar')
                        ->label('Activar Seleccionadas')
                        ->icon('heroicon-m-eye')
                        ->color('success')
                        ->action(fn (array $records) => Foto::whereIn('id', collect($records)->pluck('id'))->update(['activo' => true])),
                    Tables\Actions\BulkAction::make('desactivar')
                        ->label('Desactivar Seleccionadas')
                        ->icon('heroicon-m-eye-slash')
                        ->color('danger')
                        ->action(fn (array $records) => Foto::whereIn('id', collect($records)->pluck('id'))->update(['activo' => false])),
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
            'index' => Pages\ListFotos::route('/'),
            'create' => Pages\CreateFoto::route('/create'),
            'edit' => Pages\EditFoto::route('/{record}/edit'),
        ];
    }
}
