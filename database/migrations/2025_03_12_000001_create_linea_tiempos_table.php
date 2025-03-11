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
        Schema::create('linea_tiempos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorial_id')->constrained('memorials')->onDelete('cascade');
            $table->string('titulo'); // Título del evento (ej: "Born in Paterson, NJ")
            $table->text('descripcion')->nullable(); // Descripción detallada
            $table->date('fecha'); // Fecha del evento
            $table->string('ubicacion')->nullable(); // Ubicación donde ocurrió el evento
            $table->string('url_relacionada')->nullable(); // Enlaces a sitios web relacionados
            $table->integer('orden')->default(0); // Para poder personalizar el orden
            $table->boolean('activo')->default(true); // Para ocultar/mostrar el evento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linea_tiempos');
    }
}; 