<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tributo extends Model
{
    use HasFactory;

    protected $fillable = [
        'memorial_id',
        'nombre_remitente',
        'email_remitente',
        'mensaje',
        'foto_remitente',
        'ciudad',
        'estado',
        'pais',
        'latitud',
        'longitud',
        'relacion',
        'mostrar_en_mapa',
        'aprobado'
    ];

    protected $casts = [
        'latitud' => 'float',
        'longitud' => 'float',
        'mostrar_en_mapa' => 'boolean',
        'aprobado' => 'boolean'
    ];

    /**
     * Obtener el memorial al que pertenece este tributo
     */
    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }
} 