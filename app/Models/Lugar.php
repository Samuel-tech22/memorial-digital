<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lugar extends Model
{
    use HasFactory;
    
    protected $table = 'lugares';

    protected $fillable = [
        'memorial_id',
        'titulo',
        'imagen',
        'descripcion',
        'url_relacionada',
        'ubicacion_mapa',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Obtener el memorial al que pertenece este lugar
     */
    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }
} 