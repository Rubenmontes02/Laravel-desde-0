<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    // Atiende GET /notas: pide todas las notas a la BD y las pasa a la vista.
    public function index()
    {
        $notas = Nota::latest()->get();

        return view('notas.index', ['notas' => $notas]);
    }

    // Atiende POST /notas: valida el texto enviado por el formulario y lo guarda.
    public function store(Request $request)
    {
        $datos = $request->validate([
            'texto' => 'required|string|max:50',
        ]);

        Nota::create($datos);

        return redirect('/notas');
    }
}
