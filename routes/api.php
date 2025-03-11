<?php

use App\Http\Controllers\Api\FotoController;
use App\Http\Controllers\Api\MemorialController;
use App\Http\Controllers\Api\TributoController;
use App\Http\Controllers\Api\LugarController;
use App\Http\Controllers\Api\LineaTiempoController;
use App\Http\Controllers\Api\EstiloVisualController;
use App\Http\Controllers\Api\FooterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas para el memorial principal
Route::get('/memorial', [MemorialController::class, 'principal']); // Obtener los datos del memorial principal
Route::get('/memorial/fotos', [FotoController::class, 'principal']); // Obtener las fotos del memorial principal
Route::get('/memorial/tributos', [TributoController::class, 'index']);
Route::get('/memorial/tributos/mapa', [TributoController::class, 'index'])->defaults('vista', 'mapa');
Route::get('/memorial/lugares', [LugarController::class, 'index']); // Obtener lugares del memorial principal
Route::get('/memorial/linea-tiempo', [LineaTiempoController::class, 'index']); // Obtener línea de tiempo del memorial principal
Route::get('/memorial/estilos', [EstiloVisualController::class, 'index']); // Obtener estilos visuales del memorial
Route::get('/memorial/footer', [FooterController::class, 'index']); // Obtener configuración del footer del memorial

// Rutas para crear tributos públicamente
Route::post('/memorial/tributos', [TributoController::class, 'store']); // Enviar un nuevo tributo

// Rutas protegidas por API token para administración (opcional)
Route::middleware('auth:sanctum')->group(function () {
    // Rutas para administración, aunque típicamente usarías Filament para estas operaciones
}); 