<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LineaTiempo extends Model
{
    use HasFactory;
    
    protected $table = 'linea_tiempos';
    
    protected $fillable = [
        'memorial_id',
        'titulo',
        'descripcion',
        'fecha',
        'ubicacion',
        'url_relacionada',
        'orden',
        'activo',
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'activo' => 'boolean',
    ];
    
    /**
     * Obtener el memorial al que pertenece este evento de la línea de tiempo
     */
    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }
} 