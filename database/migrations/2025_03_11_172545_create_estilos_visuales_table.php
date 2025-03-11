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
        Schema::create('estilos_visuales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorial_id')->constrained('memorials')->onDelete('cascade');
            
            // Colores generales
            $table->string('color_primario')->default('#3B82F6'); // Azul por defecto
            $table->string('color_secundario')->default('#10B981'); // Verde por defecto
            $table->string('color_acento')->default('#F59E0B'); // Ámbar por defecto
            $table->string('color_fondo')->default('#FFFFFF'); // Blanco por defecto
            $table->string('color_texto')->default('#111827'); // Texto oscuro por defecto
            
            // Cabecera
            $table->string('color_fondo_cabecera')->default('#1E40AF'); // Azul oscuro por defecto
            $table->string('color_texto_cabecera')->default('#FFFFFF'); // Blanco por defecto
            
            // Menú
            $table->string('color_fondo_menu')->default('#F3F4F6'); // Gris claro por defecto
            $table->string('color_texto_menu')->default('#4B5563'); // Gris oscuro por defecto
            $table->string('color_menu_activo')->default('#3B82F6'); // Azul por defecto
            $table->string('color_texto_menu_activo')->default('#FFFFFF'); // Blanco por defecto
            
            // Secciones
            $table->string('color_separador_seccion')->default('#E5E7EB'); // Gris muy claro por defecto
            $table->string('color_fondo_seccion')->default('#F9FAFB'); // Gris muy claro por defecto
            $table->string('color_titulo_seccion')->default('#1F2937'); // Gris oscuro por defecto
            
            // Tarjetas/Elementos
            $table->string('color_fondo_tarjeta')->default('#FFFFFF'); // Blanco por defecto
            $table->string('color_borde_tarjeta')->default('#E5E7EB'); // Gris claro por defecto
            $table->string('radio_borde_tarjeta')->default('0.5rem'); // Redondeo de bordes
            
            // Botones
            $table->string('color_boton_primario')->default('#3B82F6'); // Azul por defecto
            $table->string('color_texto_boton_primario')->default('#FFFFFF'); // Blanco por defecto
            $table->string('color_boton_secundario')->default('#6B7280'); // Gris por defecto
            $table->string('color_texto_boton_secundario')->default('#FFFFFF'); // Blanco por defecto
            
            // Fuentes
            $table->string('fuente_titulos')->default('Merriweather, serif');
            $table->string('fuente_texto')->default('Inter, sans-serif');
            
            // Línea de tiempo
            $table->string('color_linea_tiempo')->default('#3B82F6'); // Azul por defecto
            $table->string('color_marcador_tiempo')->default('#3B82F6'); // Azul por defecto
            
            // Mapa
            $table->string('color_marcador_mapa')->default('#F59E0B'); // Ámbar por defecto
            
            // Extras
            $table->string('imagen_fondo_memorial')->nullable(); // Imagen de fondo opcional
            $table->boolean('usar_imagen_fondo')->default(false);
            $table->boolean('modo_oscuro')->default(false);
            
            $table->timestamps();
            
            // Cada memorial solo puede tener un estilo
            $table->unique('memorial_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estilos_visuales');
    }
};
