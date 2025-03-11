<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Footer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'memorial_id',
        'texto_copyright',
        'enlace1_texto',
        'enlace1_url',
        'enlace1_activo',
        'enlace2_texto',
        'enlace2_url',
        'enlace2_activo',
        'enlace3_texto',
        'enlace3_url',
        'enlace3_activo',
        'enlace4_texto',
        'enlace4_url',
        'enlace4_activo',
        'enlace5_texto',
        'enlace5_url',
        'enlace5_activo',
        'color_fondo',
        'color_texto',
        'color_enlaces',
        'padding_top',
        'padding_bottom',
        'logo_footer',
        'mostrar_logo',
        'mostrar_redes_sociales',
    ];
    
    protected $casts = [
        'enlace1_activo' => 'boolean',
        'enlace2_activo' => 'boolean',
        'enlace3_activo' => 'boolean',
        'enlace4_activo' => 'boolean',
        'enlace5_activo' => 'boolean',
        'mostrar_logo' => 'boolean',
        'mostrar_redes_sociales' => 'boolean',
    ];
    
    /**
     * Obtener el memorial al que pertenece este footer
     */
    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }
    
    /**
     * Obtener footer para el memorial activo o crear uno por defecto si no existe
     */
    public static function obtenerFooterActivo()
    {
        $memorial = Memorial::where('estado', true)->first();
        
        if (!$memorial) {
            return null;
        }
        
        $footer = self::where('memorial_id', $memorial->id)->first();
        
        if (!$footer) {
            // Crear footer por defecto para este memorial
            $footer = self::create([
                'memorial_id' => $memorial->id,
                // Los demás campos tendrán valores por defecto definidos en la migración
            ]);
        }
        
        return $footer;
    }
    
    /**
     * Obtener enlaces activos del footer como array
     */
    public function getEnlacesActivos()
    {
        $enlaces = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $textoKey = "enlace{$i}_texto";
            $urlKey = "enlace{$i}_url";
            $activoKey = "enlace{$i}_activo";
            
            if ($this->$activoKey && !empty($this->$textoKey)) {
                $enlaces[] = [
                    'texto' => $this->$textoKey,
                    'url' => $this->$urlKey
                ];
            }
        }
        
        return $enlaces;
    }
} 