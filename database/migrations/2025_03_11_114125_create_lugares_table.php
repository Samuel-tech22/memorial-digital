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
        Schema::create('lugares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorial_id')->constrained('memorials')->onDelete('cascade');
            $table->string('titulo'); // Título del lugar
            $table->string('imagen'); // Ruta de la imagen
            $table->text('descripcion')->nullable(); // Descripción breve que aparece al ampliar la foto
            $table->string('url_relacionada')->nullable(); // Hipervínculo relacionado con la foto
            $table->string('ubicacion_mapa')->nullable(); // Coordenadas o enlace a Google Maps
            $table->integer('orden')->default(0); // Para controlar el orden de visualización
            $table->boolean('activo')->default(true); // Para ocultar/mostrar la foto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lugares');
    }
};
