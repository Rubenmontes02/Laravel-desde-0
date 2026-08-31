<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Cada dominio de la app tiene su propio archivo de rutas, y aquí solo
// los "importamos". Si el día de mañana añades un módulo nuevo (usuarios,
// proyectos...), creas routes/usuarios.php y añades una línea más aquí,
// sin que este archivo crezca sin control.
require __DIR__.'/notas.php';
require __DIR__.'/tareas.php';
