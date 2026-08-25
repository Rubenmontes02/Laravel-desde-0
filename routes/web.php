<?php

use App\Http\Controllers\NotaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// GET /notas -> muestra el formulario + la lista de notas guardadas.
Route::get('/notas', [NotaController::class, 'index']);

// POST /notas -> recibe los datos enviados por el <form> y los guarda en la BD.
Route::post('/notas', [NotaController::class, 'store']);
