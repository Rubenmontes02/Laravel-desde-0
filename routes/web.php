<?php

use App\Http\Controllers\NotaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Todas las rutas de "notas" agrupadas bajo el prefijo /notas y el
// prefijo de nombre "notas." — igual que haces en ZeroWasteHub con
// Route::prefix(...)->name(...)->group(...).
Route::prefix('notas')->name('notas.')->group(function () {
    // GET /notas -> muestra el formulario + la lista de notas guardadas.
    Route::get('/', [NotaController::class, 'index'])->name('index');

    // POST /notas -> recibe los datos enviados por el <form> y los guarda en la BD.
    Route::post('/', [NotaController::class, 'store'])->name('store');

    // GET /notas/{id}/edit -> muestra el formulario ya relleno.
    Route::get('/{id}/edit', [NotaController::class, 'edit'])->name('edit');

    // PUT /notas/{id} -> actualiza la nota indicada.
    Route::put('/{id}', [NotaController::class, 'update'])->name('update');

    // DELETE /notas/{id} -> borra la nota indicada.
    Route::delete('/{id}', [NotaController::class, 'destroy'])->name('destroy');
});
