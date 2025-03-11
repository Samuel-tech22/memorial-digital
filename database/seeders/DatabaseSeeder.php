<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario de prueba si no existe
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Usuario administrador si no existe
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
            ]);
        }

        // Llamar a los seeders separados en el orden correcto
        $this->call([
            MemorialSeeder::class,    // Primero crear el memorial
            LugaresSeeder::class,     // Luego lugares
            FotoSeeder::class,        // Fotos
            LineaTiempoSeeder::class, // Línea de tiempo
            TributoSeeder::class,     // Tributos
            EstiloVisualSeeder::class, // Estilos visuales
            FooterSeeder::class,      // Footer
        ]);
    }
}
