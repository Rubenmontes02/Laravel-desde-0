<?php

use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;

// Rutas de Tareas
Route::prefix('tareas')->name('tareas.')->group(function () {
    Route::get('/', [TareaController::class, 'index'])->name('index');
    Route::post('/', [TareaController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [TareaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [TareaController::class, 'update'])->name('update');
    Route::delete('/{id}', [TareaController::class, 'destroy'])->name('destroy');
});
