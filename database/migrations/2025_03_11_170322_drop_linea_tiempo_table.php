<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Elimina la tabla linea_tiempo que está duplicada con linea_tiempos
     */
    public function up(): void
    {
        // Eliminamos la tabla si existe
        if (Schema::hasTable('linea_tiempo')) {
            Schema::dropIfExists('linea_tiempo');
        }
    }

    /**
     * Reverse the migrations.
     * No recreamos la tabla, ya que usamos linea_tiempos en su lugar
     */
    public function down(): void
    {
        // No hacemos nada, preferimos usar linea_tiempos
    }
};
