<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Foto extends Model
{
    use HasFactory;

    protected $fillable = [
        'memorial_id',
        'url',
        'titulo',
        'descripcion',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Evento de boot para configurar el modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Asignar automáticamente el siguiente valor de orden cuando se crea una nueva foto
        static::creating(function ($foto) {
            // Si no se proporcionó un valor para orden o es null
            if (empty($foto->orden)) {
                // Obtener el memorial_id
                $memorialId = $foto->memorial_id;
                
                // Buscar el mayor valor de orden para este memorial
                $maxOrden = self::where('memorial_id', $memorialId)->max('orden');
                
                // Asignar el siguiente valor
                $foto->orden = ($maxOrden ?? 0) + 1;
            }
            
            // Establecer activo a true por defecto si no se especifica
            if (!isset($foto->activo)) {
                $foto->activo = true;
            }
        });
    }

    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }
} 