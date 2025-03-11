<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('memorials', function (Blueprint $table) {
            $table->id();
            $table->string('foto_perfil')->nullable(); // Foto central del difunto
            $table->string('foto_fondo')->nullable(); // Imagen de fondo (playa/paisaje)
            $table->string('nombre'); // Nombre (Richard)
            $table->string('apellidos'); // Apellidos (Dickson)
            $table->date('fecha_nacimiento');
            $table->date('fecha_fallecimiento');
            $table->string('frase_recordatoria')->nullable(); // "You taught us to dream!"
            $table->text('en_mis_propias_palabras')->nullable(); // Contenido de "En Mis Propias Palabras"
            $table->string('titulo_cabecera')->default('In Loving Memory of'); // Texto superior "In Loving Memory of"
            $table->text('biografia')->nullable(); // Biografía en texto plano
            $table->string('pdf_biografia')->nullable(); // PDF descargable con biografía
            $table->string('facebook_url')->nullable(); // Enlaces a redes sociales
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->boolean('estado')->default(true); // Si el memorial está activo o no
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorials');
    }
}; 