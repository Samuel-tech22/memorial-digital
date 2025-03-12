<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Esta migración ha sido deshabilitada porque utilizamos la tabla 'linea_tiempos' en su lugar.
     */
    public function up(): void
    {
        // La tabla 'linea_tiempo' no se utilizará
        // Se mantiene esta migración para mantener la integridad del historial de migraciones
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si la tabla existe, la eliminamos
        if (Schema::hasTable('linea_tiempo')) {
            Schema::dropIfExists('linea_tiempo');
        }
    }
}; 