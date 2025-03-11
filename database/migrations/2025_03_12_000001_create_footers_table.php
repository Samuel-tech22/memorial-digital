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
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorial_id')->constrained('memorials')->onDelete('cascade');
            
            // Texto de copyright
            $table->string('texto_copyright')->default('© 2024 Memorial. Todos los derechos reservados.');
            
            // Enlaces de navegación
            $table->string('enlace1_texto')->default('Sobre Nosotros');
            $table->string('enlace1_url')->default('#');
            $table->boolean('enlace1_activo')->default(true);
            
            $table->string('enlace2_texto')->default('Conciérnenos');
            $table->string('enlace2_url')->default('#');
            $table->boolean('enlace2_activo')->default(true);
            
            $table->string('enlace3_texto')->default('Reportar abuso');
            $table->string('enlace3_url')->default('#');
            $table->boolean('enlace3_activo')->default(true);
            
            // Enlaces opcionales adicionales
            $table->string('enlace4_texto')->nullable();
            $table->string('enlace4_url')->nullable();
            $table->boolean('enlace4_activo')->default(false);
            
            $table->string('enlace5_texto')->nullable();
            $table->string('enlace5_url')->nullable();
            $table->boolean('enlace5_activo')->default(false);
            
            // Personalización visual
            $table->string('color_fondo')->default('#1E1A2B');  // Color oscuro por defecto
            $table->string('color_texto')->default('#FFFFFF');  // Texto blanco por defecto
            $table->string('color_enlaces')->default('#FFFFFF');  // Enlaces blancos por defecto
            $table->string('padding_top')->default('1rem');
            $table->string('padding_bottom')->default('1rem');
            
            // Logo opcional
            $table->string('logo_footer')->nullable();
            $table->boolean('mostrar_logo')->default(false);
            
            // Redes sociales en el footer
            $table->boolean('mostrar_redes_sociales')->default(false);
            
            $table->timestamps();
            
            // Cada memorial solo puede tener un footer
            $table->unique('memorial_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
}; 