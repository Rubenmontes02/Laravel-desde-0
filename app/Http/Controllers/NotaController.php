<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    // Atiende GET /notas: pide todas las notas a la BD y las pasa a la vista.
    public function index()
    {
        $notas = DB::connection('mysql_pruebas')->table('notas')
            ->leftJoin('categorias', 'notas.categoria_id', '=', 'categorias.id')
            ->leftJoin('users', 'notas.user_id', '=', 'users.id')
            ->select('notas.*', 'categorias.categoria as categoria_nombre', 'users.name as user_name')
            ->orderBy('notas.created_at', 'desc')
            ->get();

        $categorias = DB::connection('mysql_pruebas')->table('categorias')->get();


        return view('notas.index', ['notas' => $notas, 'categorias' => $categorias]);
    }

    // Atiende POST /notas: valida el texto enviado por el formulario y lo guarda.
    public function store(Request $request)
    {   
        $datos = $request->validate([
            'texto' => 'required|string|max:50',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        DB::connection('mysql_pruebas')->table(
            'notas')->insert([
            'texto' => $datos['texto'],
            'categoria_id' => $datos['categoria_id'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => auth()->id(),
        ]);

        return redirect('/notas');
    }

    // Atiende DELETE /notas/{id}: borra la nota indicada.
    public function destroy($id)
    {
        $nota = DB::connection('mysql_pruebas')->table('notas')->where('id', $id)->first();

        if($nota -> user_id === auth()->id()){

            DB::connection('mysql_pruebas')->table('notas')->where('id', $id)->delete();
            return redirect('/notas');
        
        }else{
            abort(403, 'No tienes permiso para eliminar esta nota.');
        }


    }

    // Atiende GET /notas/{id}/edit: muestra el formulario ya relleno.
    public function edit($id)
    {
        $nota = DB::connection('mysql_pruebas')->table('notas')->where('id', $id)->first();
        
        if($nota->user_id === auth()->id()){

            $nota = DB::connection('mysql_pruebas')->table('notas')->where('id', $id)->first();
            $categorias = DB::connection('mysql_pruebas')->table('categorias')->get();
            return view('notas.edit', ['nota' => $nota, 'categorias' => $categorias]);
        }else{
            abort(403, 'No tienes permisos para editar esta nota');
        }
    }
        

    // Atiende PUT /notas/{id}: valida el texto nuevo y actualiza la fila.
    public function update(Request $request, $id)
    {
        $datos = $request->validate([
            'texto' => 'required|string|max:50',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $nota = DB::connection('mysql_pruebas')->table('notas')->where('id', $id)->first();

        if($nota -> user_id === auth()->id()){

            DB::connection('mysql_pruebas')->table('notas')->where('id', $id)->update([
                'texto' => $datos['texto'],
                'categoria_id' => $datos['categoria_id'] ?? null,
                'updated_at' => now(),
            ]);

            return redirect('/notas');

        }else{
            abort(403, 'No tienes permiso para actualizar esta nota.');
        }
    }
}
