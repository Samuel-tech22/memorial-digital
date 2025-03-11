<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstiloVisual extends Model
{
    use HasFactory;
    
    protected $table = 'estilos_visuales';
    
    protected $fillable = [
        'memorial_id',
        'color_primario',
        'color_secundario',
        'color_acento',
        'color_fondo',
        'color_texto',
        'color_fondo_cabecera',
        'color_texto_cabecera',
        'color_fondo_menu',
        'color_texto_menu',
        'color_menu_activo',
        'color_texto_menu_activo',
        'color_separador_seccion',
        'color_fondo_seccion',
        'color_titulo_seccion',
        'color_fondo_tarjeta',
        'color_borde_tarjeta',
        'radio_borde_tarjeta',
        'color_boton_primario',
        'color_texto_boton_primario',
        'color_boton_secundario',
        'color_texto_boton_secundario',
        'fuente_titulos',
        'fuente_texto',
        'color_linea_tiempo',
        'color_marcador_tiempo',
        'color_marcador_mapa',
        'imagen_fondo_memorial',
        'usar_imagen_fondo',
        'modo_oscuro',
    ];
    
    protected $casts = [
        'usar_imagen_fondo' => 'boolean',
        'modo_oscuro' => 'boolean',
    ];
    
    /**
     * Obtener el memorial al que pertenece este estilo visual
     */
    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }
    
    /**
     * Obtener estilos para el memorial activo o crear un estilo por defecto si no existe
     */
    public static function obtenerEstiloActivo()
    {
        $memorial = Memorial::where('estado', true)->first();
        
        if (!$memorial) {
            return null;
        }
        
        $estilo = self::where('memorial_id', $memorial->id)->first();
        
        if (!$estilo) {
            // Crear estilo por defecto para este memorial
            $estilo = self::create([
                'memorial_id' => $memorial->id,
                // Los demás campos tendrán valores por defecto definidos en la migración
            ]);
        }
        
        return $estilo;
    }
}
