<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Memorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto_perfil',
        'foto_fondo',
        'nombre',
        'apellidos',
        'fecha_nacimiento',
        'fecha_fallecimiento',
        'frase_recordatoria',
        'en_mis_propias_palabras',
        'titulo_cabecera',
        'biografia',
        'pdf_biografia',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'estado',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_fallecimiento' => 'date',
        'estado' => 'boolean',
    ];

    public function fotos(): HasMany
    {
        return $this->hasMany(Foto::class);
    }

    public function tributos(): HasMany
    {
        return $this->hasMany(Tributo::class);
    }

    public function lugares(): HasMany
    {
        return $this->hasMany(Lugar::class);
    }

    public function lineaTiempo(): HasMany
    {
        return $this->hasMany(LineaTiempo::class);
    }

    // Alias para eventos (para mantener compatibilidad con el controlador)
    public function eventos(): HasMany
    {
        return $this->hasMany(LineaTiempo::class);
    }

    /**
     * Obtener el estilo visual asociado a este memorial
     */
    public function estiloVisual()
    {
        return $this->hasOne(EstiloVisual::class);
    }
    
    /**
     * Obtener la configuración del footer asociado a este memorial
     */
    public function footer()
    {
        return $this->hasOne(Footer::class);
    }
} 