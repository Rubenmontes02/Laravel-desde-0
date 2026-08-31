<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TareaController extends Controller
{
    public function index()
    {
        // Lógica para mostrar la lista de tareas
        $tareas = DB::connection('mysql_pruebas')->table('tareas')
            ->leftJoin('proyectos', 'tareas.proyecto_id', '=', 'proyectos.id')
            ->select('tareas.*', 'proyectos.proyecto')
            ->get();

        $proyectos = DB::connection('mysql_pruebas')->table('proyectos')->get();



        return view('tareas.index', ['tareas' => $tareas, 'proyectos' => $proyectos]);
    }

    public function store(Request $request)
    {
        // Lógica para guardar una nueva tarea
        $datos = $request->validate([
            'tarea' => 'required|string|max:100',
            'proyecto_id' => 'nullable|exists:proyectos,id'
        ]);

        $completada = $request->boolean('completada');

        DB::connection('mysql_pruebas')->table('tareas')->insert([
            'tarea' => $datos['tarea'],
            'proyecto_id' => $datos['proyecto_id'] ?? null,
            'completada' => $completada,
        ]);

        return redirect('/tareas');
    }

    public function edit($id)
    {
        // Lógica para mostrar el formulario de edición de una tarea
        $tarea = DB::connection('mysql_pruebas')->table('tareas')->where('id', $id)->first();
        $proyecto = DB::connection('mysql_pruebas')->table('proyectos')->where('id', $tarea->proyecto_id)->first();
        $proyectos = DB::connection('mysql_pruebas')->table('proyectos')->get();

        return view ('tareas.edit', ['tarea' => $tarea, 'proyecto' => $proyecto, 'proyectos' => $proyectos]);
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar una tarea existente
        $datos = $request->validate([
            "tarea" => 'required|string|max:100',
            "proyecto_id" => 'nullable|exists:proyectos,id',
        ]);

        $completada = $request->boolean('completada');

        DB::connection('mysql_pruebas')->table('tareas')->where('id', $id)->update([
            "tarea" => $datos['tarea'],
            "proyecto_id" => $datos['proyecto_id'] ?? null,
            "completada" => $completada,
        ]);

        return redirect('/tareas');

    }

    public function destroy($id)
    {
        // Lógica para eliminar una tarea
        DB::connection('mysql_pruebas')->table('tareas')->where('id', $id)->delete();

        return redirect('/tareas');
    }
}
