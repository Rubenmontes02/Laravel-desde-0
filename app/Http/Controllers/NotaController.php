<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Categoria;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    // Atiende GET /notas: pide todas las notas a la BD y las pasa a la vista.
    public function index()
    {
        $notas = Nota::latest()->get();
        $categorias = Categoria::all();
        
        return view('notas.index', ['notas' => $notas, 'categorias' => $categorias]);
    }

    // Atiende POST /notas: valida el texto enviado por el formulario y lo guarda.
    public function store(Request $request)
    {
        $datos = $request->validate([
            'texto' => 'required|string|max:50',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        Nota::create($datos);

        return redirect('/notas');
    }

    // Atiende DELETE /notas/{nota}: borra la nota indicada.
    public function destroy(Nota $nota)
    {
        $nota->delete();

        return redirect('/notas');
    }

    // Atiende GET /notas/{nota}/edit: muestra el formulario ya relleno.
    public function edit(Nota $nota)
    {
        return view('notas.edit', ['nota' => $nota]);
    }

    // Atiende PUT /notas/{nota}: valida el texto nuevo y actualiza la fila.
    public function update(Request $request, Nota $nota)
    {
        $datos = $request->validate([
            'texto' => 'required|string|max:50',
        ]);

        $nota->update($datos);

        return redirect('/notas');
    }
}
