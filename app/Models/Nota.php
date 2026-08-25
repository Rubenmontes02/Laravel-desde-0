<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;

class Nota extends Model
{
    // Campos que se pueden rellenar con Nota::create($datos).
    // Es una medida de seguridad: sin esta lista, Eloquent rechaza
    // por defecto la asignación masiva para evitar que alguien cuele
    // datos que no debería (ej. un campo "es_admin" desde el formulario).
    protected $fillable = ['texto', 'categoria_id'];

    public function categoria()
    {
    return $this->belongsTo(Categoria::class);
    }
}



