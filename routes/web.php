<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;

Route::get('/', function () {
    return view('welcome');
});

// Cada dominio de la app tiene su propio archivo de rutas, y aquí solo
// los "importamos". Si el día de mañana añades un módulo nuevo (usuarios,
// proyectos...), creas routes/usuarios.php y añades una línea más aquí,
// sin que este archivo crezca sin control.
// El middleware "auth" (de fábrica en Laravel) bloquea el paso si no has
// iniciado sesión, y redirige a /login. Al envolver los require en este
// grupo, las rutas de notas.php y tareas.php lo heredan automáticamente,
// sin tener que tocar esos archivos.
Route::middleware('auth')->group(function () {
    Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');
    require __DIR__.'/notas.php';
    require __DIR__.'/tareas.php';
});

require __DIR__.'/auth.php';


